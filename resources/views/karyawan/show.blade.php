@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-semibold">{{ $karyawan->nama_karyawan }}</h1>
        <p class="text-gray-600">Detail Karyawan</p>
    </div>
    <div class="flex gap-2">
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-primary">Edit</a>
        @endif
        <a href="{{ route('karyawan.index.web') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="card">
        @if($karyawan->foto_karyawan)
            <img src="{{ asset('storage/' . $karyawan->foto_karyawan) }}" alt="{{ $karyawan->nama_karyawan }}" class="w-full rounded-md mb-4">
        @else
            <div class="bg-gray-200 w-full aspect-square rounded-md mb-4 flex items-center justify-center">
                <span class="text-gray-400">No Image</span>
            </div>
        @endif
        <p class="text-sm text-gray-600">Foto Profil</p>
    </div>

    <div class="md:col-span-2">
        <div class="card">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="text-lg font-semibold">{{ $karyawan->nama_karyawan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="text-lg font-semibold">{{ $karyawan->email_karyawan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Departemen</p>
                    <p class="text-lg font-semibold">{{ $karyawan->departemen->nama_departemen }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jabatan</p>
                    <p class="text-lg font-semibold">{{ $karyawan->jabatan_karyawan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="text-lg font-semibold">{{ $karyawan->alamat_karyawan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="inline-block px-3 py-1 rounded-full text-sm {{ $karyawan->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($karyawan->status) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 class="text-xl font-semibold mb-4">Riwayat Pelanggaran</h2>
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Jenis Pelanggaran</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawan->pelanggaran as $pelanggaran)
                        <tr>
                            <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                            <td>{{ $pelanggaran->tanggal_pelanggaran }}</td>
                            <td>{{ Str::limit($pelanggaran->keterangan_pelanggaran, 50) }}</td>
                            <td>
                                <a href="{{ route('pelanggaran.show.web', $pelanggaran->id) }}" class="btn btn-secondary btn-sm">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-600 py-4">Tidak ada riwayat pelanggaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
