# Avenution - Food Recommendation System

## Deskripsi Project
Avenution adalah aplikasi web berbasis Laravel 11 untuk rekomendasi makanan berdasarkan kondisi tubuh menggunakan metode Naive Bayes. Aplikasi ini menganalisis kondisi kesehatan pengguna (BMI, tekanan darah, gula darah, kolesterol) dan memberikan rekomendasi makanan yang sesuai.

## Fitur Utama

### 1. **Guest Features** (Tanpa Login)
- Landing page dengan statistik
- Analisis kondisi tubuh (11 parameter kesehatan)
- Hasil rekomendasi makanan dengan match score (0-100%)
- Tracking hasil via session ID

### 2. **User Features** (Login Required)
- Dashboard dengan ringkasan analisis
- History analisis lengkap dengan pagination
- BMI tracking dan kategori tubuh
- Rekomendasi makanan personal

### 3. **Admin Features** (Admin Only)
- Dashboard analytics (total users, analyses, foods)
- CRUD lengkap untuk data makanan
- Monitor aktivitas user
- Manage nutritional information

## Tech Stack
- **Backend**: Laravel 11
- **Auth**: Laravel Breeze (Blade Stack)
- **RBAC**: Spatie Laravel Permission v6.24.1
- **Frontend**: Blade + Tailwind CSS v3 + Alpine.js v3
- **Database**: MySQL (Laragon)
- **Design System**: Primary #C62828, Accent #16A34A, Font: Poppins

## Struktur Database

### Tables:
1. **users** - Extended dengan age, gender, height, weight, phone
2. **foods** - 16 makanan dengan nutrition lengkap, dietary_tags (JSON), health_benefits (JSON)
3. **analyses** - Menyimpan hasil analisis (user_id nullable, session_id unique untuk guest)
4. **recommendations** - Junction table (analysis_id, food_id, match_score, timing)

## Login Credentials

### Admin Account
```
Email: admin@avenution.com
Password: password
```

### Regular User Account
```
Email: user@avenution.com
Password: password
```

## Cara Menjalankan

### 1. Pastikan Database Sudah Dibuat
Database sudah dibuat dengan nama `avenution`. Jika perlu membuat ulang:
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS avenution CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 2. Jalankan Migrations dan Seeders
```bash
cd avenution
php artisan migrate:fresh --seed
```

### 3. Build Assets (Production)
```bash
npm run build
```

### 4. Start Development Server
```bash
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

### 5. (Optional) Compile Assets untuk Development
Jika ingin watch mode untuk development:
```bash
npm run dev
```

## Alur Penggunaan

### Guest User Flow:
1. Kunjungi **http://localhost:8000**
2. Klik "Try Free Analysis" di hero section
3. Isi form analisis dengan data:
   - Personal Info: Usia, Tinggi, Berat, Gender
   - Health Metrics: Blood Pressure, Blood Sugar, Cholesterol, Activity Level
   - Lifestyle: Dietary Restrictions, Health Goals
4. Klik "Analyze My Body Condition"
5. Lihat hasil: BMI, kategori tubuh, health warnings, 4-6 rekomendasi makanan dengan match score
6. (Optional) Register untuk save history

### User Flow:
1. Login dengan `user@avenution.com / password`
2. Dashboard menampilkan:
   - Total analyses
   - Average BMI
   - Current category
   - Latest analysis
3. Do New Analysis → Hasil tersimpan dengan user_id
4. View Full History → Paginated table dengan semua analisis
5. Klik "View Report" untuk detail rekomendasi

### Admin Flow:
1. Login dengan `admin@avenution.com / password`
2. Admin Dashboard menampilkan:
   - Total Users: 2 (admin + user)
   - Total Analyses: (tergantung usage)
   - Total Foods: 16
   - Recent Analyses table
3. Klik "Manage Foods" → CRUD interface
4. "Add New Food" → Form lengkap dengan:
   - Basic Info: Name, Category (breakfast/lunch/dinner/snack), Emoji, Image URL
   - Nutrition: Calories, Protein, Carbs, Fat, Fiber
   - Tags: Dietary Tags (comma-separated), Health Benefits (comma-separated)
5. Edit/Delete existing foods

## Algoritma Naive Bayes Scoring

### Base Score: 75
Adjustments berdasarkan kondisi:

1. **BMI Category Matching** (+10 poin)
   - Underweight → High-calorie foods
   - Overweight/Obese → Low-calorie, high-fiber foods
   - Normal → Balanced foods

2. **Blood Pressure** (+10 poin)
   - Jika BP ≥ 130/80 → Prioritas low-sodium foods

3. **Blood Sugar** (+10 poin)
   - Jika sugar ≥ 100 → Prioritas high-fiber, low-sugar foods

4. **Cholesterol** (+10 poin)
   - Jika cholesterol ≥ 200 → Prioritas omega-3, heart-healthy foods

5. **Dietary Restrictions** (+15/-30 poin)
   - Match → +15
   - Conflict → -30 (eliminasi)

6. **Health Goals** (+15 poin)
   - Weight loss → Low-calorie
   - Muscle gain → High-protein
   - Maintain health → Balanced nutrition

7. **Activity Level** (+5 poin)
   - Active/Very active → Higher calorie needs

### Threshold:
- Foods dengan score ≥ 70% masuk rekomendasi
- Top 4-6 foods per timing (morning/afternoon/evening/snack)

## File Structure Penting

```
avenution/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── AnalyzeController.php  ← Form & processing
│   │   │   ├── ResultController.php   ← Display hasil
│   │   │   ├── DashboardController.php
│   │   │   ├── HistoryController.php
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       └── FoodController.php  ← CRUD foods
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   │   └── Requests/
│   │       ├── AnalyzeRequest.php     ← Validation rules
│   │       ├── StoreFoodRequest.php
│   │       └── UpdateFoodRequest.php
│   ├── Models/
│   │   ├── User.php (HasRoles)
│   │   ├── Food.php
│   │   ├── Analysis.php
│   │   └── Recommendation.php
│   └── Services/
│       ├── BodyAnalysisService.php     ← BMI calculation, health warnings
│       └── RecommendationService.php   ← Naive Bayes scoring
├── database/
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2024_03_03_160000_create_foods_table.php
│   │   ├── 2024_03_03_161000_create_analyses_table.php
│   │   └── 2024_03_03_162000_create_recommendations_table.php
│   └── seeders/
│       ├── RoleSeeder.php
│       ├── AdminSeeder.php
│       └── FoodSeeder.php  ← 16 foods
├── resources/
│   ├── css/
│   │   ├── app.css
│   │   └── theme.css  ← CSS variables untuk light/dark mode
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php      ← Auth layout
│       │   └── guest.blade.php    ← Public layout
│       ├── components/
│       │   ├── navbar.blade.php   ← Dark mode toggle
│       │   └── footer.blade.php
│       ├── landing.blade.php      ← Hero + features
│       ├── analyze.blade.php      ← 11-input form
│       ├── result.blade.php       ← BMI + recommendations
│       ├── dashboard.blade.php    ← User dashboard
│       ├── history.blade.php      ← Paginated table
│       └── admin/
│           ├── dashboard.blade.php
│           └── foods/
│               ├── index.blade.php   ← Table with pagination
│               ├── create.blade.php  ← Add form
│               └── edit.blade.php    ← Edit/delete form
└── routes/
    └── web.php  ← Public + Auth + Admin grouping
```

## Design System

### Colors:
- **Primary**: #C62828 (Red dari design reference)
- **Accent**: #16A34A (Green)
- **Background Light**: #FFFFFF
- **Background Dark**: #1F2937

### Typography:
- **Font**: Poppins (Google Fonts)
- **Weights**: 300, 400, 500, 600, 700, 800

### Dark Mode:
- Toggle di navbar (Alpine.js)
- Persistent via localStorage
- CSS variables di `theme.css`

## Sample Foods (Seeder)

### Breakfast (4):
1. 🥣 Oatmeal with Berries - 320 cal
2. 🥛 Greek Yogurt Parfait - 220 cal
3. 🥑 Avocado Toast - 380 cal
4. 🍌 Banana Smoothie - 290 cal

### Lunch (4):
5. 🐟 Grilled Salmon & Quinoa - 480 cal
6. 🍗 Mediterranean Chicken - 420 cal
7. 🍚 Brown Rice Veggie Bowl - 360 cal
8. 🌯 Turkey Wrap - 340 cal

### Dinner (4):
9. 🥘 Vegetable Stir-fry with Tofu - 380 cal
10. 🍗 Grilled Chicken - 310 cal
11. 🍛 Lentil Curry - 350 cal
12. 🐟 Baked Cod - 290 cal

### Snacks (4):
13. 🥜 Mixed Nuts - 180 cal
14. 🍎 Apple Almond Butter - 200 cal
15. 🥕 Carrot Hummus - 120 cal
16. 🥤 Green Smoothie - 150 cal

## Troubleshooting

### Database Connection Error:
```bash
# Check .env file
DB_CONNECTION=mysql
DB_DATABASE=avenution
DB_USERNAME=root
DB_PASSWORD=

# Recreate database
mysql -u root -e "DROP DATABASE IF EXISTS avenution; CREATE DATABASE avenution CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Migration Error:
```bash
# Fresh start
php artisan migrate:fresh --seed
```

### Asset Not Loading:
```bash
# Rebuild assets
npm run build

# Or untuk development
npm run dev
```

### Permission Error:
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Testing Checklist

- [ ] Landing page loads dengan stats
- [ ] Analyze form submit (guest)
- [ ] Result page displays BMI + recommendations
- [ ] Register new user
- [ ] Login as user
- [ ] Submit analysis (logged in)
- [ ] Dashboard shows total analyses
- [ ] History shows paginated table
- [ ] Login as admin
- [ ] Admin dashboard shows stats
- [ ] Create new food
- [ ] Edit existing food
- [ ] Delete food (confirmation)
- [ ] Dark mode toggle persists
- [ ] Mobile responsive (navbar hamburger, responsive grids)

## Kredensial & Info Penting

**Database**: avenution (MySQL via Laragon)
**Server**: http://localhost:8000
**Admin**: admin@avenution.com / password
**User**: user@avenution.com / password

## Next Steps (Optional Enhancements)

1. **Email Verification**: Uncomment middleware di routes/web.php
2. **Profile Page**: Update user biometrics (age, height, weight)
3. **Export to PDF**: Generate PDF report dari hasil analisis
4. **Charts**: Visualisasi BMI history dengan Chart.js
5. **Notifications**: Flash messages dengan Toastr atau SweetAlert2
6. **Food Images**: Upload image files (sekarang hanya URL)
7. **API**: REST API untuk mobile app integration
8. **Testing**: PHPUnit tests untuk Services dan Controllers

## Support

Jika ada error, check:
1. `.env` database config
2. `php artisan migrate:fresh --seed`
3. `npm run build`
4. Server running di port 8000
5. Laragon MySQL service aktif

---

**Dibuat dengan ❤️ menggunakan Laravel 11 + Breeze + Spatie Permissions**
