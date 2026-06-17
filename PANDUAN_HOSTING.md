# 📋 Panduan Hosting Project 4 — Statistik Preferensi Bantal

Proyek ini terdiri dari **2 bagian** yang perlu di-deploy:
- **PHP Frontend** (index.php, dashboard.php) → di-host di shared hosting / VPS
- **Flask API** (flask-app/) → di-host di platform Python (Render/Railway/VPS)

---

## 🏗️ Arsitektur

```
Browser → PHP (shared hosting/VPS)
              ↓ HTTP POST
         Flask API (Render / Railway / VPS)
              ↓
         ML Models (.pkl)
```

---

## ✅ LANGKAH 1 — Deploy Flask API (Python)

### Opsi A: Render.com (Gratis, Direkomendasikan)

1. Buat akun di https://render.com
2. **New → Web Service → Connect GitHub** (upload folder `flask-app/`)
3. Isi settingan:
   - **Runtime**: Python 3
   - **Build Command**: `pip install -r requirements.txt`
   - **Start Command**: `gunicorn app:app --bind 0.0.0.0:$PORT`
4. Klik **Deploy**
5. Setelah selesai, catat URL-nya, contoh: `https://project4-flask.onrender.com`

### Opsi B: Railway.app

1. Buat akun di https://railway.app
2. **New Project → Deploy from GitHub**
3. Pilih folder `flask-app/`, Railway otomatis deteksi Python
4. Catat URL deployment-nya

### Opsi C: VPS (jika punya)
```bash
cd flask-app/
pip install -r requirements.txt
gunicorn app:app --bind 0.0.0.0:5000 --daemon
```

---

## ✅ LANGKAH 2 — Konfigurasi PHP

Edit file **`config.php`** sesuai environment hosting kamu:

```php
// Ganti sesuai hosting
define('DB_HOST', 'localhost');
define('DB_USER', 'namauser_db');    // dari cPanel
define('DB_PASS', 'passworddb');     // dari cPanel
define('DB_NAME', 'namaprefix_presentase');  // dari cPanel

// URL Flask API yang sudah di-deploy (LANGKAH 1)
define('FLASK_URL', 'https://project4-flask.onrender.com/predict');
```

---

## ✅ LANGKAH 3 — Upload PHP ke Shared Hosting (cPanel)

1. Login ke **cPanel** hosting kamu
2. Buka **phpMyAdmin**:
   - Buat database baru, misal `userku_presentase`
   - Import file `presentase.sql`
3. Buka **File Manager → public_html**
4. Upload file-file berikut:
   ```
   index.php
   dashboard.php
   logout.php
   config.php      ← WAJIB
   ```
5. Edit `config.php` via File Manager (klik kanan → Edit)

---

## ✅ LANGKAH 4 — Test

1. Buka URL hosting kamu di browser
2. Isi form prediksi → klik Simpan
3. Cek hasilnya tampil dengan benar
4. Login admin: username `admin`, password `12345`

---

## 🔐 Keamanan (Penting Sebelum Production)

- [ ] Ganti password admin dari `12345` ke password kuat (edit di phpMyAdmin, tabel `user`)
- [ ] Tambahkan `password_hash()` untuk login (saat ini plain text)
- [ ] Simpan `config.php` di luar `public_html` jika memungkinkan

---

## 🛠️ Troubleshooting

| Masalah | Solusi |
|---------|--------|
| "Gagal koneksi Flask API" | Pastikan FLASK_URL di config.php sudah benar dan Flask sudah running |
| "Koneksi database gagal" | Cek DB_HOST, DB_USER, DB_PASS, DB_NAME di config.php |
| Flask tidak merespons (Render) | Free tier Render "tidur" setelah 15 menit, tunggu ~30 detik pertama |
| Error 500 di PHP | Aktifkan error display: tambah `ini_set('display_errors',1);` di awal index.php |

