// ***********************************************************
// This support file is processed and loaded automatically
// before every test file.
//
// https://docs.cypress.io/guides/core-concepts/writing-and-organizing-tests#Support-file
// ***********************************************************

import './commands'

// =============================================================
// SLOW MODE: Tambahkan delay 1 detik di setiap command
// Hapus/comment block ini kalau mau kembali ke kecepatan normal
// =============================================================
const COMMAND_DELAY = 1000 // milliseconds (1000 = 1 detik)

const commandsToDelay = ['visit', 'click', 'type', 'clear', 'check', 'uncheck', 'select', 'submit', 'trigger']

for (const command of commandsToDelay) {
  Cypress.Commands.overwrite(command, (originalFn, ...args) => {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(originalFn(...args))
      }, COMMAND_DELAY)
    })
  })
}

// Hide fetch/xhr logs in the Command Log for cleaner output
Cypress.on('uncaught:exception', (err, runnable) => {
  // Returning false prevents Cypress from failing the test on uncaught app exceptions
  return false
})

// =============================================================
// JEDA SETELAH CASE SELESAI: Beri waktu 3 detik agar user bisa melihat hasilnya
// =============================================================
afterEach(() => {
  cy.wait(3000) // Jeda 3000ms (3 detik) setelah setiap it() selesai
})
