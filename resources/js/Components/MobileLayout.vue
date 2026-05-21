<template>
  <!-- Full Screen Wrapper on mobile, centering frame on desktop -->
  <div class="h-screen w-full bg-slate-950 text-slate-100 flex items-center justify-center p-0 md:p-6 font-sans overflow-hidden">
    <!-- Phone Frame (Stretches full-screen on mobile, constraints on desktop) -->
    <div class="w-full h-full md:max-w-md md:h-[800px] bg-slate-900 md:rounded-[36px] md:shadow-2xl md:border-[6px] md:border-slate-800 overflow-hidden relative flex flex-col">
      
      <!-- Top Notch (Visible only on desktop frame) -->
      <div class="hidden md:flex justify-center absolute top-0 left-0 right-0 z-50">
        <div class="w-40 h-6 bg-slate-800 rounded-b-2xl flex items-center justify-around px-4">
          <div class="w-16 h-1.5 bg-slate-900 rounded-full"></div>
          <div class="w-3 h-3 bg-slate-900 rounded-full"></div>
        </div>
      </div>

      <!-- StatusBar / Header (Compensates for mobile safe-area/notch) -->
      <header class="bg-slate-900/85 backdrop-blur-md border-b border-slate-800/60 sticky top-0 z-40 px-6 pt-[calc(1rem+env(safe-area-inset-top))] pb-3 md:pt-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="relative">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-rose-500 flex items-center justify-center font-bold text-white shadow-lg text-sm border-2 border-indigo-400">
              <span v-if="!userAvatar">{{ userName.charAt(0).toUpperCase() }}</span>
              <img v-else :src="userAvatar" alt="Avatar" class="w-full h-full rounded-full object-cover">
            </div>
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"></span>
          </div>
          <div>
            <h4 class="text-xs text-slate-400 font-medium">Selamat datang,</h4>
            <h3 class="text-sm font-bold text-slate-100 flex items-center gap-1.5">
              {{ userName }}
              <span class="text-[10px] bg-indigo-500/20 text-indigo-400 px-2 py-0.5 rounded-full border border-indigo-500/30 uppercase tracking-wider font-semibold">
                {{ userRole }}
              </span>
            </h3>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <!-- Notification Bell -->
          <button @click="showNotifications = !showNotifications" class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/50 hover:bg-slate-700/60 transition-all relative">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span v-if="unreadCount > 0" class="absolute top-1 right-1 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-slate-900 animate-ping"></span>
          </button>
        </div>
      </header>

      <!-- Notifications Panel Modal (Covers full screen natively) -->
      <transition name="slide">
        <div v-if="showNotifications" class="absolute inset-0 bg-slate-950/98 backdrop-blur-lg z-50 p-6 pt-[calc(1.5rem+env(safe-area-inset-top))] flex flex-col">
          <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
            <h3 class="font-bold text-lg text-slate-100">Notifikasi</h3>
            <button @click="showNotifications = false" class="text-slate-400 hover:text-slate-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="flex-1 overflow-y-auto space-y-3 pr-1">
            <div v-for="(notif, idx) in notifications" :key="idx" class="p-4 rounded-2xl border bg-slate-900/60 border-slate-800/80 flex gap-3 relative overflow-hidden">
              <div class="w-1.5 h-full absolute left-0 top-0 bg-indigo-500"></div>
              <div class="p-2 rounded-xl bg-slate-800 border border-slate-700/60 flex items-center justify-center self-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
              <div class="flex-1">
                <p class="text-xs text-slate-400 font-semibold mb-1">{{ notif.time }}</p>
                <h4 class="text-sm font-bold text-slate-200 mb-0.5">{{ notif.title }}</h4>
                <p class="text-xs text-slate-400 leading-relaxed">{{ notif.message }}</p>
              </div>
            </div>
            <div v-if="notifications.length === 0" class="text-center py-12 text-slate-500">
              Tidak ada notifikasi saat ini.
            </div>
          </div>
        </div>
      </transition>

      <!-- Scrollable Main Container -->
      <main class="flex-1 overflow-y-auto px-6 py-6 pb-28 md:pb-24 space-y-6 scrollbar-thin scrollbar-thumb-slate-800">
        
        <!-- Tab 1: Dashboard -->
        <div v-if="activeTab === 'dashboard'" class="space-y-6 animate-fadeIn">
          <!-- Overview Cards Slider -->
          <div class="grid grid-cols-2 gap-4">
            <div class="p-4 rounded-3xl bg-gradient-to-br from-indigo-600 to-indigo-800 border border-indigo-500/20 shadow-lg relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
              <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
              <p class="text-xs font-semibold text-indigo-200">TOTAL PELANGGARAN</p>
              <h2 class="text-3xl font-extrabold text-white mt-1.5">{{ totalViolations }}</h2>
              <div class="mt-2.5 flex items-center gap-1 text-[10px] font-semibold bg-white/20 text-white px-2 py-0.5 rounded-full w-max">
                <span>Minggu ini</span>
              </div>
            </div>

            <div class="p-4 rounded-3xl bg-gradient-to-br from-rose-600 to-rose-800 border border-rose-500/20 shadow-lg relative overflow-hidden group hover:scale-[1.02] transition-transform duration-300">
              <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <p class="text-xs font-semibold text-rose-200">AKTIF SANKSI</p>
              <h2 class="text-3xl font-extrabold text-white mt-1.5">{{ activeSanctions }}</h2>
              <div class="mt-2.5 flex items-center gap-1 text-[10px] font-semibold bg-white/20 text-white px-2 py-0.5 rounded-full w-max">
                <span>Perlu Tindakan</span>
              </div>
            </div>
          </div>

          <!-- Quick Action / Banner -->
          <div class="p-5 rounded-3xl bg-slate-900 border border-slate-800 shadow-md flex items-center justify-between gap-4">
            <div class="space-y-1">
              <h4 class="font-bold text-slate-100 text-sm">Laporkan Pelanggaran</h4>
              <p class="text-xs text-slate-400">Temukan pelanggaran disiplin karyawan? Laporkan segera secara transparan.</p>
            </div>
            <button @click="activeTab = 'report'" class="flex-shrink-0 p-3 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl hover:opacity-90 shadow-lg text-white font-semibold transition-all">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
            </button>
          </div>

          <!-- Recent Violations Log -->
          <div class="space-y-3">
            <div class="flex items-center justify-between">
              <h3 class="font-bold text-slate-100 text-sm tracking-wide">PELANGGARAN TERBARU</h3>
              <button @click="activeTab = 'violations'" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold">Lihat Semua</button>
            </div>
            <div class="space-y-3">
              <div v-for="violation in recentViolations" :key="violation.id" class="p-4 rounded-3xl bg-slate-900/60 border border-slate-800/80 hover:bg-slate-900 transition-all flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center flex-shrink-0 text-indigo-400 font-bold text-sm">
                    {{ violation.category.charAt(0) }}
                  </div>
                  <div>
                    <h4 class="text-xs text-slate-400 font-semibold mb-0.5">{{ violation.karyawan }} - {{ violation.departemen }}</h4>
                    <h3 class="text-sm font-bold text-slate-100 line-clamp-1">{{ violation.reason }}</h3>
                    <p class="text-[10px] text-slate-500 mt-1 flex items-center gap-1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      {{ violation.date }}
                    </p>
                  </div>
                </div>
                <div class="text-right">
                  <span :class="getStatusClass(violation.status)" class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider border">
                    {{ violation.status }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab 2: Violations list -->
        <div v-else-if="activeTab === 'violations'" class="space-y-5 animate-fadeIn">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-xl font-extrabold text-slate-100">Daftar Pelanggaran</h2>
              <p class="text-xs text-slate-400">Total temuan kasus pelanggaran karyawan</p>
            </div>
            <div class="relative">
              <select v-model="filterStatus" class="bg-slate-900 border border-slate-800 text-xs rounded-xl px-3 py-1.5 text-slate-300 font-semibold focus:outline-none focus:border-indigo-500 cursor-pointer">
                <option value="ALL">Semua</option>
                <option value="DISETUJUI">DISETUJUI</option>
                <option value="PROSES">PROSES</option>
                <option value="DITOLAK">DITOLAK</option>
              </select>
            </div>
          </div>

          <div class="space-y-3">
            <div v-for="violation in filteredViolations" :key="violation.id" class="p-5 rounded-3xl bg-slate-900 border border-slate-800 flex flex-col gap-3 relative overflow-hidden group">
              <div class="flex justify-between items-start">
                <div>
                  <span class="text-[10px] font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    {{ violation.category }}
                  </span>
                  <h3 class="font-bold text-slate-100 text-base mt-2">{{ violation.reason }}</h3>
                </div>
                <span :class="getStatusClass(violation.status)" class="text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider border">
                  {{ violation.status }}
                </span>
              </div>
              
              <div class="border-t border-slate-800/80 pt-3 flex justify-between items-center text-xs text-slate-400">
                <div class="flex items-center gap-2">
                  <div class="w-6 h-6 rounded-full bg-slate-800 flex items-center justify-center text-[10px] font-bold text-indigo-400">
                    {{ violation.karyawan.charAt(0) }}
                  </div>
                  <span>{{ violation.karyawan }} ({{ violation.departemen }})</span>
                </div>
                <span>{{ violation.date }}</span>
              </div>
            </div>

            <div v-if="filteredViolations.length === 0" class="text-center py-12 text-slate-500">
              Tidak ada data pelanggaran ditemukan.
            </div>
          </div>
        </div>

        <!-- Tab 3: Report New Violation Form -->
        <div v-else-if="activeTab === 'report'" class="space-y-5 animate-fadeIn">
          <div>
            <h2 class="text-xl font-extrabold text-slate-100">Laporkan Kasus</h2>
            <p class="text-xs text-slate-400">Pastikan melampirkan informasi yang akurat dan objektif.</p>
          </div>

          <form @submit.prevent="submitReport" class="space-y-4">
            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-slate-300">Pilih Karyawan *</label>
              <div class="relative">
                <select v-model="form.karyawan_id" required class="w-full bg-slate-900 border border-slate-800 rounded-2xl px-4 py-3 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer appearance-none">
                  <option value="" disabled selected>Pilih nama karyawan...</option>
                  <option v-for="emp in employees" :key="emp.id" :value="emp.id">
                    {{ emp.name }} - {{ emp.dept }}
                  </option>
                </select>
                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                  ▼
                </div>
              </div>
            </div>

            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-slate-300">Jenis Pelanggaran *</label>
              <div class="relative">
                <select v-model="form.jenis_pelanggaran_id" required class="w-full bg-slate-900 border border-slate-800 rounded-2xl px-4 py-3 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer appearance-none">
                  <option value="" disabled selected>Pilih klasifikasi pelanggaran...</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                    {{ cat.name }}
                  </option>
                </select>
                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-500">
                  ▼
                </div>
              </div>
            </div>

            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-slate-300">Deskripsi / Detail Pelanggaran *</label>
              <textarea v-model="form.reason" required rows="4" placeholder="Jelaskan secara detail kejadian dan barang bukti jika ada..." class="w-full bg-slate-900 border border-slate-800 rounded-2xl px-4 py-3 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors placeholder-slate-600 resize-none"></textarea>
            </div>

            <div class="space-y-1.5">
              <label class="text-xs font-semibold text-slate-300">Rekomendasi Sanksi (Opsional)</label>
              <input v-model="form.sanksi" type="text" placeholder="Misal: SP 1, Teguran Tertulis" class="w-full bg-slate-900 border border-slate-800 rounded-2xl px-4 py-3 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition-colors placeholder-slate-600">
            </div>

            <button type="submit" :disabled="submitting" class="w-full py-4 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 disabled:opacity-50 text-white font-bold rounded-2xl shadow-lg shadow-indigo-500/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
              <span v-if="submitting" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
              <span>{{ submitting ? 'Mengirim laporan...' : 'Kirim Laporan Pelanggaran' }}</span>
            </button>
          </form>
        </div>

        <!-- Tab 4: Profile Settings & Controls -->
        <div v-else-if="activeTab === 'profile'" class="space-y-6 animate-fadeIn">
          <div class="text-center py-4">
            <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-tr from-indigo-500 to-rose-500 flex items-center justify-center font-bold text-white shadow-2xl text-3xl border-4 border-slate-800 mb-3">
              <span v-if="!userAvatar">{{ userName.charAt(0).toUpperCase() }}</span>
              <img v-else :src="userAvatar" alt="Avatar" class="w-full h-full rounded-full object-cover">
            </div>
            <h2 class="text-xl font-extrabold text-slate-100">{{ userName }}</h2>
            <p class="text-xs text-indigo-400 font-semibold tracking-wide uppercase mt-1">{{ userRole }}</p>
          </div>

          <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden divide-y divide-slate-800/80">
            <a :href="dashboardUrl" class="flex items-center justify-between px-6 py-4 hover:bg-slate-800/50 transition-colors">
              <div class="flex items-center gap-3">
                <span class="text-slate-400">🏠</span>
                <span class="text-sm font-semibold text-slate-200">Dashboard Web Utama</span>
              </div>
              <span class="text-slate-500 text-xs">➔</span>
            </a>
            <div class="flex items-center justify-between px-6 py-4">
              <div class="flex items-center gap-3">
                <span class="text-slate-400">🔔</span>
                <span class="text-sm font-semibold text-slate-200">Notifikasi Aplikasi</span>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" v-model="settings.pushNotifications" class="sr-only peer">
                <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-slate-400 after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600 peer-checked:after:bg-white"></div>
              </label>
            </div>
            <div class="flex items-center justify-between px-6 py-4">
              <div class="flex items-center gap-3">
                <span class="text-slate-400">🌙</span>
                <span class="text-sm font-semibold text-slate-200">Mode Gelap</span>
              </div>
              <span class="text-xs font-semibold text-slate-400 bg-slate-800/50 px-2.5 py-1 rounded-full border border-slate-700/50">Selalu Aktif</span>
            </div>
          </div>

          <div class="pt-4">
            <form :action="logoutUrl" method="POST">
              <input type="hidden" name="_token" :value="csrfToken">
              <button type="submit" class="w-full py-4 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 font-bold rounded-2xl active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar dari Akun</span>
              </button>
            </form>
          </div>
        </div>
      </main>

      <!-- Bottom Navigation bar (sleek responsive height with safe areas) -->
      <nav class="absolute bottom-0 inset-x-0 bg-slate-900/90 backdrop-blur-md border-t border-slate-800/80 px-6 pt-3 pb-[calc(0.75rem+env(safe-area-inset-bottom))] md:py-3 flex items-center justify-between z-30 rounded-t-3xl md:rounded-b-[32px] md:rounded-t-none">
        <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id" :class="activeTab === tab.id ? 'text-indigo-400' : 'text-slate-400 hover:text-slate-200'" class="flex flex-col items-center gap-1.5 flex-1 py-1 transition-colors relative">
          <!-- Active Dot -->
          <span v-if="activeTab === tab.id" class="w-1.5 h-1.5 bg-indigo-400 rounded-full absolute -top-1"></span>
          
          <!-- Tab Icons -->
          <svg v-if="tab.id === 'dashboard'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :fill="activeTab === 'dashboard' ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
          </svg>
          
          <svg v-else-if="tab.id === 'violations'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :fill="activeTab === 'violations' ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
          </svg>
          
          <svg v-else-if="tab.id === 'report'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :fill="activeTab === 'report' ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          
          <svg v-else-if="tab.id === 'profile'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :fill="activeTab === 'profile' ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>

          <span class="text-[10px] font-bold tracking-wide">{{ tab.name }}</span>
        </button>
      </nav>

    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'MobileLayout',
  props: {
    userName: {
      type: String,
      default: 'Admin User'
    },
    userRole: {
      type: String,
      default: 'admin'
    },
    userAvatar: {
      type: String,
      default: ''
    },
    csrfToken: {
      type: String,
      default: ''
    },
    logoutUrl: {
      type: String,
      default: '/logout'
    },
    dashboardUrl: {
      type: String,
      default: '/dashboard'
    }
  },
  data() {
    return {
      activeTab: 'dashboard',
      filterStatus: 'ALL',
      showNotifications: false,
      unreadCount: 0,
      submitting: false,
      tabs: [
        { id: 'dashboard', name: 'Dashboard' },
        { id: 'violations', name: 'Kasus' },
        { id: 'report', name: 'Lapor' },
        { id: 'profile', name: 'Profil' }
      ],
      settings: {
        pushNotifications: true
      },
      form: {
        karyawan_id: '',
        jenis_pelanggaran_id: '',
        reason: '',
        sanksi: ''
      },
      employees: [],
      categories: [],
      notifications: [],
      violations: []
    };
  },
  computed: {
    totalViolations() {
      return this.violations.length;
    },
    activeSanctions() {
      return this.violations.filter(v => v.status === 'DISETUJUI').length;
    },
    recentViolations() {
      return this.violations.slice(0, 3);
    },
    filteredViolations() {
      if (this.filterStatus === 'ALL') {
        return this.violations;
      }
      return this.violations.filter(v => v.status === this.filterStatus);
    }
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      axios.get('/mobile/data')
        .then(response => {
          this.violations = response.data.violations || [];
          this.employees = response.data.employees || [];
          this.categories = response.data.jenis_pelanggaran || [];
          this.notifications = response.data.notifications || [];
          this.unreadCount = this.notifications.filter(n => !n.read_at).length || this.notifications.length;
        })
        .catch(error => {
          console.error('Error fetching mobile data:', error);
        });
    },
    getStatusClass(status) {
      switch (status) {
        case 'DISETUJUI':
        case 'ACTIVE':
          return 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
        case 'PROSES':
        case 'PENDING':
          return 'bg-amber-500/10 text-amber-400 border-amber-500/20';
        case 'DITOLAK':
          return 'bg-rose-500/10 text-rose-400 border-rose-500/20';
        default:
          return 'bg-slate-500/10 text-slate-400 border-slate-500/20';
      }
    },
    submitReport() {
      this.submitting = true;
      axios.post('/mobile/report', {
        karyawan_id: this.form.karyawan_id,
        jenis_pelanggaran_id: this.form.jenis_pelanggaran_id,
        keterangan_pelanggaran: this.form.reason,
      })
      .then(response => {
        this.submitting = false;
        if (response.data.success) {
          // Add to front of violations list
          this.violations.unshift(response.data.violation);
          
          // Add a local notification
          this.notifications.unshift({
            title: 'Laporan Berhasil!',
            message: `Laporan untuk ${response.data.violation.karyawan} berhasil ditambahkan ke database.`,
            time: 'Baru saja'
          });
          this.unreadCount++;

          // Reset form
          this.form.karyawan_id = '';
          this.form.jenis_pelanggaran_id = '';
          this.form.reason = '';
          this.form.sanksi = '';

          // Redirect to violations tab
          this.activeTab = 'violations';
        }
      })
      .catch(error => {
        this.submitting = false;
        console.error('Error submitting violation:', error);
        alert('Gagal mengirimkan laporan. Silakan periksa kembali data Anda.');
      });
    }
  }
};
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fadeIn {
  animation: fadeIn 0.3s ease-out forwards;
}

.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease, opacity 0.3s ease;
}
.slide-enter-from, .slide-leave-to {
  transform: translateY(20px);
  opacity: 0;
}
</style>
