# Panduan singkat menjalankan test (lokal)

Persiapan singkat:

- Pastikan dependencies terpasang:

```powershell
cd avenution
composer install --no-interaction --prefer-dist
npm ci
```

- Pastikan `pdo_sqlite` aktif di PHP (Windows): edit `php.ini` dan pastikan baris `extension=pdo_sqlite` tidak dikomentari, lalu restart PHP/Dev server.

Menjalankan PHPUnit (Laravel):

```powershell
cd avenution
php artisan migrate --env=testing --force
php artisan test --env=testing
# atau: ./vendor/bin/phpunit
```

Catatan: file `.env.testing` disertakan untuk mengarahkan aplikasi ke SQLite in-memory.

Menjalankan Cypress (E2E):

- Jalankan aplikasi (di terminal terpisah):

```powershell
cd avenution
php artisan serve --port=8000
```

- Buka runner Cypress atau jalankan headless:

```powershell
npm run cypress:open   # interaktif
npm run cypress:run    # headless
```

Tips troubleshooting:

- Jika PHPUnit melaporkan error `could not find driver` pastikan `pdo_sqlite` aktif.
- Jika Cypress gagal terhubung, pastikan `APP_URL` dan `avenution/cypress.config.js` `baseUrl` cocok (default http://localhost:8000).
