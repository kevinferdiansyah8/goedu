/// <reference types="cypress" />

describe('Orang Tua Portal - E2E Test Suite', () => {
  beforeEach(() => {
    cy.login('orangtua@goedu.sch.id', 'orangtua123')
  })

  // ==========================================
  // Dashboard & Monitoring
  // ==========================================
  it('menampilkan dashboard orang tua dengan info anak', () => {
    cy.visit('/orangtua/dashboard')
    cy.contains('Selamat Datang, Bapak/Ibu').should('be.visible')
  })

  // ==========================================
  // Monitoring Anak
  // ==========================================
  it('melihat monitoring presensi anak', () => {
    cy.visit('/orangtua/monitoring/presensi')
    cy.url().should('include', '/monitoring/presensi')
  })

  it('melihat monitoring nilai anak', () => {
    cy.visit('/orangtua/monitoring/nilai')
    cy.url().should('include', '/monitoring/nilai')
  })

  it('melihat monitoring SPP anak', () => {
    cy.visit('/orangtua/monitoring/spp')
    cy.url().should('include', '/monitoring/spp')
  })

  // ==========================================
  // Akademik Anak
  // ==========================================
  it('melihat tugas anak', () => {
    cy.visit('/orangtua/akademik/tugas')
    cy.url().should('include', '/akademik/tugas')
  })

  it('melihat rapor anak', () => {
    cy.visit('/orangtua/akademik/rapor')
    cy.url().should('include', '/akademik/rapor')
  })

  it('melihat jadwal pelajaran anak', () => {
    cy.visit('/orangtua/akademik/jadwal')
    cy.url().should('include', '/akademik/jadwal')
  })

  // ==========================================
  // Absensi Anak & Pengajuan Izin
  // ==========================================
  it('melihat riwayat absensi anak', () => {
    cy.visit('/orangtua/absensi/riwayat')
    cy.url().should('include', '/absensi/riwayat')
  })

  it('mengajukan izin untuk anak', () => {
    cy.visit('/orangtua/absensi/izin')
    cy.url().should('include', '/absensi/izin')

    // Cek apakah form tersedia
    cy.get('body').then($body => {
      if ($body.find('select[name="jenis"]').length > 0) {
        cy.get('select[name="jenis"]').select('Izin')

        const tomorrow = new Date()
        tomorrow.setDate(tomorrow.getDate() + 1)
        const tomorrowStr = tomorrow.toISOString().split('T')[0]

        cy.get('input[name="tanggal_mulai"]').type(tomorrowStr)
        cy.get('input[name="tanggal_selesai"]').type(tomorrowStr)
        cy.get('textarea[name="keterangan"]').type('Izin ada acara keluarga. (Test Cypress - Orang Tua)')

        cy.contains('Kirim').click()
      }
    })
  })

  it('melihat rekap absensi anak', () => {
    cy.visit('/orangtua/absensi/rekap')
    cy.url().should('include', '/absensi/rekap')
  })

  // ==========================================
  // Keuangan (SPP)
  // ==========================================
  it('melihat tagihan SPP anak', () => {
    cy.visit('/orangtua/keuangan/tagihan')
    cy.url().should('include', '/keuangan/tagihan')
  })

  it('melihat riwayat pembayaran', () => {
    cy.visit('/orangtua/keuangan/riwayat')
    cy.url().should('include', '/keuangan/riwayat')
  })

  it('mengakses form upload bukti pembayaran', () => {
    cy.visit('/orangtua/keuangan/bukti')
    cy.url().should('include', '/keuangan/bukti')
  })

  // ==========================================
  // Kegiatan & Info
  // ==========================================
  it('melihat agenda sekolah', () => {
    cy.visit('/orangtua/kegiatan/agenda')
    cy.url().should('include', '/kegiatan/agenda')
  })

  it('melihat event sekolah', () => {
    cy.visit('/orangtua/kegiatan/event')
    cy.url().should('include', '/kegiatan/event')
  })

  it('melihat pengumuman sekolah', () => {
    cy.visit('/orangtua/kegiatan/pengumuman')
    cy.url().should('include', '/kegiatan/pengumuman')
  })

  // ==========================================
  // Profil
  // ==========================================
  it('melihat data diri orang tua', () => {
    cy.visit('/orangtua/profil/data-diri')
    cy.url().should('include', '/profil/data-diri')
  })

  it('melihat data anak', () => {
    cy.visit('/orangtua/profil/data-anak')
    cy.url().should('include', '/profil/data-anak')
  })

  it('mengakses halaman ganti password', () => {
    cy.visit('/orangtua/profil/password')
    cy.url().should('include', '/profil/password')
  })
})
