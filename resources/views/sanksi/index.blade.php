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
    
    .sanction-type {
        color: #6b7280;
        font-weight: 500;
    }
    
    .sanction-date {
        color: #9ca3af;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-aktif {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .status-selesai {
        background-color: #d1fae5;
        color: #065f46;
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
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">⚖️ Daftar Sanksi</h1>
        <p class="page-subtitle">Pantau semua sanksi karyawan, unduh surat peringatan, dan kelola statusnya di sini.</p>
    </div>
    <div class="action-buttons">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('sanksi.create') }}" class="btn btn-primary">➕ Tambah Sanksi</a>
        @endif
    </div>
</div>

<div class="table-card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>👤 Karyawan</th>
                    <th>⚖️ Jenis Sanksi</th>
                    <th>📅 Tanggal</th>
                    <th>📊 Status</th>
                    <th>🎯 Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sanksi as $item)
                    <tr>
                        <td class="employee-name">{{ $item->pelanggaran->karyawan->nama_karyawan }}</td>
                        <td class="sanction-type">{{ ucfirst($item->jenis_sanksi) }}</td>
                        <td class="sanction-date">{{ \Carbon\Carbon::parse($item->tanggal_sanksi)->format('d-m-Y') }}</td>
                        <td>
                            <span class="status-badge {{ $item->status === 'aktif' ? 'status-aktif' : 'status-selesai' }}">
                                {{ $item->status === 'aktif' ? '⏳ Aktif' : '✅ Selesai' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('sanksi.show', $item->id) }}" class="btn btn-detail">👁️ Detail</a>
                                <a href="{{ route('sanksi.download', $item->id) }}" class="btn btn-detail" style="background:#2563eb;color:#fff;">📥 PDF</a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('sanksi.edit', $item->id) }}" class="btn btn-detail" style="background:#fef3c7;color:#92400e;">✏️ Edit</a>
                                    <form action="{{ route('sanksi.destroy.admin', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-detail" style="background:#fee2e2;color:#991b1b;">🗑️ Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">⚖️</div>
                                <div class="empty-state-text">Belum ada data sanksi yang tercatat</div>
                                <p class="text-sm text-gray-500">Sanksi akan muncul setelah pelanggaran diproses.</p>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('sanksi.create') }}" class="btn btn-primary" style="margin-top:16px; display:inline-block;">Tambah Sanksi Sekarang</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($sanksi instanceof \Illuminate\Pagination\Paginator)
    <div class="pagination">
        {{ $sanksi->links() }}
    </div>
@endif
@endsection
