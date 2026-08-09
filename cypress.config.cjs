const { defineConfig } = require('cypress')

module.exports = defineConfig({
  e2e: {
    baseUrl: 'https://rtigroup.site',
    supportFile: 'cypress/support/e2e.js',
    specPattern: 'cypress/e2e/**/*.cy.js',
    viewportWidth: 1280,
    viewportHeight: 720,
    defaultCommandTimeout: 20000,
    pageLoadTimeout: 30000,
    video: false,
    screenshotOnRunFailure: true,
    chromeWebSecurity: false,
  },
})
