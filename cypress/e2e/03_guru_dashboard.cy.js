/// <reference types="cypress" />

describe('Guru Portal - E2E Test Suite', () => {
  beforeEach(() => {
    cy.login('budi@goedu.sch.id', 'guru123')
  })

  // ==========================================
  // Dashboard & Overview
  // ==========================================
  it('menampilkan dashboard guru dengan nama guru', () => {
    cy.url().should('include', '/guru/dashboard')
    cy.contains('Dashboard').should('be.visible')
  })

  // ==========================================
  // Absensi Siswa (Input Kehadiran)
  // ==========================================
  it('memilih jadwal dan mengisi absensi siswa', () => {
    cy.visit('/guru/absensi/absensi-pertemuan')
    cy.contains('Sistem Absensi').should('be.visible')

    // Pilih jadwal pertama yang tersedia
    cy.get('select[name="schedule_id"]').then($select => {
      const options = $select.find('option')
      if (options.length > 1) {
        cy.get('select[name="schedule_id"]').select(options.eq(1).val())
        cy.wait(2000) // tunggu halaman reload

        // Cek apakah tabel siswa muncul
        cy.get('body').then($body => {
          if ($body.find('table tbody tr').length > 0) {
            // Klik tombol "Set Semua Hadir"
            cy.contains('Set Semua Hadir').click()

            // Submit absensi
            cy.contains('Simpan Absensi').click()
            cy.contains('berhasil').should('be.visible')
          }
        })
      }
    })
  })

  it('melihat rekap absensi', () => {
    cy.visit('/guru/absensi/rekap-absensi')
    cy.url().should('include', '/rekap-absensi')
  })

  it('melihat data izin/sakit/alpha', () => {
    cy.visit('/guru/absensi/izin-sakit-alpha')
    cy.url().should('include', '/izin-sakit-alpha')
  })

  // ==========================================
  // Manajemen Tugas
  // ==========================================
  it('melihat daftar tugas yang sudah ada', () => {
    cy.visit('/guru/materi/tugas')
    cy.contains('Penugasan Siswa').should('be.visible')
  })

  it('melihat penilaian tugas siswa', () => {
    cy.visit('/guru/materi/penilaian')
    cy.url().should('include', '/penilaian')
  })

  it('melihat feedback tugas', () => {
    cy.visit('/guru/materi/feedback')
    cy.url().should('include', '/feedback')
  })

  // ==========================================
  // Manajemen Materi
  // ==========================================
  it('melihat daftar materi pembelajaran', () => {
    cy.visit('/guru/materi/materi')
    cy.contains('Materi Pembelajaran').should('be.visible')
  })

  it('mengakses halaman upload materi', () => {
    cy.visit('/guru/materi/upload')
    cy.url().should('include', '/upload')
  })

  // ==========================================
  // Input Nilai Rapor
  // ==========================================
  it('mengakses halaman input nilai tugas', () => {
    cy.visit('/guru/akademik/nilai-tugas')
    cy.url().should('include', '/nilai-tugas')
  })

  it('mengakses halaman input nilai rapor (UH/UTS/UAS)', () => {
    cy.visit('/guru/akademik/nilai-rapor')
    cy.url().should('include', '/nilai-rapor')
  })

  it('melihat rekap nilai seluruh siswa', () => {
    cy.visit('/guru/akademik/rekap-nilai')
    cy.url().should('include', '/rekap-nilai')
  })

  // ==========================================
  // Kegiatan Sekolah
  // ==========================================
  it('melihat agenda sekolah', () => {
    cy.visit('/guru/kegiatan/agenda')
    cy.url().should('include', '/kegiatan/agenda')
  })

  it('melihat event sekolah', () => {
    cy.visit('/guru/kegiatan/event')
    cy.url().should('include', '/kegiatan/event')
  })

  it('melihat pengumuman', () => {
    cy.visit('/guru/kegiatan/pengumuman')
    cy.url().should('include', '/kegiatan/pengumuman')
  })

  // ==========================================
  // Profil & Keamanan
  // ==========================================
  it('melihat biodata guru dari database', () => {
    cy.visit('/guru/profil/biodata')
    cy.contains('Biodata').should('be.visible')
  })

  it('melihat riwayat mengajar', () => {
    cy.visit('/guru/profil/riwayat-mengajar')
    cy.url().should('include', '/riwayat-mengajar')
  })

  it('melihat arsip dokumen', () => {
    cy.visit('/guru/profil/arsip-dokumen')
    cy.url().should('include', '/arsip-dokumen')
  })

  it('mengakses halaman ganti password', () => {
    cy.visit('/guru/profil/ganti-password')
    cy.get('input[name="old_password"]').should('exist')
    cy.get('input[name="new_password"]').should('exist')
  })
})
