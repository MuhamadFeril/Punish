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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .page-subtitle {
        font-size: 16px;
        color: #6b7280;
        margin-top: 4px;
    }

    .back-btn {
        background-color: #e5e7eb;
        color: #374151;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .back-btn:hover {
        background-color: #d1d5db;
        transform: translateY(-2px);
    }
    
    .table-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        animation: fadeIn 0.5s ease-out backwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
    
    tbody tr:nth-child(1) { animation-delay: 0.1s; }
    tbody tr:nth-child(2) { animation-delay: 0.2s; }
    tbody tr:nth-child(3) { animation-delay: 0.3s; }
    tbody tr:nth-child(4) { animation-delay: 0.4s; }
    tbody tr:nth-child(5) { animation-delay: 0.5s; }
    
    tbody tr:hover {
        background-color: #f9fafb;
        box-shadow: inset 0 0 0 1px rgba(102, 126, 234, 0.1);
    }
    
    .employee-name {
        font-weight: 600;
        color: #1f2937;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-aktif {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-non-aktif {
        background-color: #fee2e2;
        color: #991b1b;
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

    .action-btn {
        background-color: #dbeafe;
        color: #1e40af;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background-color: #bfdbfe;
        transform: translateY(-1px);
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">🏢 Detail Departemen</h1>
        <p class="page-subtitle">{{ $departemen->nama_departemen }}</p>
    </div>
    <div>
        <a href="{{ route('departemen.index.web') }}" class="back-btn">⬅️ Kembali</a>
    </div>
</div>

<div class="table-card">
    <div style="padding: 20px; border-bottom: 1px solid #e5e7eb;">
        <h2 style="font-size: 18px; font-weight: 600; color: #1f2937; margin: 0;">👥 Daftar Karyawan</h2>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>👤 Nama Karyawan</th>
                    <th>✉️ Email</th>
                    <th>💼 Jabatan</th>
                    <th>📊 Status</th>
                    <th>🎯 Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departemen->karyawan as $karyawan)
                    <tr>
                        <td class="employee-name">{{ $karyawan->nama_karyawan }}</td>
                        <td>{{ $karyawan->email_karyawan }}</td>
                        <td>{{ $karyawan->jabatan_karyawan }}</td>
                        <td>
                            <span class="status-badge {{ $karyawan->status === 'aktif' ? 'status-aktif' : 'status-non-aktif' }}">
                                {{ ucfirst($karyawan->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('karyawan.show.web', $karyawan->id) }}" class="action-btn">👁️ Lihat Karyawan</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">👥</div>
                                <div class="empty-state-text">Belum ada karyawan di departemen ini</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
