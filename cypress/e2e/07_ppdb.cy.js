/// <reference types="cypress" />

describe('Portal PPDB - Landing & Jenjang', () => {
  it('menampilkan halaman landing PPDB', () => {
    cy.visit('/ppdb')
    cy.contains('Peserta Didik Baru').should('be.visible')
  })

  const jenjang = ['sd', 'smp', 'sma', 'smk']
  jenjang.forEach((j) => {
    it(`menampilkan halaman informasi jenjang ${j.toUpperCase()}`, () => {
      cy.visit(`/ppdb/${j}`)
      cy.url().should('include', `/ppdb/${j}`)
    })
  })
})

describe('Portal PPDB - Alur Pendaftaran & Akses Peserta', () => {
  const candidateName = 'Cypress PPDB Candidate'
  const candidateNISN = Math.floor(1000000000 + Math.random() * 9000000000).toString() // Generate unique 10-digit NISN
  const candidateDOB = '2010-08-18'

  it('menyelesaikan alur pendaftaran, cek status, dan login peserta', () => {
    // 1. Pendaftaran
    cy.visit('/ppdb/daftar')
    cy.contains('Pendaftaran').should('be.visible')

    cy.get('input[name="nama"]').type(candidateName)
    cy.get('input[name="nisn"]').type(candidateNISN)
    cy.get('input[name="tanggal_lahir"]').type(candidateDOB)
    cy.get('select[name="jurusan"]').select('Kelas 7')
    cy.get('select[name="jalur"]').select('Reguler')
    cy.get('input[name="asal_sekolah"]').type('SMP Cypress Automation')
    cy.get('input[name="email"]').type('cypress_candidate@test.com')
    cy.get('input[name="telepon"]').type('081398765432')

    cy.contains('DAFTAR SEKARANG').click()
    cy.url().should('not.include', '/ppdb/daftar')

    // 2. Pengecekan Status Pendaftaran
    cy.visit('/ppdb/cek-status')
    cy.contains('Cek Status').should('be.visible')

    cy.get('input[x-model="query"]').type(candidateNISN)
    cy.contains('Cek Status Sekarang').click()
    cy.contains(candidateName).should('be.visible')

    // 3. Login ke Dashboard Peserta
    cy.visit('/ppdb/dashboard')
    cy.contains('Keluar').click()
    cy.url().should('include', '/ppdb/login')
    cy.contains('Login Peserta').should('be.visible')

    cy.get('input[name="nisn"]').type(candidateNISN)
    cy.get('input[name="tanggal_lahir"]').type(candidateDOB)

    cy.contains('Masuk ke Dashboard').click()
    cy.url().should('include', '/ppdb/dashboard')
    cy.contains('Selamat Datang').should('be.visible')
    cy.contains(candidateName).should('be.visible')
  })
})
