@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-semibold">Detail Pelanggaran</h1>
        <p class="text-gray-600">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('pelanggaran.edit.web', $pelanggaran->id) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('pelanggaran.index.web') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @if($pelanggaran->bukti_pelanggaran)
        <div class="card">
            <img src="{{ asset('storage/' . $pelanggaran->bukti_pelanggaran) }}" alt="Bukti" class="w-full rounded-md" style="max-height: 400px; object-fit: cover;">
            <p class="text-sm text-gray-600 mt-2">Bukti Pelanggaran</p>
        </div>
    @endif

    <div class="md:col-span-{{ $pelanggaran->bukti_pelanggaran ? 2 : 3 }}">
        <div class="card">
            <h2 class="text-lg font-semibold mb-4">Informasi Pelanggaran</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Karyawan</p>
                    <p class="text-lg font-semibold">
                        <a href="{{ route('karyawan.show.web', $pelanggaran->karyawan->id) }}" class="text-blue-600 hover:underline">
                            {{ $pelanggaran->karyawan->nama_karyawan }}
                        </a>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Departemen</p>
                    <p class="text-lg font-semibold">{{ $pelanggaran->karyawan->departemen->nama_departemen }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jenis Pelanggaran</p>
                    <p class="text-lg font-semibold">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tingkat</p>
                    <p class="inline-block px-3 py-1 rounded-full text-sm {{ $pelanggaran->jenisPelanggaran->tingkat_pelanggaran === 'ringan' ? 'bg-yellow-100 text-yellow-800' : ($pelanggaran->jenisPelanggaran->tingkat_pelanggaran === 'sedang' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($pelanggaran->jenisPelanggaran->tingkat_pelanggaran) }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal Pelanggaran</p>
                    <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran)->format('d-m-Y') }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 class="text-lg font-semibold mb-4">Keterangan</h2>
            <p class="text-gray-600 leading-relaxed">{{ $pelanggaran->keterangan_pelanggaran }}</p>
        </div>

        @if($pelanggaran->sanksi->count() > 0)
            <div class="card border-2 border-red-300">
                <h2 class="text-lg font-semibold mb-4 text-red-600">Sanksi yang Diberikan</h2>
                @foreach($pelanggaran->sanksi as $sanksi)
                    <div class="space-y-2 mb-4 pb-4 border-b last:border-b-0">
                        <div>
                            <p class="text-sm text-gray-600">Jenis Sanksi</p>
                            <p class="text-lg font-semibold">{{ ucfirst($sanksi->jenis_sanksi) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Sanksi</p>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($sanksi->tanggal_sanksi)->format('d-m-Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="inline-block px-3 py-1 rounded-full text-sm {{ $sanksi->status === 'aktif' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($sanksi->status) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Keterangan</p>
                            <p class="text-gray-600">{{ $sanksi->keterangan_sanksi }}</p>
                        </div>
                        <div>
                            <a href="{{ route('sanksi.show.web', $sanksi->id) }}" class="btn btn-secondary">Lihat Detail Sanksi</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card border-2 border-yellow-300 bg-yellow-50">
                <p class="text-yellow-800">⚠️ Belum ada sanksi yang diberikan untuk pelanggaran ini</p>
            </div>
        @endif
    </div>
</div>
@endsection
