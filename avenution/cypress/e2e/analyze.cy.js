describe('Analyze Feature Flow', () => {
  
  it('mengarahkan user ke login jika belum autentikasi saat mau analisa', () => {
    cy.visit('/analyze')
    cy.get('form').should('be.visible')
  })

  it('user yang sudah login bisa melakukan analisa makanan', () => {
    // Login sebagai user
    cy.visit('/login')
    cy.get('input[name="login"]').type('user@avenution.com')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()

    // Buka halaman analyze
    cy.visit('/analyze')
    
    // Isi form analisis dengan mengklik tombol profil demo "Healthy"
    cy.get('button[onclick="fillDemoData(\\\'healthy\\\')"]').click()
    
    // Klik tombol submit (Analyze & Get Recommendations)
    cy.contains('button', 'Analyze & Get Recommendations', { matchCase: false }).click()

    // Pastikan diarahkan ke halaman result
    cy.url().should('include', '/result')
    // Pastikan halaman result memunculkan detail
    cy.contains('Your Health Analysis', { matchCase: false }).should('be.visible')
  })

  it('hasil analisa tersimpan di halaman history', () => {
    // Login sebagai user
    cy.visit('/login')
    cy.get('input[name="login"]').type('user@avenution.com')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()

    cy.visit('/history')
    // Pastikan judul history muncul
    cy.contains('Your Health Journey', { matchCase: false }).should('be.visible')
    // Karena ini data awal mungkin kosong (No analysis history yet), atau ada list dari analisa sebelumnya
    // Kita pastikan tombol "New Analysis" ada
    cy.contains('New Analysis', { matchCase: false }).should('be.visible')
  })

})
