/// <reference types="cypress" />

describe('Siswa Portal - E2E Test Suite', () => {
  beforeEach(() => {
    cy.login('ahmad@goedu.sch.id', 'siswa123')
  })

  // ==========================================
  // Dashboard Dinamis
  // ==========================================
  it('menampilkan nama siswa & info kelas dari database', () => {
    cy.visit('/siswa/dashboard')
    cy.contains('Selamat Datang').should('be.visible')
  })

  it('menampilkan ringkasan jadwal hari ini', () => {
    cy.contains('Jadwal Hari Ini').should('be.visible')
  })

  it('mengklik tombol Lihat Semua Jadwal', () => {
    cy.contains('h2', 'Jadwal Hari Ini').parent().find('a').contains('Lihat Semua').click()
    cy.url().should('not.include', '#') // pastikan bukan link kosong
  })

  // ==========================================
  // Akademik (Jadwal, Tugas, Nilai)
  // ==========================================
  it('melihat jadwal pelajaran lengkap', () => {
    cy.visit('/siswa/akademik/jadwal')
    cy.contains('Jadwal').should('be.visible')
  })

  it('melihat daftar tugas dari guru', () => {
    cy.visit('/siswa/akademik/tugas')
    cy.url().should('include', '/akademik/tugas')
  })

  it('melihat rekap nilai & rapor', () => {
    cy.visit('/siswa/akademik/nilai')
    cy.url().should('include', '/akademik/nilai')
  })

  // ==========================================
  // Kehadiran (Riwayat & Pengajuan Izin)
  // ==========================================
  it('melihat riwayat kehadiran', () => {
    cy.visit('/siswa/kehadiran/riwayat')
    cy.url().should('include', '/kehadiran/riwayat')
  })

  it('mengisi form pengajuan izin sakit', () => {
    cy.visit('/siswa/kehadiran/izin')
    cy.contains('Pengajuan Izin').should('be.visible')

    // Isi form izin
    cy.get('select[name="jenis"]').select('Sakit')

    // Tanggal mulai = besok
    const tomorrow = new Date()
    tomorrow.setDate(tomorrow.getDate() + 1)
    const tomorrowStr = tomorrow.toISOString().split('T')[0]

    const dayAfter = new Date()
    dayAfter.setDate(dayAfter.getDate() + 2)
    const dayAfterStr = dayAfter.toISOString().split('T')[0]

    cy.get('input[name="tanggal_mulai"]').type(tomorrowStr)
    cy.get('input[name="tanggal_selesai"]').type(dayAfterStr)
    cy.get('textarea[name="keterangan"]').type('Sakit demam tinggi, perlu istirahat di rumah. (Test Cypress)')

    // Submit form
    cy.contains('Kirim Pengajuan').click()
    cy.contains('berhasil').should('be.visible')
  })

  it('melihat rekap bulanan kehadiran', () => {
    cy.visit('/siswa/kehadiran/rekap')
    cy.url().should('include', '/kehadiran/rekap')
  })

  // ==========================================
  // Pembelajaran (Materi & Upload Tugas)
  // ==========================================
  it('melihat daftar materi yang tersedia untuk di-download', () => {
    cy.visit('/siswa/pembelajaran/materi')
    cy.contains('Materi').should('be.visible')
  })

  it('melihat daftar tugas yang bisa dikumpulkan', () => {
    cy.visit('/siswa/pembelajaran/tugas')
    cy.url().should('include', '/pembelajaran/tugas')
  })

  it('melihat status penilaian tugas', () => {
    cy.visit('/siswa/pembelajaran/nilai')
    cy.url().should('include', '/pembelajaran/nilai')
  })

  // ==========================================
  // Kegiatan Sekolah
  // ==========================================
  it('melihat event sekolah', () => {
    cy.visit('/siswa/kegiatan/event')
    cy.url().should('include', '/kegiatan/event')
  })

  it('melihat agenda sekolah', () => {
    cy.visit('/siswa/kegiatan/agenda')
    cy.url().should('include', '/kegiatan/agenda')
  })

  it('melihat dokumentasi kegiatan', () => {
    cy.visit('/siswa/kegiatan/dokumentasi')
    cy.url().should('include', '/kegiatan/dokumentasi')
  })

  // ==========================================
  // Profil & Data Diri
  // ==========================================
  it('melihat biodata diri dari database', () => {
    cy.visit('/siswa/profil/biodata')
    cy.contains('Biodata').should('be.visible')
  })

  it('melihat data orang tua', () => {
    cy.visit('/siswa/profil/orangtua')
    cy.url().should('include', '/profil/orangtua')
  })

  it('mengakses halaman ganti password', () => {
    cy.visit('/siswa/profil/password')
    cy.url().should('include', '/profil/password')
  })
})
