<?php
// ============================================================
// config.php — Konfigurasi hosting (edit sesuai environment)
// ============================================================

// ---- Database ----
define('DB_HOST', 'localhost');        // biasanya 'localhost' di shared hosting
define('DB_USER', 'root');             // ganti dengan username DB di cPanel/hosting
define('DB_PASS', '');                 // ganti dengan password DB
define('DB_NAME', 'presentase');       // ganti dengan nama database (biasanya prefix_namadb)

// ---- Flask API ----
// Opsi A: Flask jalan di server yang sama (VPS/Render/Railway)
define('FLASK_URL', 'http://localhost:5000/predict');

// Opsi B: Flask di-deploy terpisah (mis. Render.com, Railway, Fly.io)
// define('FLASK_URL', 'https://nama-app-flask-anda.onrender.com/predict');

// ---- Timeout cURL ----
define('CURL_TIMEOUT', 15);
