// ***********************************************
// Custom Cypress Commands for GoEdu
// ***********************************************

/**
 * Login via the UI form.
 * Usage: cy.login('admin@goedu.sch.id', 'admin123')
 */
Cypress.Commands.add('login', (email, password) => {
  cy.visit('/login')
  cy.get('input[name="email"]').clear().type(email)
  cy.get('input[name="password"]').clear().type(password)
  cy.get('form').submit()
})

/**
 * Logout via POST request (faster, no UI interaction needed).
 */
Cypress.Commands.add('logout', () => {
  cy.get('form[action*="logout"]').first().submit()
})
