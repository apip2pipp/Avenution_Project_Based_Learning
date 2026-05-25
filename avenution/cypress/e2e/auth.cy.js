describe('Authentication Flow', () => {
  beforeEach(() => {
    // Jalankan perintah artisan migrate:fresh --seed jika perlu untuk memastikan DB bersih.
    // Untuk saat ini kita anggap database sudah memiliki user admin@avenution.com dan user@avenution.com (demo data).
  })

  it('bisa mengakses halaman login', () => {
    cy.visit('/login')
    cy.get('h1').contains('Welcome back').should('be.visible')
  })

  it('gagal login dengan password salah', () => {
    cy.visit('/login')
    cy.get('input[name="login"]').type('user@avenution.com')
    cy.get('input[name="password"]').type('passwordsalah123')
    cy.get('button[type="submit"]').click()
    
    // Asumsi ada pesan error yang muncul
    cy.get('.text-red-700').should('be.visible')
  })

  it('berhasil login dengan akun demo user', () => {
    cy.visit('/login')
    cy.get('input[name="login"]').type('user@avenution.com')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()
    
    // Pastikan diarahkan ke halaman analyze (HOME route di aplikasi ini adalah /analyze)
    cy.url().should('include', '/analyze')
    cy.contains('Body Condition Analysis', { matchCase: false }).should('be.visible')
  })

  it('berhasil logout', () => {
    // Login dulu
    cy.visit('/login')
    cy.get('input[name="login"]').type('user@avenution.com')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()

    // Klik tombol logout
    cy.contains('Logout').click({ force: true }) // menggunakan force: true jika tersembunyi di dropdown
    
    // Pastikan diarahkan kembali ke home atau login
    cy.url().should('include', '/')
  })
})
