import './bootstrap';
import { createApp } from 'vue';
import MobileLayout from './Components/MobileLayout.vue';

const el = document.getElementById('vue-app');
if (el) {
    const app = createApp(MobileLayout, {
        // Pass data from Blade via data attributes
        userName: el.dataset.userName || 'User',
        userRole: el.dataset.userRole || 'user',
        userAvatar: el.dataset.userAvatar || '',
        csrfToken: el.dataset.csrfToken || '',
        logoutUrl: el.dataset.logoutUrl || '/logout',
        dashboardUrl: el.dataset.dashboardUrl || '/dashboard',
    });
    app.mount('#vue-app');
}
