<section class="p-8 rounded-3xl bg-red-500/5 border border-red-500/15 space-y-6">
    <header class="mb-6 border-b border-red-500/10 pb-4">
        <h2 class="text-xl font-black text-red-400 uppercase tracking-tighter">
            Hapus Akun Permanen
        </h2>
        <p class="mt-1 text-sm text-red-400/60 font-medium">
            Setelah akun dihapus, semua data akan hilang secara permanen.
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="cosmic-btn cosmic-btn-danger">
        Hapus Akun Saya
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-white uppercase tracking-tighter">
                Yakin ingin menghapus akun?
            </h2>

            <p class="mt-2 text-sm text-white/40 font-medium">
                Tindakan ini tidak bisa dibatalkan. Masukkan kata sandi untuk konfirmasi.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Password</label>
                <input id="password" name="password" type="password" class="w-full px-4 py-3 rounded-xl glass-input font-bold" placeholder="Masukkan Kata Sandi" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="cosmic-btn-outline">Batal</button>
                <button type="submit" class="cosmic-btn cosmic-btn-danger">Ya, Hapus</button>
            </div>
        </form>
    </x-modal>
</section>
