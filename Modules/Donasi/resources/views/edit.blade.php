<h1>Edit Katalog Donasi</h1>
 
 
@if ($errors->any())
 
    <ul style="color:red;">
 
        @foreach ($errors->all() as $error)
 
            <li>
                {{ $error }}
            </li>
 
        @endforeach
 
    </ul>
 
@endif
 
 
<form
    action="{{ route('donasi.update', $donasi->id) }}"
    method="POST"
>
 
    @csrf
    @method('PUT')
 
 
    <label>Kode</label>
    <br>
 
    <input
        type="text"
        name="kode"
        value="{{ old('kode', $donasi->kode) }}"
        required
    >
 
    <br><br>
 
 
    <label>Nama</label>
    <br>
 
    <input
        type="text"
        name="nama"
        value="{{ old('nama', $donasi->nama) }}"
        required
    >
 
    <br><br>
 
 
    <label>Deskripsi</label>
    <br>
 
    <textarea
        name="deskripsi"
    >{{ old('deskripsi', $donasi->deskripsi) }}</textarea>
 
    <br><br>
 
 
    <label>Jumlah Porsi</label>
    <br>
 
    <input
        type="number"
        name="jumlah_porsi"
        value="{{ old(
            'jumlah_porsi',
            $donasi->jumlah_porsi
        ) }}"
        min="1"
        required
    >
 
    <br><br>
 
 
    <label>Lokasi Pengambilan</label>
    <br>
 
    <input
        type="text"
        name="lokasi_pengambilan"
        value="{{ old(
            'lokasi_pengambilan',
            $donasi->lokasi_pengambilan
        ) }}"
        required
    >
 
    <br><br>
 
 
    <label>Status</label>
    <br>
 
    <select
        name="status"
        required
    >
 
        <option
            value="Tersedia"
            {{ old( 
                'status',
                $donasi->status
            ) === 'Tersedia' ? 'selected' : '' }}
        >
            Tersedia
        </option>
 
 
        <option
            value="Tidak Tersedia"
            {{ old(
                'status',
                $donasi->status
            ) === 'Tidak Tersedia' ? 'selected' : '' }}
        >
            Tidak Tersedia
        </option>
 
    </select>
 
    <br><br>
 
 
    <button type="submit">
        Update
    </button>
 
 
    <a href="{{ route('donasi.index') }}">
        Kembali
    </a>
 
</form>