<section class="p-8 rounded-3xl">
    <header class="mb-6 border-b border-white/5 pb-4">
        <h2 class="text-xl font-black text-white uppercase tracking-tighter">
            Informasi Profil Lengkap
        </h2>
        <p class="mt-1 text-sm text-white/40 font-medium">
            Lengkapi data diri Anda sesuai KTP. Semua kolom bersifat opsional kecuali Nama dan Email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Foto Profil --}}
        <div class="flex items-center gap-6 p-6 bg-white/[0.03] rounded-2xl border border-white/5">
            <div class="relative group">
                @if($user->foto)
                    <img id="preview-foto" src="{{ asset('storage/'.$user->foto) }}" class="w-24 h-24 rounded-2xl object-cover shadow-lg border-2 border-purple-500/30">
                @else
                    <div id="preview-foto" class="w-24 h-24 rounded-2xl bg-gradient-to-br from-purple-500/30 to-cyan-500/30 flex items-center justify-center text-3xl font-black text-purple-300 shadow-lg border-2 border-purple-500/30">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div class="absolute inset-0 bg-black/50 rounded-2xl opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <div class="flex-1">
                <label class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Foto Profil</label>
                <input type="file" name="foto" id="input-foto" accept="image/*" class="w-full cosmic-file-input" onchange="previewImage(this)">
                <p class="mt-1 text-xs text-white/20">Format: JPG, PNG. Maksimal 2MB.</p>
                <x-input-error class="mt-2" :messages="$errors->get('foto')" />
            </div>
        </div>

        {{-- Data Diri --}}
        <div>
            <h3 class="text-sm font-black uppercase tracking-widest mb-4 flex items-center gap-2 gradient-text">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Data Diri
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Nama Lengkap <span class="text-red-400">*</span></label>
                    <input id="name" name="name" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label for="nik" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">NIK (Nomor Induk Kependudukan)</label>
                    <input id="nik" name="nik" type="text" maxlength="16" class="w-full px-4 py-3 rounded-xl glass-input font-bold font-mono" value="{{ old('nik', $user->nik) }}" placeholder="16 digit NIK" autocomplete="nik" />
                    <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                </div>

                @if($user->isStaff())
                <div>
                    <label for="nip" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">NIP (Nomor Induk Pegawai)</label>
                    <input id="nip" name="nip" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold font-mono" value="{{ old('nip', $user->nip) }}" placeholder="NIP pegawai" autocomplete="nip" />
                    <x-input-error class="mt-2" :messages="$errors->get('nip')" />
                </div>

                <div>
                    <label for="jabatan" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Jabatan</label>
                    <input id="jabatan" name="jabatan" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('jabatan', $user->jabatan) }}" placeholder="Contoh: Kasir, Desainer" autocomplete="jabatan" />
                    <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
                </div>
                @endif

                <div>
                    <label for="tempat_lahir" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Tempat Lahir</label>
                    <input id="tempat_lahir" name="tempat_lahir" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" placeholder="Contoh: Banjarmasin" />
                    <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
                </div>

                <div>
                    <label for="tanggal_lahir" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Tanggal Lahir</label>
                    <input id="tanggal_lahir" name="tanggal_lahir" type="date" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                </div>

                <div>
                    <label for="jenis_kelamin" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="w-full cosmic-select">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                </div>

                <div>
                    <label for="agama" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Agama</label>
                    <select id="agama" name="agama" class="w-full cosmic-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $a)
                            <option value="{{ $a }}" {{ old('agama', $user->agama) == $a ? 'selected' : '' }}>{{ $a }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('agama')" />
                </div>

                <div>
                    <label for="status_kawin" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Status Perkawinan</label>
                    <select id="status_kawin" name="status_kawin" class="w-full cosmic-select">
                        <option value="">-- Pilih --</option>
                        @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $s)
                            <option value="{{ $s }}" {{ old('status_kawin', $user->status_kawin) == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status_kawin')" />
                </div>
            </div>
        </div>

        {{-- Kontak --}}
        <div>
            <h3 class="text-sm font-black uppercase tracking-widest mb-4 flex items-center gap-2 gradient-text">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Kontak & Email
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="email" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Alamat Email <span class="text-red-400">*</span></label>
                    <input id="email" name="email" type="email" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-3 p-4 bg-amber-500/10 rounded-xl border border-amber-500/20">
                            <p class="text-sm font-bold text-amber-300">
                                Email belum diverifikasi.
                                <button form="send-verification" class="underline hover:text-amber-200 ml-1">Kirim ulang.</button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-black text-xs uppercase tracking-widest text-emerald-400">Tautan baru telah dikirim!</p>
                            @endif
                        </div>
                    @endif
                </div>

                <div>
                    <label for="telepon" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Nomor Telepon / WA</label>
                    <input id="telepon" name="telepon" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('telepon', $user->telepon) }}" placeholder="081234567890" />
                    <x-input-error class="mt-2" :messages="$errors->get('telepon')" />
                </div>
            </div>
        </div>

        {{-- Alamat --}}
        <div>
            <h3 class="text-sm font-black uppercase tracking-widest mb-4 flex items-center gap-2 gradient-text">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Alamat Lengkap (Sesuai KTP)
            </h3>
            <div class="space-y-5">
                <div>
                    <label for="alamat" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Alamat Jalan</label>
                    <textarea id="alamat" name="alamat" rows="2" class="w-full px-4 py-3 rounded-xl cosmic-textarea font-bold" placeholder="Contoh: Jl. Kayu Tangi No. 123">{{ old('alamat', $user->alamat) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    <div>
                        <label for="rt_rw" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">RT / RW</label>
                        <input id="rt_rw" name="rt_rw" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('rt_rw', $user->rt_rw) }}" placeholder="001/002" />
                        <x-input-error class="mt-2" :messages="$errors->get('rt_rw')" />
                    </div>
                    <div>
                        <label for="kelurahan" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Kelurahan</label>
                        <input id="kelurahan" name="kelurahan" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('kelurahan', $user->kelurahan) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('kelurahan')" />
                    </div>
                    <div>
                        <label for="kecamatan" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Kecamatan</label>
                        <input id="kecamatan" name="kecamatan" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('kecamatan', $user->kecamatan) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('kecamatan')" />
                    </div>
                    <div>
                        <label for="kabupaten" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Kabupaten/Kota</label>
                        <input id="kabupaten" name="kabupaten" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('kabupaten', $user->kabupaten) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('kabupaten')" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="provinsi" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Provinsi</label>
                        <input id="provinsi" name="provinsi" type="text" class="w-full px-4 py-3 rounded-xl glass-input font-bold" value="{{ old('provinsi', $user->provinsi) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('provinsi')" />
                    </div>
                    <div>
                        <label for="kode_pos" class="block text-xs font-black uppercase tracking-widest text-white/30 mb-2">Kode Pos</label>
                        <input id="kode_pos" name="kode_pos" type="text" maxlength="5" class="w-full px-4 py-3 rounded-xl glass-input font-bold font-mono" value="{{ old('kode_pos', $user->kode_pos) }}" placeholder="70000" />
                        <x-input-error class="mt-2" :messages="$errors->get('kode_pos')" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-white/5">
            <button type="submit" class="cosmic-btn">Simpan Perubahan</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-xs font-black uppercase tracking-widest text-emerald-400">
                    Berhasil Disimpan!
                </p>
            @endif
        </div>
    </form>
</section>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('preview-foto');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                var img = document.createElement('img');
                img.id = 'preview-foto';
                img.src = e.target.result;
                img.className = 'w-24 h-24 rounded-2xl object-cover shadow-lg border-2 border-purple-500/30';
                preview.parentNode.replaceChild(img, preview);
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
