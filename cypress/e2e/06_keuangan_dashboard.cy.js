/// <reference types="cypress" />

describe('Keuangan Portal - E2E Test Suite', () => {
  beforeEach(() => {
    cy.login('keuangan@goedu.sch.id', 'keuangan123')
  })

  // ==========================================
  // Dashboard & Laporan Keuangan
  // ==========================================
  it('menampilkan dashboard keuangan', () => {
    cy.visit('/keuangan/dashboard')
    cy.url().should('include', '/keuangan/dashboard')
    cy.contains('Dashboard').should('be.visible')
  })

  it('menambah transaksi keuangan manual', () => {
    cy.visit('/keuangan/laporan')
    cy.contains('Tambah Transaksi').click()
    cy.wait(500) // Wait for modal animation

    // Fill the transaction details
    cy.get('input[name="tanggal"]').type('2026-06-26')
    cy.get('input[name="jenis"][value="Masuk"]').check()
    cy.get('input[name="nominal"]').type('750000')
    cy.get('input[name="keterangan"]').type('Dana Hibah CSR Perusahaan Partner (Cypress)')
    cy.get('select[name="metode"]').select('Transfer Bank')

    // Submit form
    cy.contains('Simpan Transaksi').click()
    cy.contains('berhasil').should('be.visible')
  })

  it('dapat melihat dan memfilter transaksi', () => {
    cy.visit('/keuangan/laporan')
    cy.contains('Transaksi Terbaru').should('be.visible')
    cy.get('table').should('exist')
  })

  // ==========================================
  // Verifikasi & Riwayat Pembayaran Siswa
  // ==========================================
  it('mengakses daftar tagihan siswa', () => {
    cy.visit('/keuangan/pembayaran-siswa/tagihan')
    cy.contains('Tagihan').should('be.visible')
  })

  it('mengakses riwayat pembayaran', () => {
    cy.visit('/keuangan/pembayaran-siswa/riwayat')
    cy.url().should('include', '/pembayaran-siswa/riwayat')
  })

  it('memproses verifikasi bukti pembayaran SPP', () => {
    cy.visit('/keuangan/pembayaran-siswa/verifikasi')
    cy.contains('Verifikasi Pembayaran').should('be.visible')

    // If there is a pending verification, click "Terima"
    cy.get('body').then(($body) => {
      if ($body.find('form input[name="status"][value="Terverifikasi"]').length > 0) {
        cy.get('form').contains('Terima').first().click()
        cy.contains('berhasil').should('be.visible')
      } else {
        cy.contains('Semua Terverifikasi!').should('be.visible')
      }
    })
  })

  // ==========================================
  // PPDB Biaya & Pembayaran
  // ==========================================
  it('mengakses pengaturan biaya pendaftaran PPDB', () => {
    cy.visit('/keuangan/ppdb/biaya-pendaftaran')
    cy.contains('Pendaftaran').should('be.visible')
  })

  it('mengakses pembayaran PPDB', () => {
    cy.visit('/keuangan/ppdb/pembayaran')
    cy.url().should('include', '/ppdb/pembayaran')
  })
})
