/// <reference types="cypress" />

describe('Admin Portal - E2E Test Suite', () => {
  beforeEach(() => {
    cy.login('admin@goedu.sch.id', 'admin123')
  })

  // ==========================================
  // Kelola Data Siswa (CRUD)
  // ==========================================
  it('melihat daftar siswa di halaman Data Siswa', () => {
    cy.visit('/admin/users')
    cy.contains('Data Siswa').should('be.visible')
    cy.get('table').should('exist')
  })

  it('menambah siswa baru via form', () => {
    cy.visit('/admin/users')
    cy.contains('Tambah Siswa').click()
    cy.wait(500) // tunggu animasi form muncul

    const uniqueNis = '999' + Math.floor(100 + Math.random() * 900);
    const uniqueNisn = '0099' + Math.floor(100000 + Math.random() * 900000);

    cy.get('input[name="nis"]').type(uniqueNis)
    cy.get('input[name="nisn"]').type(uniqueNisn)
    cy.get('input[name="nama"]').type('Cypress Test Siswa')
    cy.get('select[name="school_class_id"]').select(1) // pilih kelas pertama
    cy.get('select[name="jenis_kelamin"]').select('L')
    cy.get('input[name="telepon"]').type('081200000001')

    cy.get('form[method="POST"]').last().submit()
    cy.contains('berhasil').should('be.visible')
  })

  it('mencari siswa yang baru ditambah', () => {
    cy.visit('/admin/users')
    cy.get('input[name="search"]').type('Cypress Test Siswa')
    cy.contains('Filter').click()
    cy.contains('Cypress Test Siswa').should('be.visible')
  })

  // ==========================================
  // Kelola Pengumuman Sekolah
  // ==========================================
  it('menambah pengumuman baru', () => {
    cy.visit('/admin/kegiatan/pengumuman')
    cy.contains('Tambah Pengumuman').click()
    cy.wait(500)

    cy.get('#inputJudul').type('Pengumuman Ujian Semester Cypress')
    cy.get('#inputTarget').select('Semua')
    cy.get('#inputIsi').type('Ini adalah pengumuman otomatis yang dibuat oleh Cypress testing. Ujian semester akan dilaksanakan minggu depan.')
    cy.get('#inputTanggal').type('2026-07-01')
    cy.get('#inputStatus').select('Aktif')

    cy.get('#realPengumumanForm').submit()
    cy.contains('berhasil').should('be.visible')
  })

  // ==========================================
  // Kelola Jadwal Pelajaran
  // ==========================================
  it('mengakses halaman jadwal pelajaran dan melihat tabel', () => {
    cy.visit('/admin/akademik/jadwal-pelajaran')
    cy.contains('Jadwal Mengajar Guru').should('be.visible')
    cy.get('select[name="teacher_id"]').select(1) // select first teacher to load table
    cy.get('table').should('exist')
  })

  // ==========================================
  // Laporan
  // ==========================================
  it('mengakses dan melihat semua jenis laporan', () => {
    const laporanPages = [
      { url: '/admin/laporan/absensi', title: 'Absensi' },
      { url: '/admin/laporan/akademik', title: 'Akademik' },
      { url: '/admin/laporan/keuangan', title: 'Keuangan' },
      { url: '/admin/laporan/ppdb', title: 'PPDB' },
      { url: '/admin/laporan/kegiatan', title: 'Kegiatan' },
    ]

    laporanPages.forEach((page) => {
      cy.visit(page.url)
      cy.url().should('include', page.url)
    })
  })

  // ==========================================
  // PPDB Management
  // ==========================================
  it('melihat daftar pendaftar PPDB', () => {
    cy.visit('/admin/ppdb/data-pendaftar')
    cy.contains('Data Pendaftar').should('be.visible')
  })

  it('mengakses verifikasi berkas PPDB', () => {
    cy.visit('/admin/ppdb/verifikasi-berkas')
    cy.url().should('include', '/verifikasi-berkas')
  })

  it('mengakses seleksi PPDB', () => {
    cy.visit('/admin/ppdb/seleksi')
    cy.url().should('include', '/seleksi')
  })
})
