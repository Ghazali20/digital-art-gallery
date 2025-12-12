<x-app-layout>
    <div class="pt-20 pb-20">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-6">

                {{-- === HEADER KUSTOM: Panduan === --}}
                <div class="mb-12">
                    <p class="text-sm tracking-widest text-gray-500 font-medium uppercase">PANDUAN</p>
                    <h1 class="text-6xl font-extrabold text-gray-900 mt-2 mb-4">
                        Cara Mengikuti Kompetisi
                    </h1>
                </div>
                {{-- ======================================= --}}

                <div class="space-y-12">

                    {{-- 1. Pendaftaran --}}
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-3 border-b pb-2">01 — Pendaftaran</h2>
                        <p class="text-lg text-gray-700">
                            Pastikan Anda telah terdaftar sebagai **Peserta Aktif** di platform Galeri Seni Mentality. Pilih kompetisi yang sesuai dengan minat dan keahlian Anda melalui halaman Kompetisi Aktif.
                        </p>
                        <ul class="list-disc ml-6 mt-4 text-gray-600">
                            <li>Role **User Standar** harus melakukan *upgrade* terlebih dahulu.</li>
                            <li>Tinjau kriteria kelayakan dan tema yang berlaku untuk kompetisi yang dipilih.</li>
                        </ul>
                    </div>

                    {{-- 2. Persiapan Karya --}}
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-3 border-b pb-2">02 — Persiapan Karya</h2>
                        <p class="text-lg text-gray-700">
                            Baca dengan teliti persyaratan kompetisi, termasuk tema, ukuran file, dan format yang diterima. Pastikan karya Anda orisinal dan belum pernah dipublikasikan di kompetisi lain.
                        </p>
                        <ul class="list-disc ml-6 mt-4 text-gray-600">
                            <li>Gunakan format JPG/PNG dengan resolusi minimal 1920px.</li>
                            <li>Karya harus mencerminkan tema yang diusung oleh penyelenggara kontes.</li>
                        </ul>
                    </div>

                    {{-- 3. Submission --}}
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-3 border-b pb-2">03 — Submission</h2>
                        <p class="text-lg text-gray-700">
                            Unggah karya Anda dengan kualitas terbaik disertai deskripsi yang menarik. Jelaskan konsep dan proses kreatif di balik karya Anda untuk memberikan konteks kepada juri dan pengunjung.
                        </p>
                        <ul class="list-disc ml-6 mt-4 text-gray-600">
                            <li>Gunakan fitur Unggah Karya Baru dan pilih kontes yang dituju.</li>
                            <li>Deskripsi yang mendalam meningkatkan peluang apresiasi.</li>
                        </ul>
                    </div>

                    {{-- 4. Penilaian --}}
                    <div>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-3 border-b pb-2">04 — Penilaian</h2>
                        <p class="text-lg text-gray-700">
                            Karya akan dinilai oleh panel juri profesional berdasarkan orisinalitas, teknik, konsep, dan eksekusi. Pemenang akan diumumkan setelah periode kompetisi berakhir.
                        </p>
                        <ul class="list-disc ml-6 mt-4 text-gray-600">
                            <li>Pengunjung juga dapat berpartisipasi melalui voting.</li>
                            <li>Pemenang akan mendapatkan hadiah dan kesempatan pameran.</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('contests.index') }}" class="text-black hover:text-gray-700 font-semibold underline inline-flex items-center">
                        Lihat Kompetisi Aktif Sekarang &rarr;
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>