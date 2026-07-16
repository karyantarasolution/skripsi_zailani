<section class="p-8 rounded-3xl">
    <header class="mb-6 border-b border-white/5 pb-4">
        <h2 class="text-xl font-black text-white uppercase tracking-tighter">
            Ubah Kata Sandi
        </h2>
        <p class="mt-1 text-sm text-white/40 font-medium">
            Pastikan akun Anda menggunakan kata sandi yang aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full px-4 py-3 rounded-xl glass-input font-bold" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" class="w-full px-4 py-3 rounded-xl glass-input font-bold" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Konfirmasi Sandi Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full px-4 py-3 rounded-xl glass-input font-bold" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-white/5">
            <button type="submit" class="cosmic-btn">Perbarui Sandi</button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-black uppercase tracking-widest text-emerald-400">
                    Sandi Diperbarui!
                </p>
            @endif
        </div>
    </form>
</section>
