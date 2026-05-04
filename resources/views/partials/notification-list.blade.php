@php
    $notifications = $notifications ?? collect();
    $unreadNotificationCount = $unreadNotificationCount ?? 0;
@endphp

<div class="notification-card">
    <h3 class="section-title">{{ $title ?? 'Notifikasi' }}</h3>
    <p class="notification-summary">{{ $unreadNotificationCount }} notifikasi belum dibaca.</p>

    @if($notifications->isEmpty())
        <p class="notification-empty">Belum ada notifikasi untuk akun ini.</p>
    @else
        <div class="notification-list">
            @foreach($notifications as $notification)
                <a href="{{ $notification->data['link'] ?? '#' }}" class="notification-item {{ is_null($notification->read_at) ? 'unread' : '' }}">
                    <div class="notification-title-row">
                        <strong>{{ $notification->data['title'] ?? 'Notifikasi' }}</strong>
                        <span>{{ $notification->created_at?->diffForHumans() }}</span>
                    </div>
                    <p>{{ $notification->data['message'] ?? '-' }}</p>
                </a>
            @endforeach
        </div>
    @endif
</div>
