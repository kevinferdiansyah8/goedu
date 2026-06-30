/// <reference types="cypress" />

describe('Halaman Login', () => {
  beforeEach(() => {
    cy.visit('/login')
  })

  it('menampilkan halaman login dengan benar', () => {
    cy.contains('GOEDU').should('be.visible')
    cy.contains('Selamat Datang Kembali').should('be.visible')
    cy.get('input[name="email"]').should('be.visible')
    cy.get('input[name="password"]').should('be.visible')
    cy.get('button[type="submit"]').should('contain', 'MASUK KE DASHBOARD')
  })

  it('menampilkan error jika email/password salah', () => {
    cy.get('input[name="email"]').type('salah@email.com')
    cy.get('input[name="password"]').type('passwordsalah')
    cy.get('form').submit()
    cy.get('.bg-rose-50').should('be.visible') // error alert
  })

  it('redirect ke / jika belum login', () => {
    cy.visit('/admin/dashboard')
    cy.url().should('include', '/login')
  })
})

describe('Login & Redirect Semua Role', () => {
  const roles = [
    { email: 'admin@goedu.sch.id',    password: 'admin123',    dashboardUrl: '/admin/dashboard',    title: 'Admin' },
    { email: 'budi@goedu.sch.id',     password: 'guru123',     dashboardUrl: '/guru/dashboard',     title: 'Guru' },
    { email: 'ahmad@goedu.sch.id',    password: 'siswa123',    dashboardUrl: '/siswa/dashboard',    title: 'Siswa' },
    { email: 'orangtua@goedu.sch.id', password: 'orangtua123', dashboardUrl: '/orangtua/dashboard', title: 'Orang Tua' },
    { email: 'keuangan@goedu.sch.id', password: 'keuangan123', dashboardUrl: '/keuangan/dashboard', title: 'Keuangan' },
  ]

  roles.forEach((role) => {
    it(`login sebagai ${role.title} → redirect ke dashboard`, () => {
      cy.login(role.email, role.password)
      cy.url().should('include', role.dashboardUrl)
    })
  })
})
