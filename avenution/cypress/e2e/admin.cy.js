describe('Admin Features', () => {
  
  it('menolak akses user biasa ke halaman admin', () => {
    // Login sebagai user biasa
    cy.visit('/login')
    cy.get('input[name="login"]').type('user@avenution.com')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()

    // Paksa akses halaman admin
    cy.request({ url: '/admin', failOnStatusCode: false }).then((response) => {
      expect(response.status).to.be.oneOf([403, 404, 302]) // Tergantung implementasi middleware admin
    })
  })

  it('mengizinkan akses admin ke dashboard admin', () => {
    // Login sebagai admin (asumsi ada admin@avenution.com)
    cy.visit('/login')
    cy.get('input[name="login"]').type(Cypress.env('adminUsername'))
    cy.get('input[name="password"]').type(Cypress.env('adminPassword'))
    cy.get('button[type="submit"]').click()

    // Coba akses admin dashboard
    cy.visit('/admin')
    cy.url().should('include', '/admin')
    cy.contains('Admin Dashboard', { matchCase: false }).should('be.visible')
  })

  it('admin bisa melihat daftar makanan', () => {
    // Login sebagai admin
    cy.visit('/login')
    cy.get('input[name="login"]').type(Cypress.env('adminUsername'))
    cy.get('input[name="password"]').type(Cypress.env('adminPassword'))
    cy.get('button[type="submit"]').click()

    // Akses daftar makanan
    cy.visit('/admin/foods')
    cy.contains('Manage Foods', { matchCase: false }).should('be.visible')
  })
})
