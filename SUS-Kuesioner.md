% Kuesioner Evaluasi Kegunaan Aplikasi — SUS

# Kuesioner: Seberapa Nyaman Kamu? — Evaluasi Kegunaan Aplikasi (SUS)

Formulir ini bertujuan mengukur seberapa mudah, nyaman, dan dapat diterimanya pengalaman menggunakan aplikasi X dari sudut pandang pengguna. Metode utama yang dipakai adalah System Usability Scale (SUS), sebuah skala 10-item yang ringkas namun terbukti andal untuk menilai kegunaan sistem.

Partisipasi bersifat sukarela dan anonim. Hanya isi jika kamu pernah menggunakan aplikasi X (mis. untuk mengikuti informasi, berinteraksi, atau kegiatan relevan lainnya). Perkiraan waktu pengisian: sekitar 3–7 menit.

Data yang dikumpulkan akan digunakan untuk kepentingan penelitian/peningkatan produk dan tidak akan dipublikasikan dengan identitas pribadi responden. Jika ingin menambahkan demografi singkat (usia, jenis kelamin, pengalaman teknis), gunakan bagian demografi di bawah.

## Instruksi singkat untuk responden
- Gunakan skala Likert 1–5: **1 = Sangat tidak setuju**, **5 = Sangat setuju**.
- Jawab setelah menggunakan sistem/fitur yang diuji.
- Tidak ada jawaban benar/salah — jawab sesuai pengalaman pribadi.

## Pertanyaan (10 item)
Jawablah setiap pernyataan dengan nilai 1–5.

1. Saya merasa nyaman menggunakan sistem ini.
2. Saya merasa sistem ini terlalu rumit.
3. Saya pikir orang akan cepat belajar menggunakan sistem ini.
4. Saya merasa perlu bantuan ahli untuk bisa menggunakan sistem ini.
5. Fungsi-fungsi dalam sistem ini terintegrasi dengan baik.
6. Sistem ini memiliki terlalu banyak inkonsistensi.
7. Mayoritas orang akan merasa percaya diri menggunakan sistem ini.
8. Saya merasa perlu mempelajari banyak hal sebelum bisa menggunakan sistem ini.
9. Saya merasa interaksi dengan sistem ini sederhana dan jelas.
10. Saya merasa elemen-elemen dalam sistem ini tidak konsisten.

Catatan: Item bernomor genap (2,4,6,8,10) diformulasikan negatif sesuai standar SUS.

## Cara menghitung skor SUS (langkah demi langkah)
1. Untuk item 1,3,5,7,9 (positif): skor_item = nilai_respon − 1.
2. Untuk item 2,4,6,8,10 (negatif): skor_item = 5 − nilai_respon.
3. Jumlahkan semua skor_item → total antara 0 sampai 40.
4. Kalikan total dengan 2.5 → skor SUS akhir antara 0 sampai 100.

### Contoh perhitungan
Misal jawaban responden: [3, 2, 4, 2, 4, 3, 5, 2, 4, 3]

- Item ganjil (1,3,5,7,9): (3−1) + (4−1) + (4−1) + (5−1) + (4−1) = 2 + 3 + 3 + 4 + 3 = 15
- Item genap (2,4,6,8,10): (5−2) + (5−2) + (5−3) + (5−2) + (5−3) = 3 + 3 + 2 + 3 + 2 = 13
- Total = 15 + 13 = 28
- Skor SUS = 28 × 2.5 = 70.0

## Interpretasi cepat
- Skor ≥ 80.3: Sangat baik (unggul).
- Skor 68–80.3: Baik.
- Skor ≈ 68: Ambang rata-rata.
- Skor < 68: Perlu perbaikan.

Catatan: Interpretasi punya nuansa — bandingkan dengan baseline produk sejenis atau studi literatur SUS untuk konteks.

## Tips pelaksanaan
- Berikan instruksi singkat sebelum pengisian (berapa lama penggunaan, tugas yang dikerjakan).
- Kumpulkan demografi dasar (usia, pengalaman teknis) untuk analisis segmentasi.
- Untuk analisis lebih mendalam, hitung mean dan standar deviasi skor SUS, dan gunakan uji statistik untuk perbandingan antar-kelompok.

## Formula cepat untuk Excel / Google Sheets
- Misal jawaban berada di sel A2:J2 (A=Q1 ... J=Q10):

```
=( (A2-1) + (5-B2) + (C2-1) + (5-D2) + (E2-1) + (5-F2) + (G2-1) + (5-H2) + (I2-1) + (5-J2) ) * 2.5
```

## Contoh teks pengantar (bisa dipakai di Google Form)
Terima kasih telah berpartisipasi. Anda diminta untuk menyelesaikan tugas singkat pada sistem X selama ~5 menit, lalu menjawab 10 pernyataan berikut menggunakan skala 1 (Sangat tidak setuju) sampai 5 (Sangat setuju). Jawaban Anda anonim dan akan digunakan untuk meningkatkan kegunaan sistem.

---

Jika mau, saya bisa membuat versi siap-salin untuk Google Forms, versi bahasa Inggris, atau menambahkan template analisis sederhana (CSV → perhitungan otomatis).
