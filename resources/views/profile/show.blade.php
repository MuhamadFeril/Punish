@extends('layouts.app')

@section('content')
<style>
    .profile-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 24px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 16px rgba(15, 23, 42, 0.08);
    }

    .profile-header {
        text-align: center;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 2px solid #e5e7eb;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .profile-title {
        font-size: 28px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .profile-role {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        background: #dbeafe;
        color: #1e40af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-role.admin {
        background: #fee2e2;
        color: #991b1b;
    }

    .profile-info {
        margin-bottom: 24px;
    }

    .info-row {
        display: flex;
        margin-bottom: 20px;
        align-items: center;
    }

    .info-label {
        font-weight: 600;
        color: #6b7280;
        min-width: 120px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 15px;
        color: #1f2937;
        flex: 1;
    }

    .info-value.email {
        word-break: break-all;
    }

    .profile-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #1f2937;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .alert {
        padding: 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-icon {
        font-size: 18px;
    }
</style>

<div class="profile-container">
    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="profile-header">
        <div class="profile-avatar">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <h1 class="profile-title">{{ $user->name }}</h1>
        <span class="profile-role {{ $user->role === 'admin' ? 'admin' : '' }}">
            {{ $user->role === 'admin' ? '👨‍💼 Admin' : '👤 User' }}
        </span>
    </div>

    <div class="profile-info">
        <div class="info-row">
            <div class="info-label">📧 Email</div>
            <div class="info-value email">{{ $user->email }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">🏢 Role</div>
            <div class="info-value">{{ ucfirst($user->role) }}</div>
        </div>

        <div class="info-row">
            <div class="info-label">📅 Bergabung</div>
            <div class="info-value">{{ $user->created_at->format('d M Y') }}</div>
        </div>
    </div>

    <div class="profile-actions">
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            ✏️ Edit Profil
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            ⬅️ Kembali
        </a>
    </div>
</div>
@endsection
