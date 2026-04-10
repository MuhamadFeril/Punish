@extends('layouts.app')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        animation: slideInDown 0.5s ease-out;
    }
    
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
    }
    
    .search-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        animation: fadeIn 0.5s ease-out;
    }
    
    .search-form {
        display: flex;
        gap: 12px;
    }
    
    .search-input {
        flex: 1;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .search-input::placeholder {
        color: #d1d5db;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .table-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        animation: fadeIn 0.5s ease-out 0.2s backwards;
    }
    
    .table-wrapper {
        overflow-x: auto;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    thead tr {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    }
    
    th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 14px;
        letter-spacing: 0.5px;
    }
    
    td {
        padding: 16px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
    }
    
    tbody tr {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeIn 0.3s ease-out backwards;
    }
    
    tbody tr:nth-child(1) { animation-delay: 0.3s; }
    tbody tr:nth-child(2) { animation-delay: 0.35s; }
    tbody tr:nth-child(3) { animation-delay: 0.4s; }
    tbody tr:nth-child(4) { animation-delay: 0.45s; }
    tbody tr:nth-child(5) { animation-delay: 0.5s; }
    
    tbody tr:hover {
        background-color: #f9fafb;
        box-shadow: inset 0 0 0 1px rgba(102, 126, 234, 0.1);
    }
    
    .employee-name {
        font-weight: 600;
        color: #1f2937;
    }
    
    .violation-type {
        color: #6b7280;
    }
    
    .violation-date {
        color: #9ca3af;
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    .btn {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
    }
    
    .btn-detail {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .btn-detail:hover {
        background-color: #bfdbfe;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
    }
    
    .btn-edit {
        background-color: #fef3c7;
        color: #b45309;
    }
    
    .btn-edit:hover {
        background-color: #fde68a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(180, 83, 9, 0.2);
    }
    
    .btn-delete {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .btn-delete:hover {
        background-color: #fecaca;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(153, 27, 27, 0.2);
    }
    
    .btn-create {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 18px;
    }
    
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }
    
    .empty-state-text {
        font-size: 16px;
        margin-bottom: 20px;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
        padding: 20px;
    }
    
    .pagination a,
    .pagination span {
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        text-decoration: none;
        color: #667eea;
        transition: all 0.3s ease;
    }
    
    .pagination a:hover {
        background-color: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    .pagination .active {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
    }
    
    .description-preview {
        color: #6b7280;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="page-header">
    <h1 class="page-title">📋 Daftar Pelanggaran</h1>
    <a href="{{ route('pelanggaran.create.web') }}" class="btn btn-create">
        ➕ Lapor Pelanggaran
    </a>
</div>

<div class="search-card">
    <form action="{{ route('pelanggaran.index.web') }}" method="GET" class="search-form">
        <input 
            type="text" 
            name="search" 
            placeholder="🔍 Cari berdasarkan nama karyawan atau keterangan..." 
            class="search-input"
            value="{{ request('search') }}"
        >
        <button type="submit" class="btn btn-create">
            Cari
        </button>
    </form>
</div>

<div class="table-card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>👤 Karyawan</th>
                    <th>⚠️ Jenis Pelanggaran</th>
                    <th>📅 Tanggal</th>
                    <th>📝 Keterangan</th>
                    <th>🎯 Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggaran as $item)
                    <tr>
                        <td class="employee-name">{{ $item->karyawan->nama_karyawan }}</td>
                        <td class="violation-type">{{ $item->jenisPelanggaran->nama_pelanggaran }}</td>
                        <td class="violation-date">{{ \Carbon\Carbon::parse($item->tanggal_pelanggaran)->format('d-m-Y') }}</td>
                        <td class="description-preview" title="{{ $item->keterangan_pelanggaran }}">
                            {{ Str::limit($item->keterangan_pelanggaran, 50) }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('pelanggaran.show.web', $item->id) }}" class="btn btn-detail">👁️ Detail</a>
                                <a href="{{ route('pelanggaran.edit.web', $item->id) }}" class="btn btn-edit">✏️ Edit</a>
                                <form action="{{ route('pelanggaran.destroy.web', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">📭</div>
                                <div class="empty-state-text">Tidak ada data pelanggaran</div>
                                    <a href="{{ route('pelanggaran.create.web') }}" class="btn btn-create">
                                    ➕ Buat Pelanggaran Baru
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($pelanggaran instanceof \Illuminate\Pagination\Paginator)
    <div class="pagination">
        {{ $pelanggaran->links() }}
    </div>
@endif
@endsection
