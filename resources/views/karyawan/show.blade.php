@extends('layouts.app')

@section('content')
@php
    $isActive = $karyawan->status === 'aktif';
    $pelanggaranCount = $karyawan->pelanggaran->count();
    $initials = collect(explode(' ', $karyawan->nama_karyawan))
        ->filter()
        ->map(fn ($word) => mb_substr($word, 0, 1))
        ->take(2)
        ->implode('');
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-indigo-600">Detail Karyawan</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-950 sm:text-3xl">{{ $karyawan->nama_karyawan }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $karyawan->jabatan_karyawan }} - {{ $karyawan->departemen->nama_departemen ?? 'Tanpa Departemen' }}</p>
        </div>
        <div class="flex flex-col gap-2 min-[420px]:flex-row">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('karyawan.edit.web', $karyawan->id) }}" class="btn-primary-modern px-5 text-sm">Edit Data</a>
            @endif
            <a href="{{ route('karyawan.index.web') }}" class="btn-secondary-modern px-5 text-sm">Kembali</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[22rem_minmax(0,1fr)]">
        <aside class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            @if($karyawan->foto_karyawan)
                <img src="{{ asset('storage/' . $karyawan->foto_karyawan) }}" alt="{{ $karyawan->nama_karyawan }}" class="aspect-square w-full rounded-xl object-cover">
            @else
                <div class="flex aspect-square w-full items-center justify-center rounded-xl bg-gradient-to-br from-indigo-50 to-slate-100 text-5xl font-bold text-indigo-500">
                    {{ $initials ?: 'K' }}
                </div>
            @endif

            <div class="mt-5 space-y-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Status</p>
                    <span class="mt-2 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $isActive ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                        {{ $isActive ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Pelanggaran</p>
                        <p class="mt-1 text-2xl font-bold text-slate-950">{{ $pelanggaranCount }}</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Departemen</p>
                        <p class="mt-1 truncate text-base font-bold text-slate-950">{{ $karyawan->departemen->nama_departemen ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="space-y-6">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-slate-950">Informasi Karyawan</h2>
                    <p class="mt-1 text-sm text-slate-500">Data utama yang tersimpan di sistem.</p>
                </div>

                <dl class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nama Lengkap</dt>
                        <dd class="mt-1 break-words text-base font-bold text-slate-950">{{ $karyawan->nama_karyawan }}</dd>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email</dt>
                        <dd class="mt-1 break-all text-base font-bold text-slate-950">{{ $karyawan->email_karyawan }}</dd>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Departemen</dt>
                        <dd class="mt-1 text-base font-bold text-slate-950">{{ $karyawan->departemen->nama_departemen ?? '-' }}</dd>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Jabatan</dt>
                        <dd class="mt-1 text-base font-bold text-slate-950">{{ $karyawan->jabatan_karyawan }}</dd>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Alamat</dt>
                        <dd class="mt-1 break-words text-base font-bold text-slate-950">{{ $karyawan->alamat_karyawan ?: '-' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-5 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950">Riwayat Pelanggaran</h2>
                        <p class="text-sm text-slate-500">{{ $pelanggaranCount }} catatan pelanggaran ditemukan.</p>
                    </div>
                </div>

                @if($pelanggaranCount)
                    <div class="overflow-hidden rounded-xl border border-slate-200">
                        <div class="table-wrapper">
                            <table class="w-full min-w-[720px]">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Jenis</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Keterangan</th>
                                        <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wide text-slate-500">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 bg-white">
                                    @foreach($karyawan->pelanggaran as $pelanggaran)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-4 py-4 text-sm font-semibold text-slate-950">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                            <td class="px-4 py-4 text-sm text-slate-600">{{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran)->format('d M Y') }}</td>
                                            <td class="px-4 py-4 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($pelanggaran->keterangan_pelanggaran, 90) }}</td>
                                            <td class="px-4 py-4 text-right">
                                                <a href="{{ route('pelanggaran.show.web', $pelanggaran->id) }}" class="inline-flex rounded-lg border border-indigo-100 bg-indigo-50 px-3 py-2 text-xs font-bold text-indigo-700 hover:bg-indigo-100">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                        <p class="text-base font-bold text-slate-950">Belum ada riwayat pelanggaran</p>
                        <p class="mt-1 text-sm text-slate-500">Catatan pelanggaran karyawan akan tampil di sini.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
