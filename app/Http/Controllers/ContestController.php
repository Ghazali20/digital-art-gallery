<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Artwork;
use App\Models\ContestEntry;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ContestController extends Controller
{
    /**
     * Menampilkan daftar Kontes yang sedang Aktif atau Akan Datang.
     */
    public function index()
    {
        // Ambil kontes yang aktif dan belum berakhir
        $contests = Contest::where('is_active', true)
                           ->where('end_date', '>', now())
                           ->orderBy('start_date', 'asc')
                           ->paginate(10);

        return view('contests.index', compact('contests'));
    }

    /**
     * Menampilkan detail Kontes dan Entri Karya untuk voting.
     */
    public function show(Contest $contest)
    {
        // Pastikan kontes aktif dan belum berakhir
        if (!$contest->is_active || $contest->end_date < now()) {
             return redirect()->route('contests.index')->with('error', 'Kontes ini sudah berakhir atau tidak aktif.');
        }

        // Ambil semua entri karya yang berpartisipasi dalam kontes ini
        $entries = $contest->entries()
                           ->withCount('votes')
                           ->with('artwork.user')
                           ->orderBy('votes_count', 'desc')
                           ->get();

        // Cek apakah user sudah vote di kontes ini
        $hasVoted = false;
        if (Auth::check()) {
            // Admin tidak boleh vote, jadi kita tidak perlu mengecek vote mereka (tapi validasi utama ada di method vote)
            if (Auth::user()->role !== 'admin') {
                $hasVoted = Vote::whereIn('contest_entry_id', $entries->pluck('id'))
                                ->where('user_id', Auth::id())
                                ->exists();
            }
        }

        // Kirim semua data ke view
        return view('contests.show', compact('contest', 'entries', 'hasVoted'));
    }

    /**
     * Menampilkan form bagi user untuk memilih karyanya yang akan di-submit.
     */
    public function createEntry(Contest $contest)
    {
        // Pastikan user terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // === VALIDASI PERAN BARU: HANYA PESERTA yang bisa mendaftar ===
        if (Auth::user()->role !== 'peserta') {
            return redirect()->route('contests.show', $contest)->with('error', 'Akses ditolak. Hanya peserta yang terdaftar yang dapat mendaftarkan karya.');
        }
        // =============================================================

        // Pendaftaran ditutup saat end_date terlewati
        if (!$contest->is_active || $contest->end_date < now()) {
            return redirect()->route('contests.show', $contest)->with('error', 'Pendaftaran kontes ini sudah ditutup.');
        }

        // Ambil semua karya user (peserta) yang sudah disetujui
        $availableArtworks = Artwork::where('user_id', Auth::id())
                                    ->where('is_approved', true)
                                    ->whereDoesntHave('contestEntries', function (Builder $query) use ($contest) {
                                        $query->where('contest_id', $contest->id);
                                    })
                                    ->get();

        return view('contests.submit', compact('contest', 'availableArtworks'));
    }

    /**
     * Menyimpan Entri Karya (Submission) ke Kontes.
     */
    public function storeEntry(Request $request, Contest $contest)
    {
        // === VALIDASI PERAN BARU: HANYA PESERTA yang bisa menyimpan entri ===
        if (Auth::user()->role !== 'peserta') {
            return redirect()->route('contests.show', $contest)->with('error', 'Akses ditolak. Hanya peserta yang terdaftar yang dapat mendaftarkan karya.');
        }
        // ===================================================================

        // Pendaftaran ditutup saat end_date terlewati
        if (!$contest->is_active || $contest->end_date < now()) {
            return redirect()->route('contests.show', $contest)->with('error', 'Pendaftaran kontes ini sudah ditutup.');
        }

        $request->validate(['artwork_id' => 'required|exists:artworks,id']);
        $artworkId = $request->artwork_id;

        // Cek apakah karya sudah terdaftar (double check)
        $exists = ContestEntry::where('contest_id', $contest->id)
                              ->where('artwork_id', $artworkId)
                              ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Karya seni ini sudah terdaftar di kontes.');
        }

        ContestEntry::create([
            'contest_id' => $contest->id,
            'artwork_id' => $artworkId
        ]);

        return redirect()->route('contests.show', $contest)->with('success', 'Karya seni Anda berhasil didaftarkan ke kontes!');
    }

    /**
     * Memproses Voting dari User.
     */
    public function vote(Request $request, ContestEntry $contestEntry)
    {
        // Pastikan user terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $contest = $contestEntry->contest;

        // === VALIDASI PERAN BARU: ADMIN TIDAK BOLEH VOTE ===
        if (Auth::user()->role === 'admin') {
            return redirect()->route('contests.show', $contest)->with('error', 'Administrator tidak diizinkan memberikan suara.');
        }
        // ===================================================

        // Cek apakah user sudah vote di kontes ini (batasan 1 vote per kontes per user)
        $hasVoted = Vote::whereIn('contest_entry_id', $contest->entries->pluck('id'))
                        ->where('user_id', Auth::id())
                        ->exists();

        if ($hasVoted) {
            return redirect()->route('contests.show', $contest)->with('error', 'Anda sudah memberikan suara di kontes ini.');
        }

        // Cek periode voting
        if ($contest->start_date > now() || $contest->end_date < now()) {
             return redirect()->route('contests.show', $contest)->with('error', 'Voting belum dimulai atau sudah berakhir.');
        }

        // Cek apakah user mencoba vote karya miliknya sendiri
        if ($contestEntry->artwork->user_id === Auth::id()) {
            return redirect()->route('contests.show', $contest)->with('error', 'Anda tidak dapat memilih karya Anda sendiri.');
        }

        // Simpan Vote
        Vote::create([
            'contest_entry_id' => $contestEntry->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('contests.show', $contest)->with('success', 'Terima kasih, suara Anda telah dicatat!');
    }
}