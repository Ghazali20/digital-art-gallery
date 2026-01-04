<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil & Portofolio') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi akun, foto profil, dan detail portofolio seniman Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- WAJIB: Menambahkan enctype="multipart/form-data" agar upload foto berfungsi --}}
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- 1. Nama --}}
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 focus:border-black focus:ring-black" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- 2. Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 focus:border-black focus:ring-black" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                {{-- Bagian Verifikasi Email tetap dipertahankan --}}
                <div class="mt-2">
                    <p class="text-sm text-gray-800">
                        {{ __('Alamat email Anda belum terverifikasi.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <hr class="border-gray-100 my-8">

        {{-- 3. Foto Profil (Field Baru) --}}
        <div>
            <x-input-label for="profile_photo" :value="__('Foto Profil')" />
            <div class="flex items-center gap-4 mt-2">
                <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-100 border border-gray-200 shrink-0">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center text-gray-400 font-bold text-xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <input type="file" name="profile_photo" id="profile_photo" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:bg-gray-800 transition">
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        {{-- 4. Bio (Field Baru) --}}
        <div>
            <x-input-label for="bio" :value="__('Biografi Singkat')" />
            <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-black focus:border-black text-sm" placeholder="Ceritakan tentang gaya seni Anda...">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        {{-- 5. Media Sosial (Field Baru) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="instagram_handle" :value="__('Instagram Username')" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-sm">@</span>
                    <x-text-input id="instagram_handle" name="instagram_handle" type="text" class="pl-8 block w-full border-gray-300 focus:border-black focus:ring-black" :value="old('instagram_handle', $user->instagram_handle)" placeholder="username" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('instagram_handle')" />
            </div>
            <div>
                <x-input-label for="portfolio_link" :value="__('Link Portofolio (URL)')" />
                <x-text-input id="portfolio_link" name="portfolio_link" type="url" class="mt-1 block w-full border-gray-300 focus:border-black focus:ring-black" :value="old('portfolio_link', $user->portfolio_link)" placeholder="https://behance.net/username" />
                <x-input-error class="mt-2" :messages="$errors->get('portfolio_link')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button class="bg-black hover:bg-gray-800">
                {{ __('Simpan Semua Perubahan') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>