<?php
session_start();

/* ============================
   PROTEKSI LOGIN ADMIN
============================ */
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
 
/* ============================
   KONEKSI DATABASE
============================ */
$conn = mysqli_connect("localhost", "root", "", "presentase");
if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());

/* ============================
   QUERY STATISTIK
============================ */
$total = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM data_preferensi"));

$premium = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM data_preferensi WHERE kesimpulan='Menyukai Produk Premium'"));

$nonpremium = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM data_preferensi WHERE kesimpulan='Tidak Menyukai Produk Premium'"));

$avgusia = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT AVG(usia) AS rata FROM data_preferensi"));

$model = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT
        SUM(random_forest=1)      AS rf,
        SUM(gradient_boosting=1)  AS gb,
        SUM(naive_bayes=1)        AS nb,
        SUM(kmeans_cluster=1)     AS km
     FROM data_preferensi"));

$pct_premium = ($total['total'] > 0)
    ? round($premium['total'] / $total['total'] * 100)
    : 0;

$username = $_SESSION['username'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard — Pillow Analytics</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

:root {
  --navy:        #0F2044;
  --navy-mid:    #1A3263;
  --navy-light:  #233D6E;
  --blue:        #1D4ED8;
  --blue-light:  #3B82F6;
  --slate:       #475569;
  --slate-light: #94A3B8;
  --bg:          #F1F5F9;
  --surface:     #FFFFFF;
  --border:      #E2E8F0;
  --text:        #0F172A;
  --text-muted:  #64748B;
  --green:       #16A34A;
  --green-bg:    #F0FDF4;
  --red:         #DC2626;
  --red-bg:      #FEF2F2;
  --amber:       #D97706;
  --amber-bg:    #FFFBEB;
  --sidebar-w:   240px;
}

body {
  font-family: 'Inter', sans-serif;
  background: var(--bg);
  color: var(--text);
  font-size: 14px;
  line-height: 1.6;
}

/* ====== SIDEBAR ====== */
.sidebar {
  position: fixed;
  left: 0; top: 0; bottom: 0;
  width: var(--sidebar-w);
  background: var(--navy);
  display: flex;
  flex-direction: column;
  z-index: 200;
}
.sidebar-top {
  padding: 24px 20px 20px;
  border-bottom: 1px solid rgba(255,255,255,.08);
}
.sidebar-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 4px;
}
.brand-icon {
  width: 32px; height: 32px;
  background: var(--blue);
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  color: white;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 800; font-size: 13px;
  letter-spacing: -.5px;
  flex-shrink: 0;
}
.brand-name {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700; font-size: 15px;
  color: white; letter-spacing: -.3px;
}
.brand-name span { color: #93C5FD; }
.sidebar-badge {
  font-size: 10px; font-weight: 600;
  background: rgba(255,255,255,.1);
  color: #93C5FD;
  padding: 2px 8px; border-radius: 20px;
  margin-left: 42px;
  display: inline-block;
}

.sidebar-nav {
  flex: 1;
  padding: 16px 12px;
  overflow-y: auto;
}
.nav-section-label {
  font-size: 10px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .8px;
  color: rgba(255,255,255,.3);
  padding: 0 8px;
  margin: 16px 0 6px;
}
.nav-section-label:first-child { margin-top: 4px; }
.nav-link {
  display: flex;
  align-items: center;
  gap: 10px;
  color: rgba(255,255,255,.6);
  text-decoration: none;
  padding: 9px 10px;
  border-radius: 8px;
  font-size: 13.5px;
  font-weight: 500;
  transition: all .18s;
  margin-bottom: 2px;
}
.nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }
.nav-link:hover, .nav-link.active {
  background: rgba(255,255,255,.08);
  color: white;
}
.nav-link.active { background: var(--blue); color: white; }

.sidebar-footer {
  padding: 16px 12px;
  border-top: 1px solid rgba(255,255,255,.08);
}
.user-row {
  display: flex; align-items: center; gap: 10px;
  padding: 10px;
  border-radius: 8px;
  background: rgba(255,255,255,.05);
  margin-bottom: 10px;
}
.user-avatar {
  width: 30px; height: 30px;
  background: var(--blue);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 12px; font-weight: 700; color: white;
  flex-shrink: 0;
  text-transform: uppercase;
}
.user-info { min-width: 0; }
.user-name {
  font-size: 12.5px; font-weight: 600; color: white;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.user-role { font-size: 11px; color: rgba(255,255,255,.4); }
.logout-btn {
  display: flex; align-items: center; gap: 8px;
  width: 100%;
  background: transparent;
  border: 1px solid rgba(255,255,255,.12);
  color: rgba(255,255,255,.5);
  padding: 8px 10px;
  border-radius: 8px;
  font-size: 13px; font-weight: 500;
  cursor: pointer; text-decoration: none;
  transition: all .18s;
  font-family: 'Inter', sans-serif;
}
.logout-btn svg { width: 14px; height: 14px; }
.logout-btn:hover {
  background: rgba(220,38,38,.15);
  border-color: rgba(220,38,38,.3);
  color: #FCA5A5;
}

/* ====== MAIN ====== */
.main {
  margin-left: var(--sidebar-w);
  min-height: 100vh;
  display: flex; flex-direction: column;
}

/* ====== TOPBAR ====== */
.topbar {
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  height: 56px;
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 28px;
  position: sticky; top: 0; z-index: 100;
  box-shadow: 0 1px 3px rgba(0,0,0,.05);
}
.topbar-title {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 15px; font-weight: 700; color: var(--navy);
}
.topbar-right {
  display: flex; align-items: center; gap: 12px;
}
.topbar-date {
  font-size: 12px; color: var(--text-muted); font-weight: 500;
}
.topbar-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--green);
  box-shadow: 0 0 0 2px rgba(22,163,74,.2);
}

/* ====== PAGE CONTENT ====== */
.page-content {
  flex: 1;
  padding: 28px;
}
.page-header { margin-bottom: 24px; }
.page-title {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 22px; font-weight: 800; color: var(--navy);
  letter-spacing: -.4px; margin-bottom: 4px;
}
.page-subtitle { font-size: 13px; color: var(--text-muted); }

/* ====== STAT CARDS ====== */
.stat-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}
.stat-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 18px 20px;
  box-shadow: 0 1px 3px rgba(0,0,0,.04);
  position: relative;
  overflow: hidden;
}
.stat-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
}
.sc-blue::before   { background: var(--blue); }
.sc-green::before  { background: var(--green); }
.sc-red::before    { background: var(--red); }
.sc-amber::before  { background: var(--amber); }

.stat-top {
  display: flex; align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 12px;
}
.stat-label {
  font-size: 11.5px; font-weight: 600;
  color: var(--text-muted);
  text-transform: uppercase; letter-spacing: .5px;
}
.stat-icon {
  width: 34px; height: 34px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: 16px;
}
.si-blue   { background: #EFF6FF; }
.si-green  { background: #F0FDF4; }
.si-red    { background: #FEF2F2; }
.si-amber  { background: #FFFBEB; }

.stat-value {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 28px; font-weight: 800; color: var(--navy);
  line-height: 1; margin-bottom: 6px;
  letter-spacing: -1px;
}
.stat-sub {
  font-size: 11.5px; color: var(--text-muted); font-weight: 500;
}

/* ====== SECTION HEADERS ====== */
.section-head {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 16px;
}
.section-title {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 15px; font-weight: 700; color: var(--navy);
}
.section-sub { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

/* ====== CARDS ====== */
.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0,0,0,.04);
  overflow: hidden;
}
.card-body { padding: 22px; }
.card-header-bar {
  padding: 14px 20px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
  background: #FAFBFC;
}
.card-header-title {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 13.5px; font-weight: 700; color: var(--navy);
}
.card-header-sub { font-size: 11.5px; color: var(--text-muted); }

/* ====== CHARTS ROW ====== */
.charts-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 24px;
}
.chart-wrap {
  position: relative;
  height: 240px;
  display: flex; align-items: center; justify-content: center;
}

/* ====== MODEL PERFORMANCE ====== */
.model-perf-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
  margin-bottom: 24px;
}
.model-perf-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 14px 16px;
  text-align: center;
}
.model-emoji { font-size: 22px; margin-bottom: 6px; }
.model-name {
  font-size: 11px; font-weight: 600;
  color: var(--text-muted); text-transform: uppercase;
  letter-spacing: .4px; margin-bottom: 8px;
}
.model-val {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 22px; font-weight: 800; color: var(--navy);
  letter-spacing: -.5px;
}
.model-desc { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

/* ====== TABLE ====== */
.table-wrap { overflow-x: auto; }
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}
thead tr {
  background: var(--navy);
  color: white;
}
thead th {
  padding: 11px 14px;
  font-size: 11px; font-weight: 600;
  text-transform: uppercase; letter-spacing: .5px;
  white-space: nowrap; text-align: left;
}
tbody tr {
  border-bottom: 1px solid var(--border);
  transition: background .12s;
}
tbody tr:hover { background: #F8FAFC; }
tbody tr:last-child { border-bottom: none; }
td {
  padding: 10px 14px;
  color: var(--text);
  vertical-align: middle;
}
.td-id { color: var(--text-muted); font-weight: 600; }
.td-name { font-weight: 600; }
.badge-pill {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: 11px; font-weight: 600;
  padding: 3px 9px; border-radius: 20px;
  white-space: nowrap;
}
.badge-pos { background: var(--green-bg); color: var(--green); }
.badge-neg { background: var(--red-bg);   color: var(--red); }
.badge-neutral { background: var(--bg); color: var(--text-muted); }
.dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
.dot-pos { background: var(--green); }
.dot-neg { background: var(--red); }

/* ====== EMPTY STATE ====== */
.empty-state {
  text-align: center; padding: 48px 24px; color: var(--text-muted);
}
.empty-icon { font-size: 32px; margin-bottom: 12px; }
.empty-title { font-size: 14px; font-weight: 600; color: var(--slate); margin-bottom: 4px; }

/* ====== FOOTER ====== */
.page-footer {
  padding: 16px 28px;
  border-top: 1px solid var(--border);
  background: var(--surface);
  text-align: center;
}
.page-footer small { font-size: 12px; color: var(--text-muted); }
</style>
</head>
<body>

<!-- ====== SIDEBAR ====== -->
<aside class="sidebar">
  <div class="sidebar-top">
    <div class="sidebar-brand">
      <div class="brand-icon">PA</div>
      <div class="brand-name">Pillow<span>Analytics</span></div>
    </div>
    <span class="sidebar-badge">Admin Panel</span>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section-label">Menu Utama</div>
    <a href="#top" class="nav-link active">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
        <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
      </svg>
      Dashboard
    </a>
    <a href="#model-section" class="nav-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
      </svg>
      Statistik Model
    </a>
    <a href="#data-section" class="nav-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      Data Konsumen
    </a>

    <div class="nav-section-label">Sistem</div>
    <a href="index.php" class="nav-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
      Kembali ke Beranda
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="user-row">
      <div class="user-avatar"><?= strtoupper(substr($username, 0, 1)) ?></div>
      <div class="user-info">
        <div class="user-name"><?= htmlspecialchars($username) ?></div>
        <div class="user-role">Administrator</div>
      </div>
    </div>
    <a href="logout.php" class="logout-btn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
        <polyline points="16 17 21 12 16 7"/>
        <line x1="21" y1="12" x2="9" y2="12"/>
      </svg>
      Logout
    </a>
  </div>
</aside>

<!-- ====== MAIN ====== -->
<div class="main" id="top">

  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-title">Administrator Dashboard</div>
    <div class="topbar-right">
      <div class="topbar-date"><?= date('l, d F Y') ?></div>
      <div class="topbar-dot" title="Sistem aktif"></div>
    </div>
  </div>

  <!-- PAGE CONTENT -->
  <div class="page-content">

    <div class="page-header">
      <h1 class="page-title">Ringkasan Data & Analisis</h1>
      <p class="page-subtitle">Statistik keseluruhan hasil prediksi preferensi konsumen produk bantal premium.</p>
    </div>

    <!-- STAT CARDS -->
    <div class="stat-grid">
      <div class="stat-card sc-blue">
        <div class="stat-top">
          <div class="stat-label">Total Konsumen</div>
          <div class="stat-icon si-blue">👥</div>
        </div>
        <div class="stat-value"><?= $total['total'] ?></div>
        <div class="stat-sub">Data tersimpan di database</div>
      </div>
      <div class="stat-card sc-green">
        <div class="stat-top">
          <div class="stat-label">Menyukai Premium</div>
          <div class="stat-icon si-green">⭐</div>
        </div>
        <div class="stat-value"><?= $premium['total'] ?></div>
        <div class="stat-sub"><?= $pct_premium ?>% dari total konsumen</div>
      </div>
      <div class="stat-card sc-red">
        <div class="stat-top">
          <div class="stat-label">Menyukai kenyamanan</div>
          <div class="stat-icon si-red">❌</div>
        </div>
        <div class="stat-value"><?= $nonpremium['total'] ?></div>
        <div class="stat-sub"><?= 100 - $pct_premium ?>% dari total konsumen</div>
      </div>
      <div class="stat-card sc-amber">
        <div class="stat-top">
          <div class="stat-label">Rata-rata Usia</div>
          <div class="stat-icon si-amber">📅</div>
        </div>
        <div class="stat-value"><?= round($avgusia['rata']) ?></div>
        <div class="stat-sub">Tahun usia konsumen</div>
      </div>
    </div>

    <!-- CHARTS -->
    <div id="model-section" class="charts-grid">
      <!-- PIE -->
      <div class="card">
        <div class="card-header-bar">
          <div>
            <div class="card-header-title">Distribusi Preferensi</div>
            <div class="card-header-sub">Proporsi konsumen premium vs non-premium</div>
          </div>
        </div>
        <div class="card-body">
          <div class="chart-wrap">
            <canvas id="pieChart"></canvas>
          </div>
        </div>
      </div>

      <!-- BAR -->
      <div class="card">
        <div class="card-header-bar">
          <div>
            <div class="card-header-title">Prediksi Positif per Model</div>
            <div class="card-header-sub">Jumlah konsumen diprediksi menyukai premium</div>
          </div>
        </div>
        <div class="card-body">
          <div class="chart-wrap">
            <canvas id="barChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- MODEL PERFORMANCE CARDS -->
    <div class="section-head">
      <div>
        <div class="section-title">Performa Model Machine Learning</div>
        <div class="section-sub">Jumlah prediksi positif (suka premium) dari masing-masing model</div>
      </div>
    </div>
    <div class="model-perf-grid">
      <div class="model-perf-card">
        <div class="model-emoji">🌲</div>
        <div class="model-name">Random Forest</div>
        <div class="model-val"><?= $model['rf'] ?? 0 ?></div>
        <div class="model-desc">prediksi positif</div>
      </div>
      <div class="model-perf-card">
        <div class="model-emoji">⚡</div>
        <div class="model-name">Gradient Boosting</div>
        <div class="model-val"><?= $model['gb'] ?? 0 ?></div>
        <div class="model-desc">prediksi positif</div>
      </div>
      <div class="model-perf-card">
        <div class="model-emoji">📐</div>
        <div class="model-name">Naive Bayes</div>
        <div class="model-val"><?= $model['nb'] ?? 0 ?></div>
        <div class="model-desc">prediksi positif</div>
      </div>
      <div class="model-perf-card">
        <div class="model-emoji">🔵</div>
        <div class="model-name">K-Means Cluster</div>
        <div class="model-val"><?= $model['km'] ?? 0 ?></div>
        <div class="model-desc">cluster premium</div>
      </div>
    </div>

    <!-- DATA TABLE -->
    <div id="data-section" class="section-head">
      <div>
        <div class="section-title">Seluruh Data Konsumen</div>
        <div class="section-sub">Riwayat lengkap hasil analisis preferensi</div>
      </div>
    </div>
    <div class="card">
      <div class="card-header-bar">
        <div class="card-header-title">Tabel Data Preferensi</div>
        <div class="card-header-sub">Total <?= $total['total'] ?> record</div>
      </div>
      <div class="table-wrap">
        <?php
        $data = mysqli_query($conn, "SELECT * FROM data_preferensi ORDER BY id DESC");
        if (mysqli_num_rows($data) > 0):
        ?>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Product</th>
              <th>Jenis Kelamis</th>
              <th>Usia</th>
              <th>Harga</th>
              <th>Desain</th>
              <th>Kenyamanan</th>
              <th>Durasi Tidur</th>
              <th>Random Forest</th>
              <th>Grad. Boosting</th>
              <th>Naive Bayes</th>
              <th>K-Means</th>
              <th>Kesimpulan</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($row = mysqli_fetch_assoc($data)): ?>
          <?php
            $is_premium = ($row['kesimpulan'] === 'Menyukai Produk Premium');
            $rf_pos  = ((int)$row['random_forest'] === 1);
            $gb_pos  = ((int)$row['gradient_boosting'] === 1);
            $nb_pos  = ((int)$row['naive_bayes'] === 1);
            $km_pos  = ((int)$row['kmeans_cluster'] === 1);
          ?>
          <tr>
            <td class="td-id">#<?= $row['id'] ?></td>
            <td class="td-name"><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= $row['jenis_kelamin'] === 'L' ? '♂ L' : '♀ P' ?></td>
            <td><?= $row['usia'] ?></td>
            <td><?= $row['harga'] ?>/5</td>
            <td><?= $row['desain'] ?>/5</td>
            <td><?= $row['kenyamanan'] ?>/5</td>
            <td><?= $row['durasi_tidur'] ?>j</td>
            <td>
              <span class="badge-pill <?= $rf_pos ? 'badge-pos' : 'badge-neg' ?>">
                <span class="dot <?= $rf_pos ? 'dot-pos' : 'dot-neg' ?>"></span>
                <?= $rf_pos ? 'Premium' : 'Tidak' ?>
              </span>
            </td>
            <td>
              <span class="badge-pill <?= $gb_pos ? 'badge-pos' : 'badge-neg' ?>">
                <span class="dot <?= $gb_pos ? 'dot-pos' : 'dot-neg' ?>"></span>
                <?= $gb_pos ? 'Premium' : 'Tidak' ?>
              </span>
            </td>
            <td>
              <span class="badge-pill <?= $nb_pos ? 'badge-pos' : 'badge-neg' ?>">
                <span class="dot <?= $nb_pos ? 'dot-pos' : 'dot-neg' ?>"></span>
                <?= $nb_pos ? 'Premium' : 'Tidak' ?>
              </span>
            </td>
            <td>
              <span class="badge-pill <?= $km_pos ? 'badge-pos' : 'badge-neg' ?>">
                <span class="dot <?= $km_pos ? 'dot-pos' : 'dot-neg' ?>"></span>
                <?= $km_pos ? 'Premium' : 'Non-Prem' ?>
              </span>
            </td>
            <td>
              <span class="badge-pill <?= $is_premium ? 'badge-pos' : 'badge-neg' ?>" style="font-size:11.5px;">
                <?= $is_premium ? ' Menyukai Premium' : ' menyukai kenyamanan' ?>
              </span>
            </td>
          </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
          <div class="empty-icon">📭</div>
          <div class="empty-title">Belum ada data konsumen</div>
          <div style="font-size:13px;">Data akan muncul di sini setelah analisis dijalankan dari halaman utama.</div>
        </div>
        <?php endif; ?>
      </div>
    </div>

  </div><!-- /page-content -->

  <div class="page-footer">
    <small>Pillow Analytics AI System &copy; <?= date('Y') ?> &nbsp;·&nbsp; Logged in as <strong><?= htmlspecialchars($username) ?></strong></small>
  </div>

</div><!-- /main -->

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const premiumCount    = <?= (int)$premium['total'] ?>;
const nonPremiumCount = <?= (int)$nonpremium['total'] ?>;
const rfCount  = <?= (int)($model['rf'] ?? 0) ?>;
const gbCount  = <?= (int)($model['gb'] ?? 0) ?>;
const nbCount  = <?= (int)($model['nb'] ?? 0) ?>;
const kmCount  = <?= (int)($model['km'] ?? 0) ?>;

/* PIE CHART */
new Chart(document.getElementById('pieChart'), {
  type: 'doughnut',
  data: {
    labels: ['Menyukai Premium', 'menyukai kenyamanan'],
    datasets: [{
      data: [premiumCount, nonPremiumCount],
      backgroundColor: ['#16A34A', '#DC2626'],
      borderColor: ['#fff', '#fff'],
      borderWidth: 3,
      hoverOffset: 6
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '65%',
    plugins: {
      legend: {
        position: 'bottom',
        labels: {
          font: { family: 'Inter', size: 12 },
          padding: 16,
          usePointStyle: true, pointStyle: 'circle'
        }
      }
    }
  }
});

/* BAR CHART */
new Chart(document.getElementById('barChart'), {
  type: 'bar',
  data: {
    labels: ['Random Forest', 'Grad. Boosting', 'Naive Bayes', 'K-Means'],
    datasets: [{
      label: 'Prediksi Positif (Premium)',
      data: [rfCount, gbCount, nbCount, kmCount],
      backgroundColor: ['#3B82F6', '#8B5CF6', '#10B981', '#F59E0B'],
      borderRadius: 6,
      borderSkipped: false
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        labels: {
          font: { family: 'Inter', size: 12 },
          usePointStyle: true, pointStyle: 'circle'
        }
      }
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { font: { family: 'Inter', size: 11 } }
      },
      y: {
        beginAtZero: true,
        grid: { color: '#F1F5F9' },
        ticks: {
          font: { family: 'Inter', size: 11 },
          stepSize: 1
        }
      }
    }
  }
});
</script>
</body>
</html>
