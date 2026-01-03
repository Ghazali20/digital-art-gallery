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
        // Hanya ambil kontes yang dicentang AKTIF dan BELUM BERAKHIR
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
        // Pastikan kontes aktif dan belum berakhir secara waktu
        if (!$contest->is_active || \Carbon\Carbon::parse($contest->end_date)->isPast()) {
             return redirect()->route('contests.index')->with('error', 'Kontes ini sudah berakhir atau tidak aktif.');
        }

        $entries = $contest->entries()
                           ->withCount('votes')
                           ->with('artwork.user')
                           ->orderBy('votes_count', 'desc')
                           ->get();

        $hasVoted = false;
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $hasVoted = Vote::whereIn('contest_entry_id', $entries->pluck('id'))
                            ->where('user_id', Auth::id())
                            ->exists();
        }

        return view('contests.show', compact('contest', 'entries', 'hasVoted'));
    }

    /**
     * Menampilkan form bagi user untuk memilih karyanya yang akan di-submit.
     */
    public function createEntry(Contest $contest)
    {
        if (!Auth::check()) return redirect()->route('login');

        if (Auth::user()->role !== 'peserta') {
            return redirect()->route('contests.show', $contest)->with('error', 'Akses ditolak. Hanya peserta yang dapat mendaftarkan karya.');
        }

        if (!$contest->is_active || \Carbon\Carbon::parse($contest->end_date)->isPast()) {
            return redirect()->route('contests.show', $contest)->with('error', 'Pendaftaran kontes ini sudah ditutup.');
        }

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
        if (Auth::user()->role !== 'peserta') {
            return redirect()->route('contests.show', $contest)->with('error', 'Akses ditolak.');
        }

        if (!$contest->is_active || \Carbon\Carbon::parse($contest->end_date)->isPast()) {
            return redirect()->route('contests.show', $contest)->with('error', 'Pendaftaran ditutup.');
        }

        $request->validate(['artwork_id' => 'required|exists:artworks,id']);

        ContestEntry::create([
            'contest_id' => $contest->id,
            'artwork_id' => $request->artwork_id
        ]);

        return redirect()->route('contests.show', $contest)->with('success', 'Karya berhasil didaftarkan!');
    }

    /**
     * Memproses Voting.
     */
    public function vote(Request $request, ContestEntry $contestEntry)
    {
        if (!Auth::check()) return redirect()->route('login');

        $contest = $contestEntry->contest;

        if (Auth::user()->role === 'admin') {
            return redirect()->route('contests.show', $contest)->with('error', 'Admin tidak boleh vote.');
        }

        if ($contest->start_date > now() || $contest->end_date < now()) {
             return redirect()->route('contests.show', $contest)->with('error', 'Periode voting tidak valid.');
        }

        Vote::create([
            'contest_entry_id' => $contestEntry->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('contests.show', $contest)->with('success', 'Suara Anda telah dicatat!');
    }
}