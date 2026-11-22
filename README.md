# Perpustakaan Digital - UTS Big Data

**Nama:** Neneng Wahyuni  
**NPM:** 24430123  
**Program Studi:** S1 Ilmu Komputer  
**Universitas:** Universitas Muhammadiyah Metro  
**Mata Kuliah:** Big Data (Ujian Tengah Semester)  

---

## 📖 Deskripsi Proyek
Aplikasi Web Perpustakaan Digital yang menampilkan dashboard analitik koleksi buku, relasi kategori buku (`INNER JOIN`), filter tahun terbit terbaru (> 2020), dan filter penerbit (UM Metro Press).

Aplikasi ini telah dioptimalkan dan siap di-hosting langsung ke **Vercel** dengan konfigurasi `vercel.json` dan performa tinggi (100% responsif, dark/light theme, live clock WIB, interactive particle mesh canvas, count-up KPI, donut charts, table column sorting, dan live search modal).

---

## 🚀 Fitur Utama
1. **Dashboard Home**: KPI metrik, visualisasi donut chart distribusi kategori, progress bar penerbit, dan tabel preview buku.
2. **Data Buku Lengkap**: Tabel relasi `tb_perpus` dengan `tb_kategori_buku` menggunakan SQL `INNER JOIN`, dilengkapi sorting kolom interaktif dan modal detail buku.
3. **Filter Buku "Terbaru"**: Query seleksi buku dengan `tahun_terbit > 2020`.
4. **Filter Penerbit "UM Metro Press"**: Agregasi `COUNT(*)` dan katalog buku dari penerbit UM Metro Press.
5. **About Pembuat**: Kartu profil 3D tilt dengan identitas penyusun.
6. **SQL Database Inspector**: Salin query SQL langsung dari antarmuka web.
7. **Database Export**: File `myperpus.sql` tersedia langsung di dalam repositori.

---

## 🛠️ Struktur Berkas
- `index.html` / `index.php`: Dashboard utama
- `viewbuku.html` / `viewbuku.php`: Katalog semua data buku
- `viewfilterbukuterbaru.html` / `viewfilterbukuterbaru.php`: Filter buku terbitan > 2020
- `viewfilterbukuummetropress.html` / `viewfilterbukuummetropress.php`: Filter penerbit UM Metro Press
- `me.html` / `me.php`: Halaman profil penyusun
- `myperpus.sql`: Salinan dump database MySQL/MariaDB
- `style.css`: Modern glassmorphism UI & responsive styles
- `profil.jpeg`: Foto profil penyusun
- `vercel.json`: Konfigurasi routing Vercel
