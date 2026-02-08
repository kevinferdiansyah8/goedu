@extends('layouts.admin')

@section('content')
      <!-- Page Header -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6 md:mb-8">
        <div>
          <h1 class="text-foreground text-2xl md:text-3xl font-bold mb-1">EduGo Dashboard</h1>
          <p class="text-secondary text-sm md:text-base">Selamat datang! Berikut ringkasan aktivitas sekolah hari ini.</p>
        </div>
        <div class="flex items-center gap-2 md:gap-3 ml-auto md:ml-0">
          <button class="flex items-center gap-2 px-4 py-2.5 ring-1 ring-border hover:ring-primary rounded-button text-foreground font-medium transition-all duration-200 cursor-pointer">
            <i data-lucide="download" class="w-4 h-4"></i>
            <span>Export Report</span>
          </button>
          <button class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-button font-medium hover:bg-primary-hover transition-all duration-200 cursor-pointer">
            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
            <span>Refresh</span>
          </button>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Total Siswa -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
          <div class="flex items-center gap-[6px]">
            <div class="size-11 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
              <i data-lucide="users" class="size-6 text-primary"></i>
            </div>
            <p class="font-medium text-secondary">Total Siswa</p>
          </div>
          <div class="flex items-center gap-3">
            <p class="font-bold text-[32px] leading-10">{{ number_format($stats['students']) }}</p>
            <span class="text-success text-sm font-semibold">+5%</span>
          </div>
        </div>

        <!-- Total Guru -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
          <div class="flex items-center gap-[6px]">
            <div class="size-11 bg-success/10 rounded-xl flex items-center justify-center shrink-0">
              <i data-lucide="user-check" class="size-6 text-success"></i>
            </div>
            <p class="font-medium text-secondary">Total Guru</p>
          </div>
          <p class="font-bold text-[32px] leading-10">{{ number_format($stats['teachers']) }}</p>
        </div>

        <!-- Total Kelas -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
          <div class="flex items-center gap-[6px]">
            <div class="size-11 bg-warning/10 rounded-xl flex items-center justify-center shrink-0">
              <i data-lucide="book-open" class="size-6 text-warning-dark"></i>
            </div>
            <p class="font-medium text-secondary">Total Kelas</p>
          </div>
          <p class="font-bold text-[32px] leading-10">{{ number_format($stats['classes']) }}</p>
        </div>

        <!-- Absensi Hari Ini -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-3 bg-white">
          <div class="flex items-center gap-[6px]">
            <div class="size-11 bg-info/10 rounded-xl flex items-center justify-center shrink-0">
              <i data-lucide="calendar-check" class="size-6 text-info"></i>
            </div>
            <p class="font-medium text-secondary">Absensi Hari Ini</p>
          </div>
          <div class="flex items-center gap-3">
            <p class="font-bold text-[32px] leading-10">{{ $summary['attendance_today_pct'] }}%</p>
            <span class="text-success text-sm font-semibold">+2%</span>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Grafik Absensi Siswa Chart -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-6 bg-white">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex flex-col gap-3">
              <div class="flex items-center gap-[6px]">
                <div class="size-11 bg-success/10 rounded-xl flex items-center justify-center shrink-0">
                  <i data-lucide="trending-up" class="size-6 text-success"></i>
                </div>
                <p class="font-medium text-secondary">Grafik Tren Absensi</p>
              </div>
              <p class="font-bold text-[32px] leading-10">{{ $summary['attendance_today_pct'] }}%</p>
            </div>
            <button class="flex items-center rounded-3xl border border-border py-3 px-4 gap-2 bg-primary/10 w-fit cursor-pointer hover:bg-primary/20 transition-all duration-300">
              <i data-lucide="calendar" class="size-5 text-primary"></i>
              <p class="font-medium text-sm text-primary">Last 7 Days</p>
            </button>
          </div>
          <div class="w-full overflow-x-auto">
              <div class="min-w-[400px] h-[250px] md:h-[300px]">
              <canvas id="attendanceChart"></canvas>
            </div>
          </div>
        </div>

        <!-- Grafik PPDB Chart -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-4 bg-white">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <h3 class="font-bold text-lg text-foreground">Distribusi Kelas</h3>
            <button class="flex items-center rounded-3xl border border-border py-2 px-4 gap-2 bg-primary/10 w-fit cursor-pointer">
              <i data-lucide="pie-chart" class="size-4 text-primary"></i>
              <p class="font-medium text-sm text-primary">By Faculty</p>
            </button>
          </div>
          <div class="w-full overflow-x-auto">
            <div class="min-w-[400px] h-[250px] md:h-[300px]">
              <canvas id="ppdbChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Activities Chart (Monthly) -->
      <div class="flex flex-col rounded-2xl border border-border p-6 gap-6 bg-white mb-6 md:mb-8">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-[6px]">
            <div class="size-11 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
              <i data-lucide="bar-chart-2" class="size-6 text-primary"></i>
            </div>
            <p class="font-medium text-secondary">School Activities (Monthly)</p>
          </div>
          <p class="font-bold text-sm text-secondary">Monthly Overview</p>
        </div>
        <div class="w-full overflow-x-auto">
          <div class="min-w-[600px] h-[280px] md:h-[320px]">
            <canvas id="activitiesChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Additional Sections -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Laporan Hari Ini -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-4 bg-white">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <h3 class="font-bold text-lg text-foreground">Laporan Hari Ini</h3>
            <a href="#" class="cursor-pointer"><span class="text-sm text-primary font-semibold hover:underline">View All</span></a>
          </div>
          <div class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="Student profile">
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">John Smith enrolled in Computer Science</h4>
                  <p class="text-gray-500 text-xs truncate">New student registration • CS Department</p>
                </div>
              </div>
              <div class="flex items-center gap-2 pl-13 sm:pl-0 sm:flex-shrink-0">
                <span class="text-gray-500 text-xs whitespace-nowrap">2 hours ago</span>
                <span class="bg-success-light text-success-dark text-xs font-medium px-2 py-1 rounded-full whitespace-nowrap">Enrolled</span>
              </div>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="Lecturer profile">
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">Dr. Sarah Johnson updated course materials</h4>
                  <p class="text-gray-500 text-xs truncate">Mathematics 101 • Course update</p>
                </div>
              </div>
              <div class="flex items-center gap-2 pl-13 sm:pl-0 sm:flex-shrink-0">
                <span class="text-gray-500 text-xs whitespace-nowrap">4 hours ago</span>
                <span class="bg-info-light text-info-dark text-xs font-medium px-2 py-1 rounded-full whitespace-nowrap">Updated</span>
              </div>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="Admin profile">
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">System backup completed successfully</h4>
                  <p class="text-gray-500 text-xs truncate">Database backup • System maintenance</p>
                </div>
              </div>
              <div class="flex items-center gap-2 pl-13 sm:pl-0 sm:flex-shrink-0">
                <span class="text-gray-500 text-xs whitespace-nowrap">6 hours ago</span>
                <span class="bg-success-light text-success-dark text-xs font-medium px-2 py-1 rounded-full whitespace-nowrap">Complete</span>
              </div>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop" class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="Student profile">
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">Emma Wilson submitted assignment</h4>
                  <p class="text-gray-500 text-xs truncate">Physics 201 • Assignment submission</p>
                </div>
              </div>
              <div class="flex items-center gap-2 pl-13 sm:pl-0 sm:flex-shrink-0">
                <span class="text-gray-500 text-xs whitespace-nowrap">8 hours ago</span>
                <span class="bg-warning-light text-warning-dark text-xs font-medium px-2 py-1 rounded-full whitespace-nowrap">Submitted</span>
              </div>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop" class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="Lecturer profile">
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">Prof. Michael Brown scheduled exam</h4>
                  <p class="text-gray-500 text-xs truncate">Chemistry 301 • Final examination</p>
                </div>
              </div>
              <div class="flex items-center gap-2 pl-13 sm:pl-0 sm:flex-shrink-0">
                <span class="text-gray-500 text-xs whitespace-nowrap">1 day ago</span>
                <span class="bg-alert-light text-alert-dark text-xs font-medium px-2 py-1 rounded-full whitespace-nowrap">Scheduled</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Aktivitas Sekolah -->
        <div class="flex flex-col rounded-2xl border border-border p-6 gap-4 bg-white">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <h3 class="font-bold text-lg text-foreground">Aktivitas Sekolah</h3>
            <a href="#" class="cursor-pointer"><span class="text-sm text-primary font-semibold hover:underline">Lihat Semua</span></a>
          </div>
          <div class="space-y-4">
            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                  <i data-lucide="book-open" class="w-5 h-5 text-primary"></i>
                </div>
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">Mathematics 101</h4>
                  <p class="text-gray-500 text-xs truncate">Room A-205 • Dr. Sarah Johnson</p>
                </div>
              </div>
              <div class="text-right flex-shrink-0">
                <p class="text-foreground text-sm font-semibold">09:00 AM</p>
                <span class="bg-success-light text-success-dark text-xs font-medium px-2 py-1 rounded-full">Today</span>
              </div>
            </div>
            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <div class="w-10 h-10 bg-warning/10 rounded-xl flex items-center justify-center flex-shrink-0">
                  <i data-lucide="flask-conical" class="w-5 h-5 text-warning-dark"></i>
                </div>
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">Chemistry Lab</h4>
                  <p class="text-gray-500 text-xs truncate">Lab B-102 • Prof. Michael Brown</p>
                </div>
              </div>
              <div class="text-right flex-shrink-0">
                <p class="text-foreground text-sm font-semibold">11:30 AM</p>
                <span class="bg-success-light text-success-dark text-xs font-medium px-2 py-1 rounded-full">Today</span>
              </div>
            </div>
            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <div class="w-10 h-10 bg-info/10 rounded-xl flex items-center justify-center flex-shrink-0">
                  <i data-lucide="monitor" class="w-5 h-5 text-info"></i>
                </div>
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">Computer Science 201</h4>
                  <p class="text-gray-500 text-xs truncate">Room C-301 • Dr. Lisa Anderson</p>
                </div>
              </div>
              <div class="text-right flex-shrink-0">
                <p class="text-foreground text-sm font-semibold">02:00 PM</p>
                <span class="bg-info-light text-info-dark text-xs font-medium px-2 py-1 rounded-full">Today</span>
              </div>
            </div>
            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <div class="w-10 h-10 bg-success/10 rounded-xl flex items-center justify-center flex-shrink-0">
                  <i data-lucide="globe" class="w-5 h-5 text-success"></i>
                </div>
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">English Literature</h4>
                  <p class="text-gray-500 text-xs truncate">Room D-105 • Prof. James Wilson</p>
                </div>
              </div>
              <div class="text-right flex-shrink-0">
                <p class="text-foreground text-sm font-semibold">10:00 AM</p>
                <span class="bg-warning-light text-warning-dark text-xs font-medium px-2 py-1 rounded-full">Tomorrow</span>
              </div>
            </div>
            <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
              <div class="flex items-center gap-3 min-w-0 flex-1">
                <div class="w-10 h-10 bg-alert/10 rounded-xl flex items-center justify-center flex-shrink-0">
                  <i data-lucide="calculator" class="w-5 h-5 text-alert"></i>
                </div>
                <div class="min-w-0 flex-1">
                  <h4 class="text-foreground text-sm font-medium truncate">Statistics 301</h4>
                  <p class="text-gray-500 text-xs truncate">Room A-108 • Dr. Robert Davis</p>
                </div>
              </div>
              <div class="text-right flex-shrink-0">
                <p class="text-foreground text-sm font-semibold">03:30 PM</p>
                <span class="bg-warning-light text-warning-dark text-xs font-medium px-2 py-1 rounded-full">Tomorrow</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Alerts Section -->
      <div class="flex flex-col rounded-2xl border border-border p-6 gap-4 bg-white">
        <h3 class="font-bold text-lg text-foreground">Notifikasi Sistem</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="p-4 bg-warning-light rounded-card border-l-4 border-warning">
            <div class="flex items-start gap-3">
              <i data-lucide="alert-triangle" class="w-5 h-5 text-warning-dark flex-shrink-0 mt-0.5"></i>
              <div>
                <h4 class="text-foreground text-sm font-medium">Low Attendance Alert</h4>
                <p class="text-gray-500 text-xs mt-1">Physics 201 class has attendance below 75% threshold</p>
              </div>
            </div>
          </div>
          <div class="p-4 bg-info-light rounded-card border-l-4 border-info">
            <div class="flex items-start gap-3">
              <i data-lucide="info" class="w-5 h-5 text-info-dark flex-shrink-0 mt-0.5"></i>
              <div>
                <h4 class="text-foreground text-sm font-medium">System Maintenance</h4>
                <p class="text-gray-500 text-xs mt-1">Scheduled maintenance tonight from 11 PM to 2 AM</p>
              </div>
            </div>
          </div>
          <div class="p-4 bg-error-light rounded-card border-l-4 border-error">
            <div class="flex items-start gap-3">
              <i data-lucide="alert-circle" class="w-5 h-5 text-error-dark flex-shrink-0 mt-0.5"></i>
              <div>
                <h4 class="text-foreground text-sm font-medium">Assignment Deadline</h4>
                <p class="text-gray-500 text-xs mt-1">15 assignments are due within the next 24 hours</p>
              </div>
            </div>
          </div>
          <div class="p-4 bg-success-light rounded-card border-l-4 border-success">
            <div class="flex items-start gap-3">
              <i data-lucide="check-circle" class="w-5 h-5 text-success-dark flex-shrink-0 mt-0.5"></i>
              <div>
                <h4 class="text-foreground text-sm font-medium">Backup Complete</h4>
                <p class="text-gray-500 text-xs mt-1">Daily database backup completed successfully at 3:00 AM</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- Page Not Found Modal -->
<div id="page-not-found-modal" class="fixed inset-0 bg-black/50 z-[100] hidden flex items-center justify-center p-4">
  <div class="bg-white rounded-card p-6 max-w-sm w-full text-center">
    <div class="w-16 h-16 bg-warning-light rounded-full flex items-center justify-center mx-auto mb-4">
      <i data-lucide="alert-triangle" class="w-8 h-8 text-warning-dark"></i>
    </div>
    <h3 class="text-foreground text-xl font-bold mb-2">Page Not Available</h3>
    <p class="text-gray-500 text-sm mb-6">This page hasn't been created yet. Generate it using the chat!</p>
    <button onclick="closePageNotFoundModal()" class="w-full px-4 py-2.5 bg-primary text-white rounded-button font-medium hover:bg-primary-hover transition-all duration-200 cursor-pointer">
      Got it
    </button>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  lucide.createIcons();

  // Show modal only for links explicitly marked as not-yet-implemented
  document.querySelectorAll('a[data-page-not-found]').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      document.getElementById('page-not-found-modal').classList.remove('hidden');
    });
  });

  // Initialize charts
  initializeCharts();
});

function closePageNotFoundModal() {
  document.getElementById('page-not-found-modal').classList.add('hidden');
}

function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');
  sidebar.classList.toggle('-translate-x-full');
  overlay.classList.toggle('hidden');
  document.body.classList.toggle('overflow-hidden');
}

function toggleSekolah() {
  const menu = document.getElementById('menuSekolah');
  const arrow = document.getElementById('arrowSekolah');

  if (!menu || !arrow) return;

  menu.classList.toggle('hidden');
  arrow.classList.toggle('rotate-180');
}

function initializeCharts() {
  // Prepare data passed from controller
  const attendanceLabels = {!! json_encode($attendance_labels) !!};
  const hadir = {!! json_encode($attendance['hadir']) !!};
  const izin = {!! json_encode($attendance['izin']) !!};
  const sakit = {!! json_encode($attendance['sakit']) !!};
  const alpha = {!! json_encode($attendance['alpha']) !!};

  const ppdbLabels = {!! json_encode($ppdb_labels) !!};
  const ppdbData = {!! json_encode($ppdb) !!};

  const months = {!! json_encode($months) !!};
  const activities = {!! json_encode($activities) !!};

  // Attendance Trend Chart (Line with multiple series)
  new Chart(document.getElementById('attendanceChart'), {
    type: 'line',
    data: {
      labels: attendanceLabels,
      datasets: [
        {
          label: 'Hadir',
          data: hadir,
          borderColor: '#165DFF',
          backgroundColor: 'rgba(22, 93, 255, 0.08)',
          fill: true,
          tension: 0.35
        },
        {
          label: 'Izin',
          data: izin,
          borderColor: '#F59E0B',
          backgroundColor: 'rgba(245,158,11,0.06)',
          fill: true,
          tension: 0.35
        },
        {
          label: 'Sakit',
          data: sakit,
          borderColor: '#EF4444',
          backgroundColor: 'rgba(239,68,68,0.06)',
          fill: true,
          tension: 0.35
        },
        {
          label: 'Alpha',
          data: alpha,
          borderColor: '#6B7280',
          backgroundColor: 'rgba(107,114,128,0.06)',
          fill: true,
          tension: 0.35
        }
      ]
    },
    options: {
      animation: false,
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom' } },
      scales: { y: { beginAtZero: true, max: 100, ticks: { callback: v => v + '%' } } }
    }
  });

  // PPDB Doughnut Chart
  new Chart(document.getElementById('ppdbChart'), {
    type: 'doughnut',
    data: {
      labels: ppdbLabels,
      datasets: [{ data: ppdbData, backgroundColor: ['#165DFF', '#22C55E', '#F59E0B', '#EF4444'] }]
    },
    options: { animation: false, responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
  });

  // Activities Bar Chart (monthly)
  new Chart(document.getElementById('activitiesChart'), {
    type: 'bar',
    data: {
      labels: months,
      datasets: [
        { label: 'Event Sekolah', data: activities.event, backgroundColor: '#165DFF' },
        { label: 'Ekstrakurikuler', data: activities.extracurricular, backgroundColor: '#22C55E' },
        { label: 'Ujian', data: activities.exam, backgroundColor: '#F59E0B' },
        { label: 'Rapat Guru', data: activities.meeting, backgroundColor: '#6B7280' }
      ]
    },
    options: {
      animation: false,
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom' } },
      scales: { y: { beginAtZero: true } }
    }
  });
}
</script>
@endsection