{{-- Profile Dropdown Component --}}
{{-- Usage: @include('components.profile-dropdown', ['userName' => 'Admin User', 'userRole' => 'Administrator', 'userEmail' => 'admin@gmail.com', 'userPhoto' => 'url']) --}}

@php
    $userName = $userName ?? 'User';
    $userRole = $userRole ?? 'Staff';
    $userEmail = $userEmail ?? 'user@edugo.id';
    $userPhoto = $userPhoto ?? 'https://ui-avatars.com/api/?name=' . urlencode($userName) . '&background=165DFF&color=fff&size=100';
@endphp

<div class="relative" id="profileDropdownWrapper">
    <button onclick="toggleProfileDropdown()" id="profileDropdownBtn"
        class="flex items-center gap-2 md:gap-3 pl-2 md:pl-3 border-l border-border cursor-pointer hover:opacity-80 transition-all duration-300 group">
        <div class="hidden sm:block text-right">
            <p class="font-semibold text-foreground text-xs md:text-sm group-hover:text-primary transition-colors duration-300">{{ $userName }}</p>
            <p class="text-secondary text-[10px] md:text-xs">{{ $userRole }}</p>
        </div>
        <div class="relative flex-shrink-0">
            <img src="{{ $userPhoto }}" alt="Profile" class="size-9 md:size-11 rounded-full object-cover ring-2 ring-border group-hover:ring-primary transition-all duration-300">
            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 md:w-3 md:h-3 bg-green-500 rounded-full border-2 border-white"></span>
        </div>
        <i data-lucide="chevron-down" id="profileDropdownArrow" class="w-3.5 h-3.5 md:w-4 md:h-4 text-secondary transition-transform duration-300"></i>
    </button>

    {{-- Dropdown Panel --}}
    <div id="profileDropdownPanel" 
         class="hidden absolute right-0 top-[calc(100%+12px)] w-[300px] sm:w-[360px] max-w-[calc(100vw-24px)] bg-white rounded-2xl shadow-2xl border border-gray-100 z-[100] overflow-hidden"
         style="animation: slideDown 0.25s ease-out;">
        
        {{-- Profile Card Header --}}
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700"></div>
            <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.15&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            <div class="relative p-6 pb-5">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img src="{{ $userPhoto }}" alt="Profile" class="size-16 rounded-2xl object-cover ring-3 ring-white/30 shadow-lg">
                        <span class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-green-400 rounded-full border-2 border-white shadow-sm"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-white text-base truncate">{{ $userName }}</h3>
                        <p class="text-blue-100 text-sm truncate">{{ $userEmail }}</p>
                        <span class="inline-flex items-center mt-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 mr-1.5 animate-pulse"></span>
                            {{ $userRole }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-3 gap-px bg-gray-100 border-b border-gray-100">
            <div class="bg-white p-3 text-center">
                <p class="text-lg font-bold text-foreground">12</p>
                <p class="text-[10px] text-secondary uppercase tracking-wider">Hari Login</p>
            </div>
            <div class="bg-white p-3 text-center">
                <p class="text-lg font-bold text-foreground">{{ now()->format('H:i') }}</p>
                <p class="text-[10px] text-secondary uppercase tracking-wider">Login Terakhir</p>
            </div>
            <div class="bg-white p-3 text-center">
                <p class="text-lg font-bold text-green-500">●</p>
                <p class="text-[10px] text-secondary uppercase tracking-wider">Status</p>
            </div>
        </div>

        {{-- Menu Items --}}
        <div class="p-3">
            {{-- Lihat Profil --}}
            <button onclick="openProfileModal()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group">
                <div class="size-9 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                    <i data-lucide="user-circle" class="size-[18px] text-blue-600"></i>
                </div>
                <div class="flex-1 text-left">
                    <p class="font-medium">Lihat Profil</p>
                    <p class="text-xs text-gray-400">Info pribadi & foto</p>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:text-blue-400 transition-colors"></i>
            </button>

            {{-- Pengaturan --}}
            <button onclick="openSettingsModal()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-all duration-200 group">
                <div class="size-9 rounded-xl bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                    <i data-lucide="settings" class="size-[18px] text-purple-600"></i>
                </div>
                <div class="flex-1 text-left">
                    <p class="font-medium">Pengaturan</p>
                    <p class="text-xs text-gray-400">Tema, font, bahasa</p>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:text-purple-400 transition-colors"></i>
            </button>

            {{-- Notifikasi --}}
            <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-all duration-200 group">
                <div class="size-9 rounded-xl bg-amber-50 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <i data-lucide="bell-ring" class="size-[18px] text-amber-600"></i>
                </div>
                <div class="flex-1 text-left">
                    <p class="font-medium">Notifikasi</p>
                    <p class="text-xs text-gray-400">Atur pemberitahuan</p>
                </div>
                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-red-500 text-white">3</span>
            </button>

            {{-- Bantuan --}}
            <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-all duration-200 group">
                <div class="size-9 rounded-xl bg-teal-50 flex items-center justify-center group-hover:bg-teal-100 transition-colors">
                    <i data-lucide="help-circle" class="size-[18px] text-teal-600"></i>
                </div>
                <div class="flex-1 text-left">
                    <p class="font-medium">Bantuan & FAQ</p>
                    <p class="text-xs text-gray-400">Pusat bantuan</p>
                </div>
                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:text-teal-400 transition-colors"></i>
            </button>
        </div>

        {{-- Logout --}}
        <div class="border-t border-gray-100 p-3">
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-600 hover:bg-red-50 transition-all duration-200 group cursor-pointer text-left">
                    <div class="size-9 rounded-xl bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                        <i data-lucide="log-out" class="size-[18px] text-red-500"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">Keluar</p>
                        <p class="text-xs text-red-400">Logout dari akun</p>
                    </div>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- PROFILE MODAL --}}
<div id="profileModal" class="fixed inset-0 z-[200] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeProfileModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden" style="animation: modalSlideUp 0.3s ease-out;">
            {{-- Modal Header with gradient --}}
            <div class="relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700"></div>
                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;40&quot; height=&quot;40&quot; viewBox=&quot;0 0 40 40&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.2&quot;%3E%3Ccircle cx=&quot;20&quot; cy=&quot;20&quot; r=&quot;2&quot;/%3E%3C/g%3E%3C/svg%3E');"></div>
                <button onclick="closeProfileModal()" class="absolute top-4 right-4 size-8 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition-colors z-10 cursor-pointer">
                    <i data-lucide="x" class="size-4 text-white"></i>
                </button>
                <div class="relative p-8 pb-20 text-center">
                    <div class="relative inline-block">
                        <img src="{{ $userPhoto }}" alt="Profile" class="size-24 rounded-3xl object-cover ring-4 ring-white/30 shadow-xl mx-auto">
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-3 border-white shadow-sm flex items-center justify-center">
                            <i data-lucide="check" class="size-3 text-white"></i>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Profile Info Card --}}
            <div class="relative -mt-12 mx-6">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-5">
                    <h2 class="font-bold text-xl text-center text-foreground">{{ $userName }}</h2>
                    <p class="text-center text-secondary text-sm mt-1">{{ $userRole }}</p>
                    <div class="flex justify-center mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                            Online
                        </span>
                    </div>
                </div>
            </div>

            {{-- Detail Info --}}
            <div class="p-6 space-y-4 max-h-[300px] overflow-y-auto">
                <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-blue-50 transition-colors">
                    <div class="size-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="mail" class="size-5 text-blue-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-secondary uppercase tracking-wider font-medium">Email</p>
                        <p class="text-sm font-semibold text-foreground truncate">{{ $userEmail }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-purple-50 transition-colors">
                    <div class="size-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="briefcase" class="size-5 text-purple-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-secondary uppercase tracking-wider font-medium">Jabatan</p>
                        <p class="text-sm font-semibold text-foreground">{{ $userRole }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-green-50 transition-colors">
                    <div class="size-10 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="building" class="size-5 text-green-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-secondary uppercase tracking-wider font-medium">Sekolah</p>
                        <p class="text-sm font-semibold text-foreground">EDUGO School</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-amber-50 transition-colors">
                    <div class="size-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="phone" class="size-5 text-amber-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-secondary uppercase tracking-wider font-medium">Telepon</p>
                        <p class="text-sm font-semibold text-foreground">+62 812-3456-7890</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-rose-50 transition-colors">
                    <div class="size-10 rounded-xl bg-rose-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="map-pin" class="size-5 text-rose-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-secondary uppercase tracking-wider font-medium">Alamat</p>
                        <p class="text-sm font-semibold text-foreground">Kp. Kandawati, RT 06 / RW 02, Kec. Gunung Kaler, Kab. Tangerang - Banten 15620</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-cyan-50 transition-colors">
                    <div class="size-10 rounded-xl bg-cyan-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="calendar" class="size-5 text-cyan-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-secondary uppercase tracking-wider font-medium">Bergabung Sejak</p>
                        <p class="text-sm font-semibold text-foreground">{{ now()->subYears(2)->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SETTINGS MODAL --}}
<div id="settingsModal" class="fixed inset-0 z-[200] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeSettingsModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden" style="animation: modalSlideUp 0.3s ease-out;">
            {{-- Settings Header --}}
            <div class="flex items-center justify-between p-6 pb-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                        <i data-lucide="settings" class="size-5 text-white"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-foreground">Pengaturan</h2>
                        <p class="text-xs text-secondary">Sesuaikan tampilan Anda</p>
                    </div>
                </div>
                <button onclick="closeSettingsModal()" class="size-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors cursor-pointer">
                    <i data-lucide="x" class="size-4 text-gray-500"></i>
                </button>
            </div>

            {{-- Settings Content --}}
            <div class="p-6 space-y-6 max-h-[500px] overflow-y-auto">
                {{-- Mode Tampilan --}}
                <div>
                    <h3 class="font-semibold text-sm text-foreground mb-3 flex items-center gap-2">
                        <i data-lucide="palette" class="size-4 text-purple-500"></i>
                        Mode Tampilan
                    </h3>
                    <div class="grid grid-cols-3 gap-3">
                        <button onclick="setTheme('light')" id="themeLight" class="theme-btn active-theme flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-blue-500 bg-blue-50 transition-all duration-300 hover:scale-105 cursor-pointer">
                            <div class="size-12 rounded-xl bg-white border-2 border-gray-200 flex items-center justify-center shadow-sm">
                                <i data-lucide="sun" class="size-6 text-amber-500"></i>
                            </div>
                            <span class="text-xs font-semibold text-blue-700">Siang</span>
                        </button>
                        <button onclick="setTheme('dark')" id="themeDark" class="theme-btn flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-gray-200 bg-white transition-all duration-300 hover:scale-105 hover:border-gray-300 cursor-pointer">
                            <div class="size-12 rounded-xl bg-gray-800 border-2 border-gray-700 flex items-center justify-center shadow-sm">
                                <i data-lucide="moon" class="size-6 text-indigo-300"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">Malam</span>
                        </button>
                        <button onclick="setTheme('auto')" id="themeAuto" class="theme-btn flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-gray-200 bg-white transition-all duration-300 hover:scale-105 hover:border-gray-300 cursor-pointer">
                            <div class="size-12 rounded-xl bg-gradient-to-br from-white to-gray-800 border-2 border-gray-300 flex items-center justify-center shadow-sm">
                                <i data-lucide="monitor" class="size-6 text-gray-500"></i>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">Otomatis</span>
                        </button>
                    </div>
                </div>

                {{-- Ukuran Font --}}
                <div>
                    <h3 class="font-semibold text-sm text-foreground mb-3 flex items-center gap-2">
                        <i data-lucide="type" class="size-4 text-indigo-500"></i>
                        Ukuran Font
                    </h3>
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs text-secondary font-medium">A</span>
                            <span id="fontSizeLabel" class="text-sm font-bold text-foreground px-3 py-1 bg-white rounded-lg shadow-sm">Normal</span>
                            <span class="text-lg text-secondary font-medium">A</span>
                        </div>
                        <input type="range" id="fontSizeSlider" min="0" max="4" value="2" 
                               class="w-full h-2 bg-gray-200 rounded-full appearance-none cursor-pointer accent-indigo-600"
                               oninput="changeFontSize(this.value)">
                        <div class="flex justify-between mt-2">
                            <span class="text-[10px] text-gray-400">Sangat Kecil</span>
                            <span class="text-[10px] text-gray-400">Kecil</span>
                            <span class="text-[10px] text-gray-400">Normal</span>
                            <span class="text-[10px] text-gray-400">Besar</span>
                            <span class="text-[10px] text-gray-400">Sangat Besar</span>
                        </div>
                    </div>
                </div>

                {{-- Bahasa --}}
                <div>
                    <h3 class="font-semibold text-sm text-foreground mb-3 flex items-center gap-2">
                        <i data-lucide="languages" class="size-4 text-teal-500"></i>
                        Bahasa
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="setLang(this, 'id')" class="lang-btn active-lang flex items-center gap-3 p-3 rounded-xl border-2 border-blue-500 bg-blue-50 transition-all duration-200 cursor-pointer">
                            <span class="text-2xl">🇮🇩</span>
                            <div>
                                <p class="text-sm font-semibold text-blue-700">Indonesia</p>
                                <p class="text-[10px] text-blue-500">Bahasa Indonesia</p>
                            </div>
                        </button>
                        <button onclick="setLang(this, 'en')" class="lang-btn flex items-center gap-3 p-3 rounded-xl border-2 border-gray-200 bg-white transition-all duration-200 hover:border-gray-300 cursor-pointer">
                            <span class="text-2xl">🇬🇧</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">English</p>
                                <p class="text-[10px] text-gray-400">International</p>
                            </div>
                        </button>
                    </div>
                </div>

                {{-- Preferensi Notifikasi --}}
                <div>
                    <h3 class="font-semibold text-sm text-foreground mb-3 flex items-center gap-2">
                        <i data-lucide="bell" class="size-4 text-amber-500"></i>
                        Preferensi Notifikasi
                    </h3>
                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <i data-lucide="mail" class="size-4 text-blue-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Email</span>
                            </div>
                            <div class="relative">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-10 h-5 bg-gray-300 peer-checked:bg-blue-600 rounded-full transition-colors" onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('bg-blue-600'); this.classList.toggle('bg-gray-300'); this.querySelector('span').classList.toggle('translate-x-5');"><span class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform translate-x-5"></span></div>
                            </div>
                        </label>
                        <label class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-lg bg-green-100 flex items-center justify-center">
                                    <i data-lucide="smartphone" class="size-4 text-green-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Push Notification</span>
                            </div>
                            <div class="relative">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-10 h-5 bg-gray-300 peer-checked:bg-green-600 rounded-full transition-colors" onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('bg-green-600'); this.classList.toggle('bg-gray-300'); this.querySelector('span').classList.toggle('translate-x-5');"><span class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform translate-x-5"></span></div>
                            </div>
                        </label>
                        <label class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-lg bg-amber-100 flex items-center justify-center">
                                    <i data-lucide="volume-2" class="size-4 text-amber-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Sound</span>
                            </div>
                            <div class="relative">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-10 h-5 bg-gray-300 rounded-full transition-colors" onclick="this.previousElementSibling.checked = !this.previousElementSibling.checked; this.classList.toggle('bg-amber-500'); this.classList.toggle('bg-gray-300'); this.querySelector('span').classList.toggle('translate-x-5');"><span class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform"></span></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles & Scripts --}}
<style>
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes modalSlideUp {
        from { opacity: 0; transform: translateY(20px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    #fontSizeSlider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(99, 102, 241, 0.4);
    }
    #fontSizeSlider::-moz-range-thumb {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(99, 102, 241, 0.4);
        border: none;
    }
    /* ==========================================
       MODERN UNIFIED DARK MODE DESIGN SYSTEM
       ========================================== */
    .dark-mode { 
        --foreground: #F8FAFC !important; 
        --secondary: #94A3B8 !important; 
        --muted: #0F172A !important; 
        --border: #1E293B !important; 
        --card-grey: #1E293B !important;
        color-scheme: dark;
    }
    
    /* Global Backgrounds & Containers */
    .dark-mode,
    .dark-mode body, 
    .dark-mode main,
    .dark-mode div.bg-gray-50\/50,
    .dark-mode div.bg-gray-50,
    .dark-mode div.bg-slate-50,
    .dark-mode div.bg-slate-100,
    .dark-mode div.bg-gray-100,
    .dark-mode div.bg-muted,
    .dark-mode .bg-muted,
    .dark-mode .bg-gray-50,
    .dark-mode .bg-gray-50\/50,
    .dark-mode .bg-slate-50,
    .dark-mode .bg-slate-100,
    .dark-mode .bg-gray-100\/50,
    .dark-mode .bg-[#F1F3F6],
    .dark-mode .bg-[#f1f3f6],
    .dark-mode .bg-[#f8fafc] { 
        background-color: #0b0f19 !important; 
        color: #F8FAFC !important; 
    }

    /* Sidebar Navigation & Header Bar */
    .dark-mode aside,
    .dark-mode header,
    .dark-mode div.h-\[90px\],
    .dark-mode div.h-\[120px\] { 
        background-color: #111827 !important; 
        border-color: #1f293d !important; 
    }

    /* Sidebar Submenus & Active Items */
    .dark-mode aside .bg-white {
        background-color: #111827 !important;
    }

    .dark-mode aside .group-\[\.active\]\:bg-muted,
    .dark-mode aside .group-hover\:bg-muted:hover,
    .dark-mode aside .hover\:bg-muted:hover {
        background-color: #1e293b !important;
    }

    /* Standard Cards, Modals & Menus */
    .dark-mode .bg-white,
    .dark-mode div.bg-white,
    .dark-mode #profileDropdownPanel,
    .dark-mode #notificationDropdownPanel,
    .dark-mode #profileModal > div > div,
    .dark-mode #settingsModal > div > div { 
        background-color: #1e293b !important; 
        border-color: #334155 !important;
    }

    /* Inner Cards & Sub-containers (Empty state boxes, nested cards) */
    .dark-mode div.border-dashed.bg-gray-50,
    .dark-mode div.bg-gray-50,
    .dark-mode .bg-gray-50\/80,
    .dark-mode .bg-slate-50\/80,
    .dark-mode .p-4.rounded-xl.border {
        background-color: #111827 !important;
        border-color: #334155 !important;
    }

    /* Text Color Mappings */
    .dark-mode .text-foreground, 
    .dark-mode .text-gray-900,
    .dark-mode .text-gray-800,
    .dark-mode .text-slate-900,
    .dark-mode .text-slate-800,
    .dark-mode h1, .dark-mode h2, .dark-mode h3, .dark-mode h4, .dark-mode h5, .dark-mode h6 { 
        color: #F8FAFC !important; 
    }
    
    .dark-mode .text-secondary, 
    .dark-mode .text-gray-600,
    .dark-mode .text-gray-500,
    .dark-mode .text-slate-600,
    .dark-mode .text-slate-500,
    .dark-mode p.text-gray-500,
    .dark-mode span.text-gray-500 { 
        color: #94A3B8 !important; 
    }

    .dark-mode .text-gray-400,
    .dark-mode .text-slate-400,
    .dark-mode .text-gray-300 {
        color: #64748B !important;
    }

    /* Borders & Rings */
    .dark-mode .border-border,
    .dark-mode .border-gray-100,
    .dark-mode .border-gray-200,
    .dark-mode .border-gray-300,
    .dark-mode .border-slate-100,
    .dark-mode .border-slate-200,
    .dark-mode .border-slate-300,
    .dark-mode .divide-gray-100 > * + *,
    .dark-mode .divide-gray-200 > * + * { 
        border-color: #334155 !important; 
    }

    .dark-mode .ring-border,
    .dark-mode .ring-gray-100,
    .dark-mode .ring-gray-200 { 
        --tw-ring-color: #334155 !important; 
    }

    /* Form Inputs, Selects & Tables */
    .dark-mode input[type="text"],
    .dark-mode input[type="email"],
    .dark-mode input[type="password"],
    .dark-mode input[type="number"],
    .dark-mode input[type="date"],
    .dark-mode select,
    .dark-mode textarea {
        background-color: #0f172a !important;
        color: #f8fafc !important;
        border-color: #334155 !important;
    }
    
    .dark-mode select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394A3B8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") !important;
    }

    .dark-mode table thead th {
        background-color: #0f172a !important;
        color: #cbd5e1 !important;
        border-color: #334155 !important;
    }
    
    .dark-mode table tbody td,
    .dark-mode table tbody tr {
        border-color: #1e293b !important;
    }

    /* Soft Color Badges & Tinted Highlights in Dark Mode */
    .dark-mode .bg-blue-50 { background-color: rgba(30, 58, 138, 0.4) !important; color: #60a5fa !important; border-color: rgba(59, 130, 246, 0.3) !important; }
    .dark-mode .bg-green-50 { background-color: rgba(20, 83, 45, 0.4) !important; color: #4ade80 !important; border-color: rgba(34, 197, 94, 0.3) !important; }
    .dark-mode .bg-orange-50 { background-color: rgba(124, 45, 18, 0.4) !important; color: #fb923c !important; border-color: rgba(249, 115, 22, 0.3) !important; }
    .dark-mode .bg-purple-50 { background-color: rgba(88, 28, 135, 0.4) !important; color: #c084fc !important; border-color: rgba(168, 85, 247, 0.3) !important; }
    .dark-mode .bg-red-50 { background-color: rgba(127, 29, 29, 0.4) !important; color: #f87171 !important; border-color: rgba(239, 68, 68, 0.3) !important; }
    .dark-mode .bg-amber-50 { background-color: rgba(120, 53, 15, 0.4) !important; color: #fbbf24 !important; border-color: rgba(245, 158, 11, 0.3) !important; }
    .dark-mode .bg-indigo-50 { background-color: rgba(49, 46, 129, 0.4) !important; color: #818cf8 !important; border-color: rgba(99, 102, 241, 0.3) !important; }
    .dark-mode .bg-teal-50 { background-color: rgba(19, 78, 74, 0.4) !important; color: #2dd4bf !important; border-color: rgba(20, 184, 166, 0.3) !important; }
</style>

<script>
// Profile Dropdown
function toggleProfileDropdown() {
    const panel = document.getElementById('profileDropdownPanel');
    const arrow = document.getElementById('profileDropdownArrow');
    panel.classList.toggle('hidden');
    if (arrow) arrow.classList.toggle('rotate-180');
    if (typeof lucide !== 'undefined') setTimeout(() => lucide.createIcons(), 50);
}

// Close dropdown when click outside
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('profileDropdownWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        const panel = document.getElementById('profileDropdownPanel');
        const arrow = document.getElementById('profileDropdownArrow');
        if (panel && !panel.classList.contains('hidden')) {
            panel.classList.add('hidden');
            if (arrow) arrow.classList.remove('rotate-180');
        }
    }
});

// Profile Modal
function openProfileModal() {
    document.getElementById('profileDropdownPanel').classList.add('hidden');
    document.getElementById('profileModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (typeof lucide !== 'undefined') setTimeout(() => lucide.createIcons(), 50);
}
function closeProfileModal() {
    document.getElementById('profileModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Settings Modal
function openSettingsModal() {
    document.getElementById('profileDropdownPanel').classList.add('hidden');
    document.getElementById('settingsModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (typeof lucide !== 'undefined') setTimeout(() => lucide.createIcons(), 50);
    // Load saved settings
    const savedTheme = localStorage.getItem('edugo_theme') || 'light';
    setTheme(savedTheme, true);
    const savedFont = localStorage.getItem('edugo_font_size') || '2';
    document.getElementById('fontSizeSlider').value = savedFont;
    changeFontSize(savedFont, true);
}
function closeSettingsModal() {
    document.getElementById('settingsModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Theme Management
function setTheme(theme, noSave) {
    const html = document.documentElement;
    document.querySelectorAll('.theme-btn').forEach(btn => {
        btn.classList.remove('active-theme');
        btn.classList.remove('border-blue-500', 'bg-blue-50');
        btn.classList.add('border-gray-200', 'bg-white');
    });
    const activeBtn = document.getElementById('theme' + theme.charAt(0).toUpperCase() + theme.slice(1));
    if (activeBtn) {
        activeBtn.classList.add('active-theme');
        activeBtn.classList.remove('border-gray-200', 'bg-white');
        activeBtn.classList.add('border-blue-500', 'bg-blue-50');
    }
    if (theme === 'dark') {
        html.classList.add('dark-mode');
    } else if (theme === 'auto') {
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            html.classList.add('dark-mode');
        } else {
            html.classList.remove('dark-mode');
        }
    } else {
        html.classList.remove('dark-mode');
    }
    if (!noSave) localStorage.setItem('edugo_theme', theme);
}

// Font Size Management
function changeFontSize(val, noSave) {
    const sizes = [
        { label: 'Sangat Kecil', css: '13px' },
        { label: 'Kecil', css: '14px' },
        { label: 'Normal', css: '16px' },
        { label: 'Besar', css: '18px' },
        { label: 'Sangat Besar', css: '20px' }
    ];
    const idx = parseInt(val);
    document.documentElement.style.fontSize = sizes[idx].css;
    const label = document.getElementById('fontSizeLabel');
    if (label) label.textContent = sizes[idx].label;
    if (!noSave) localStorage.setItem('edugo_font_size', val);
}

// Language
function setLang(btn, lang) {
    document.querySelectorAll('.lang-btn').forEach(b => {
        b.classList.remove('active-lang', 'border-blue-500', 'bg-blue-50');
        b.classList.add('border-gray-200', 'bg-white');
        b.querySelector('p:first-child').classList.remove('text-blue-700');
        b.querySelector('p:first-child').classList.add('text-gray-700');
    });
    btn.classList.add('active-lang', 'border-blue-500', 'bg-blue-50');
    btn.classList.remove('border-gray-200', 'bg-white');
    btn.querySelector('p:first-child').classList.add('text-blue-700');
    btn.querySelector('p:first-child').classList.remove('text-gray-700');
    localStorage.setItem('edugo_lang', lang);
}

// Apply saved theme on load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('edugo_theme') || 'light';
    if (savedTheme !== 'light') setTheme(savedTheme, true);
    const savedFont = localStorage.getItem('edugo_font_size');
    if (savedFont && savedFont !== '2') changeFontSize(savedFont, true);
});
</script>
