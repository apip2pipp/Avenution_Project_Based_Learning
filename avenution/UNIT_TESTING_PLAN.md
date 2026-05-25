## Rencana Unit Testing — Avenution

Tujuan: menyediakan pedoman terstruktur untuk menulis, menjalankan, dan mendiagnosis unit test pada backend Laravel sehingga bila terjadi kegagalan kita tahu bagian mana yang harus dicek.

1. Ruang Lingkup
- Fokus: layanan inti (`app/Services`), model logic (`app/Models`), helper functions, dan unit-level utilities.
- Feature tests tetap berjalan di `tests/Feature` (sudah ada), tapi unit test harus cepat dan terisolasi.

2. Struktur dan Konvensi
- Lokasi: `tests/Unit/` untuk unit tests.
- Naming: `SomethingServiceTest.php`, metode `test_it_does_xxx()` atau `test_xxx_returns_expected()`.
- Setiap test harus mock dependency eksternal (HTTP, Socialite, filesystem, queue, dll.).

3. Prioritas Implementasi (awal)
- Very High: `RecommendationService`, `AnalysisProcessingService` core logic.
- High: `PendingAnalysisService`, `BodyAnalysisService` (kalkulasi BMI/daily needs).
- Medium: model helpers dan mutators di `User`, `Food`.

4. Pola Mocking
- Gunakan Mockery atau PHPUnit mocks untuk service dependencies.
- Mock chainable providers (Socialite) dengan `redirectUrl()->stateless()->user()` jika controller memanggilnya.
- Mock cache (`Cache::shouldReceive`) dan external APIs.

5. Data Test & Faker
- Gunakan model factories (`Database\Factories`) untuk membuat entitas minimal.
- Untuk unit test hindari `RefreshDatabase` yang heavy pada setiap test; gunakan hanya saat perlu akses DB.

6. Menghindari Flaky Tests
- Jangan panggil seeder besar dalam `setUp()`; seeders yang membaca CSV/gambar harus di-skip pada environment testing.
- Gunakan in-memory DB untuk unit tests bila DB diperlukan (`sqlite :memory:`).

7. Debugging dan Triage (ketika gagal)
- Langkah cepat:
  1) Jalankan test tunggal dengan verbosity: `php artisan test --filter NameOfTest --env=testing -v`
  2) Periksa `storage/logs/laravel.log` untuk stack trace.
  3) Cek apakah kegagalan disebabkan migration/seeder atau mocking.
- Mapping kegagalan ke area code:
  - Assertion gagal pada service logic -> buka `app/Services/...` terkait.
  - Null atau missing model -> periksa factory, migrasi, dan seeder yang mungkin men-destroy state.
  - Exception saat role/permission -> Spatie permissions perlu tabel `roles`/`model_has_roles`; pastikan migrasi berjalan.

8. CI / Automation
- Buat workflow CI yang menjalankan `composer install --prefer-dist --no-interaction`, `php artisan migrate --env=testing --force`, lalu `php artisan test --env=testing`.

9. Checklist ketika menambahkan test baru
- Tambah file test di `tests/Unit`.
- Pastikan semua dependency dimock.
- Jalankan test tunggal dan suite lokal.
- Push dan lihat CI.

10. Catatan khusus saat ini
- Hindari memanggil `DatabaseSeeder` yang mengimpor CSV besar saat environment `testing`.
- Socialite mocking: controller memakai `redirectUrl(...)` sebelum `stateless()` — mock chain ini.

11. Integrasi CI (GitHub Actions)
- Workflow ditambahkan: `.github/workflows/ci.yml` pada root repo.
- Apa yang dilakukan workflow:
  - Checkout repo
  - Setup PHP (8.1) dengan ekstensi `pdo_sqlite`
  - `composer install` di folder `avenution`
  - Siapkan `.env.testing` dan generate `APP_KEY`
  - `php artisan migrate --env=testing --force`
  - Jalankan `php artisan test --env=testing`

12. Cara reproduce dan hasil lokal saat ini
- Jalankan perintah berikut dari folder project root untuk menjalankan test di subfolder `avenution`:

```bash
cd avenution
php artisan test --env=testing
```

- Hasil lokal terakhir (saat penulisan): `48 passed, 1 risky, 2 skipped` di suite PHPUnit (total 149 assertions). Jika kamu melihat kegagalan terkait tabel/seeders, kemungkinan besar migration/seeders berat berjalan di environment testing — ikuti poin 6 untuk menghindari seeder besar dijalankan otomatis.

13. Next steps rekomendasi
- Tambah workflow CI untuk menjalankan Cypress E2E (opsional) — siapkan container atau setup headless browser.
- Tambah test unit prioritas dari daftar di poin 3.


---
Simpan file ini sebagai referensi saat menulis/men-debug unit tests.
