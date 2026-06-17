<?php
// Semua logika PHP dijalankan SEBELUM output HTML apapun
if (session_status() === PHP_SESSION_NONE) session_start();

$conn = mysqli_connect("localhost","root","","presentase");
if (!$conn) die("Koneksi database gagal: " . mysqli_connect_error());
 
/* LOGIN ADMIN */
$login_error = "";
if (isset($_POST['login_admin'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $cek = mysqli_query($conn,"SELECT * FROM user WHERE username='$username' AND password='$password'");
  if (mysqli_num_rows($cek) > 0) {
    $_SESSION['admin'] = true;
    $_SESSION['username'] = $username;
    header("Location: dashboard.php"); exit;
  } else {
    $login_error = "Username atau password salah.";
  }
}

/* ANALISIS */
$hasil = []; $kesimpulan = "";
$rf_text = $gb_text = $nb_text = $cluster_text = "";
$score_kenyamanan = $score_desain = $score_harga = 0;
$show_result = false;

if (isset($_POST['simpan'])) {
  $nama         = mysqli_real_escape_string($conn, $_POST['nama']);
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $usia         = (int)$_POST['usia'];
  $harga        = (int)$_POST['harga'];
  $desain       = (int)$_POST['desain'];
  $kenyamanan   = (int)$_POST['kenyamanan'];
  $durasi_tidur = (int)$_POST['durasi_tidur'];
  $jk_num       = ($jenis_kelamin == "L") ? 0 : 1;

  $score_harga      = max(0, min(100, $harga * 20));
  $score_desain     = max(0, min(100, $desain * 20));
  $score_kenyamanan = max(0, min(100, $kenyamanan * 20));

  $data = ["jenis_kelamin"=>$jk_num,"usia"=>$usia,"harga"=>$harga,"desain"=>$desain,"kenyamanan"=>$kenyamanan,"durasi_tidur"=>$durasi_tidur];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "http://localhost:5000/predict");
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  if (curl_errno($ch)) die("Gagal koneksi Flask API: " . curl_error($ch));
  curl_close($ch);

  $hasil = json_decode($response, true);

  if (is_array($hasil) && !empty($hasil)) {
    $rf_pred = isset($hasil['random_forest'])     ? (int)$hasil['random_forest']     : null;
    $gb_pred = isset($hasil['gradient_boosting']) ? (int)$hasil['gradient_boosting'] : null;
    $nb_pred = isset($hasil['naive_bayes'])        ? (int)$hasil['naive_bayes']        : null;
    $km_pred = isset($hasil['kmeans_cluster'])     ? (int)$hasil['kmeans_cluster']     : null;

    $toText = fn($v) => ((int)$v === 1) ? 'Menyukai Produk Premium' : 'Tidak Menyukai Premium';
    $toIcon = fn($v) => ((int)$v === 1) ? 'positive' : 'negative';

    $rf_text      = ($rf_pred === null) ? 'Tidak tersedia' : $toText($rf_pred);
    $rf_status    = ($rf_pred === null) ? '' : $toIcon($rf_pred);
    $gb_text      = ($gb_pred === null) ? 'Tidak tersedia' : $toText($gb_pred);
    $gb_status    = ($gb_pred === null) ? '' : $toIcon($gb_pred);
    $nb_text      = ($nb_pred === null) ? 'Tidak tersedia' : $toText($nb_pred);
    $nb_status    = ($nb_pred === null) ? '' : $toIcon($nb_pred);
    $cluster_text = ($km_pred === null) ? 'Tidak tersedia' : (($km_pred === 1) ? 'Cluster Premium' : 'Cluster Non-Premium');
    $cluster_status = ($km_pred === null) ? '' : (($km_pred === 1) ? 'positive' : 'negative');

    $votes = (int)($rf_pred===1) + (int)($gb_pred===1) + (int)($nb_pred===1);
    $kesimpulan_status = ($votes >= 2) ? 'positive' : 'negative';

    $is_premium = ($votes >= 2);
    $kesimpulan_label = $is_premium ? 'Menyukai Produk Premium' : 'Tidak Menyukai Produk Premium';

    $kesimpulan = $is_premium
      ? "Mayoritas model ({$votes}/3) menunjukkan pelanggan <strong>menyukai Produk Premium</strong>."
      : "Mayoritas model menunjukkan pelanggan <strong>tidak menyukai Produk Premium</strong>.";

    /* ============================
       INSERT KE DATABASE
    ============================ */
    /* ============================
   INSERT KE DATABASE
============================ */
try {
  $stmt = mysqli_prepare($conn, "INSERT INTO data_preferensi
    (nama, jenis_kelamin, usia, harga, desain, kenyamanan, durasi_tidur,
     random_forest, gradient_boosting, naive_bayes, kmeans_cluster,
     kesimpulan)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

  if ($stmt) {
    // s = string, i = integer
    // nama(s), jenis_kelamin(s), usia(i), harga(i), desain(i),
    // kenyamanan(i), durasi_tidur(i), rf(i), gb(i), nb(i), km(i), kesimpulan(s)
    mysqli_stmt_bind_param(
      $stmt,
      "ssiiiiiiiiis",   // 12 kolom: s,s,i,i,i,i,i,i,i,i,i,s
      $nama,            // s - string
      $jenis_kelamin,   // s - string ("L"/"P")
      $usia,            // i - integer
      $harga,           // i - integer
      $desain,          // i - integer
      $kenyamanan,      // i - integer
      $durasi_tidur,    // i - integer
      $rf_pred,         // i - integer
      $gb_pred,         // i - integer
      $nb_pred,         // i - integer
      $km_pred,         // i - integer
      $kesimpulan_label // s - string
    );

    if (!mysqli_stmt_execute($stmt)) {
      error_log("INSERT gagal: " . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt);
  } else {
    error_log("Prepare gagal: " . mysqli_error($conn));
  }
} catch (Throwable $e) {
  error_log("Exception INSERT: " . $e->getMessage());
}

    $show_result = true;
  } else {
    $kesimpulan = 'Respon dari Flask tidak valid atau kosong.';
    $kesimpulan_status = 'negative';
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pillow Analytics — AI Customer Preference System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ==================== RESET & BASE ==================== */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

:root {
  --navy:       #0F2044;
  --navy-mid:   #1A3263;
  --blue:       #1D4ED8;
  --blue-light: #3B82F6;
  --slate:      #475569;
  --slate-light:#94A3B8;
  --bg:         #F1F5F9;
  --surface:    #FFFFFF;
  --border:     #E2E8F0;
  --text:       #0F172A;
  --text-muted: #64748B;
  --green:      #16A34A;
  --green-bg:   #F0FDF4;
  --red:        #DC2626;
  --red-bg:     #FEF2F2;
  --amber:      #D97706;
  --amber-bg:   #FFFBEB;
}

body {
  font-family: 'Inter', sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  font-size: 14px;
  line-height: 1.6;
}

/* ==================== TOPBAR ==================== */
.topbar {
  background: var(--navy);
  height: 4px;
  width: 100%;
}

/* ==================== NAVBAR ==================== */
.navbar {
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  padding: 0;
  height: 60px;
  position: sticky;
  top: 0;
  z-index: 100;
  box-shadow: 0 1px 3px rgba(0,0,0,.06);
}
.navbar-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 60px;
  padding: 0 24px;
  max-width: 1200px;
  margin: 0 auto;
}
.brand {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}
.brand-icon {
  width: 32px; height: 32px;
  background: var(--navy);
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  color: white; font-size: 14px; font-weight: 700;
  letter-spacing: -.5px;
  font-family: 'Plus Jakarta Sans', sans-serif;
}
.brand-name {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-weight: 700;
  font-size: 16px;
  color: var(--navy);
  letter-spacing: -.3px;
}
.brand-name span { color: var(--blue); }
.nav-badge {
  font-size: 11px;
  background: #EFF6FF;
  color: var(--blue);
  padding: 2px 8px;
  border-radius: 20px;
  font-weight: 600;
  border: 1px solid #DBEAFE;
  margin-left: 4px;
}
.admin-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  background: transparent;
  border: 1px solid var(--border);
  color: var(--slate);
  padding: 7px 14px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  transition: all .2s;
  font-family: 'Inter', sans-serif;
}
.admin-btn:hover {
  background: var(--navy);
  border-color: var(--navy);
  color: white;
}
.admin-btn svg { width: 15px; height: 15px; }

/* ==================== PAGE HEADER ==================== */
.page-header {
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  padding: 28px 0 24px;
}
.page-header-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 24px;
}
.breadcrumb-row {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-bottom: 10px;
}
.breadcrumb-item {
  font-size: 12px;
  color: var(--text-muted);
  font-weight: 500;
}
.breadcrumb-sep { color: var(--border); font-size: 12px; }
.breadcrumb-item.active { color: var(--blue); }
.page-title {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 24px;
  font-weight: 800;
  color: var(--navy);
  letter-spacing: -.5px;
  margin-bottom: 4px;
}
.page-subtitle {
  font-size: 13.5px;
  color: var(--text-muted);
  font-weight: 400;
}

/* ==================== MAIN LAYOUT ==================== */
.main-wrap {
  max-width: 1200px;
  margin: 0 auto;
  padding: 28px 24px 48px;
}
.main-grid {
  display: grid;
  grid-template-columns: 380px 1fr;
  gap: 24px;
  align-items: start;
}

/* ==================== CARDS ==================== */
.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 0;
  box-shadow: 0 1px 3px rgba(0,0,0,.04);
}
.card-header {
  padding: 18px 22px 16px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 10px;
}
.card-header-icon {
  width: 32px; height: 32px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px;
  flex-shrink: 0;
}
.icon-blue  { background: #EFF6FF; }
.icon-green { background: #F0FDF4; }
.icon-purple{ background: #F5F3FF; }
.card-header-text h3 {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 14px;
  font-weight: 700;
  color: var(--navy);
  margin-bottom: 1px;
}
.card-header-text p {
  font-size: 12px;
  color: var(--text-muted);
  margin: 0;
}
.card-body {
  padding: 22px;
}

/* ==================== FORM ==================== */
.form-section-label {
  font-size: 11px;
  font-weight: 600;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: .6px;
  margin-bottom: 12px;
  margin-top: 6px;
  padding-top: 16px;
  border-top: 1px solid var(--border);
}
.form-section-label:first-child {
  border-top: none;
  padding-top: 0;
  margin-top: 0;
}
.form-label {
  font-size: 13px;
  font-weight: 500;
  color: var(--text);
  margin-bottom: 6px;
  display: block;
}
.form-control, .form-select {
  font-family: 'Inter', sans-serif;
  font-size: 13.5px;
  color: var(--text);
  border: 1px solid var(--border);
  background: #FAFBFC;
  border-radius: 8px;
  padding: 9px 12px;
  width: 100%;
  transition: all .18s;
  outline: none;
  appearance: none;
  -webkit-appearance: none;
}
.form-control:focus, .form-select:focus {
  border-color: var(--blue-light);
  background: white;
  box-shadow: 0 0 0 3px rgba(59,130,246,.12);
}
.form-hint {
  font-size: 11.5px;
  color: var(--text-muted);
  margin-top: 4px;
}
.form-row { margin-bottom: 14px; }

/* Rating input */
.rating-group {
  display: flex;
  gap: 6px;
}
.rating-group input[type="radio"] { display: none; }
.rating-group label {
  width: 36px; height: 36px;
  display: flex; align-items: center; justify-content: center;
  border: 1px solid var(--border);
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  color: var(--text-muted);
  cursor: pointer;
  transition: all .15s;
  background: #FAFBFC;
  margin-bottom: 0;
}
.rating-group input[type="radio"]:checked + label {
  background: var(--navy);
  border-color: var(--navy);
  color: white;
}
.rating-group label:hover {
  border-color: var(--blue-light);
  color: var(--blue);
}

/* Submit button */
.btn-submit {
  width: 100%;
  padding: 11px 20px;
  background: var(--navy);
  color: white;
  border: none;
  border-radius: 8px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  transition: all .2s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  margin-top: 6px;
  letter-spacing: -.1px;
}
.btn-submit:hover {
  background: var(--navy-mid);
  transform: translateY(-1px);
  box-shadow: 0 4px 16px rgba(15,32,68,.18);
}
.btn-submit svg { width: 16px; height: 16px; }

/* ==================== RESULT PANEL ==================== */
.result-placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 56px 24px;
  color: var(--text-muted);
  min-height: 340px;
}
.placeholder-icon {
  width: 56px; height: 56px;
  background: var(--bg);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 24px;
  margin-bottom: 14px;
}
.placeholder-title { font-size: 15px; font-weight: 600; color: var(--slate); margin-bottom: 6px; }
.placeholder-sub   { font-size: 13px; line-height: 1.6; }

/* Models grid */
.models-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-bottom: 20px;
}
.model-card {
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 14px 16px;
  position: relative;
  overflow: hidden;
}
.model-card::before {
  content: '';
  position: absolute;
  left: 0; top: 0; bottom: 0;
  width: 3px;
}
.model-card.positive::before { background: var(--green); }
.model-card.negative::before { background: var(--red); }
.model-card.neutral::before  { background: var(--border); }
.model-card-label {
  font-size: 11px;
  font-weight: 600;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: .5px;
  margin-bottom: 6px;
  display: flex;
  align-items: center;
  gap: 5px;
}
.model-card-value {
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
  line-height: 1.4;
}
.status-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  display: inline-block;
  flex-shrink: 0;
}
.dot-positive { background: var(--green); }
.dot-negative { background: var(--red); }
.dot-neutral  { background: var(--slate-light); }

/* Scores */
.scores-section { margin-bottom: 18px; }
.score-row {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}
.score-label {
  font-size: 12px;
  font-weight: 500;
  color: var(--text-muted);
  width: 120px;
  flex-shrink: 0;
}
.score-bar-wrap {
  flex: 1;
  height: 8px;
  background: var(--bg);
  border-radius: 4px;
  overflow: hidden;
}
.score-bar {
  height: 100%;
  border-radius: 4px;
  transition: width .6s ease;
}
.bar-blue   { background: var(--blue); }
.bar-green  { background: var(--green); }
.bar-amber  { background: var(--amber); }
.score-pct {
  font-size: 12px;
  font-weight: 600;
  color: var(--slate);
  width: 36px;
  text-align: right;
  flex-shrink: 0;
}

/* Conclusion */
.conclusion-card {
  border-radius: 10px;
  padding: 16px 18px;
  border: 1px solid;
}
.conclusion-card.positive {
  background: var(--green-bg);
  border-color: #BBF7D0;
}
.conclusion-card.negative {
  background: var(--red-bg);
  border-color: #FECACA;
}
.conclusion-label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .6px;
  margin-bottom: 6px;
}
.conclusion-card.positive .conclusion-label { color: var(--green); }
.conclusion-card.negative .conclusion-label { color: var(--red); }
.conclusion-text {
  font-size: 13px;
  line-height: 1.6;
  color: var(--text);
}

/* ==================== INFO ROW (bottom) ==================== */
.info-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 22px;
  border-top: 1px solid var(--border);
  background: #FAFBFC;
  border-radius: 0 0 12px 12px;
}
.info-tag {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 11.5px;
  font-weight: 500;
  color: var(--text-muted);
}
.info-tag svg { width: 13px; height: 13px; }

/* ==================== NOTEBOOKS SECTION ==================== */
.section-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 14px;
  margin-top: 28px;
}
.section-title {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 15px;
  font-weight: 700;
  color: var(--navy);
}
.section-subtitle {
  font-size: 12.5px;
  color: var(--text-muted);
  margin-top: 2px;
}
.notebooks-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}
.nb-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 18px 16px;
  box-shadow: 0 1px 2px rgba(0,0,0,.04);
  transition: all .2s;
  cursor: default;
}
.nb-card:hover {
  border-color: #BFDBFE;
  box-shadow: 0 4px 12px rgba(29,78,216,.08);
  transform: translateY(-2px);
}
.nb-icon {
  width: 38px; height: 38px;
  border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
  margin-bottom: 12px;
}
.nb-title {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 13px;
  font-weight: 700;
  color: var(--navy);
  margin-bottom: 4px;
}
.nb-desc {
  font-size: 11.5px;
  color: var(--text-muted);
  line-height: 1.5;
  margin-bottom: 12px;
}
.nb-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10.5px;
  font-weight: 600;
  padding: 3px 8px;
  border-radius: 20px;
  text-transform: uppercase;
  letter-spacing: .3px;
}
.badge-blue   { background: #EFF6FF; color: var(--blue); }
.badge-green  { background: #F0FDF4; color: var(--green); }
.badge-purple { background: #F5F3FF; color: #7C3AED; }
.badge-orange { background: #FFF7ED; color: #C2410C; }

/* ==================== MODAL ==================== */
.modal-content {
  border: none;
  border-radius: 14px;
  overflow: hidden;
}
.modal-header {
  background: var(--navy);
  color: white;
  border: none;
  padding: 20px 24px;
}
.modal-title {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 16px;
  font-weight: 700;
}
.modal-header .btn-close { filter: invert(1); opacity: .7; }
.modal-body { padding: 24px; }
.modal-form-label {
  font-size: 13px;
  font-weight: 500;
  color: var(--text);
  margin-bottom: 6px;
  display: block;
}
.modal-input {
  font-family: 'Inter', sans-serif;
  font-size: 13.5px;
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 10px 12px;
  width: 100%;
  outline: none;
  transition: all .18s;
  background: #FAFBFC;
  color: var(--text);
}
.modal-input:focus {
  border-color: var(--blue-light);
  background: white;
  box-shadow: 0 0 0 3px rgba(59,130,246,.12);
}
.mb-modal { margin-bottom: 16px; }
.btn-login {
  width: 100%;
  padding: 11px 20px;
  background: var(--navy);
  color: white;
  border: none;
  border-radius: 8px;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  transition: background .2s;
  margin-top: 6px;
}
.btn-login:hover { background: var(--navy-mid); }
.alert-error {
  background: var(--red-bg);
  border: 1px solid #FECACA;
  color: var(--red);
  border-radius: 8px;
  padding: 10px 14px;
  font-size: 13px;
  font-weight: 500;
  margin-bottom: 16px;
}

/* ==================== FOOTER ==================== */
footer {
  border-top: 1px solid var(--border);
  background: var(--surface);
  padding: 16px 24px;
  text-align: center;
}
footer small { color: var(--text-muted); font-size: 12px; }

/* ==================== RESPONSIVE ==================== */
@media (max-width: 900px) {
  .main-grid { grid-template-columns: 1fr; }
  .notebooks-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 600px) {
  .models-grid { grid-template-columns: 1fr; }
  .notebooks-grid { grid-template-columns: 1fr; }
  .page-title { font-size: 20px; }
  .main-wrap { padding: 16px 14px 40px; }
}
</style>
</head>
<body>

<div class="topbar"></div>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="navbar-inner">
    <a href="#" class="brand">
      <div class="brand-icon">PA</div>
      <div>
        <div class="brand-name">Pillow<span>Analytics</span></div>
      </div>
      <span class="nav-badge">AI System</span>
    </a>
    <button class="admin-btn" data-bs-toggle="modal" data-bs-target="#loginModal">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
      </svg>
      Admin Login
    </button>
  </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
  <div class="page-header-inner">
    <div class="breadcrumb-row">
      <span class="breadcrumb-item">Dashboard</span>
      <span class="breadcrumb-sep">›</span>
      <span class="breadcrumb-item active">Analisis Preferensi Pelanggan</span>
    </div>
    <h1 class="page-title">AI Customer Preference Analyzer</h1>
    <p class="page-subtitle">Analisis preferensi konsumen produk bantal menggunakan ensemble machine learning — Random Forest, Gradient Boosting, Naive Bayes, dan K-Means Clustering.</p>
  </div>
</div>

<!-- MAIN -->
<div class="main-wrap">
  <div class="main-grid">

    <!-- LEFT: FORM -->
    <div>
      <div class="card">
        <div class="card-header">
          <div class="card-header-icon icon-blue">📋</div>
          <div class="card-header-text">
            <h3>Input Data Konsumen</h3>
            <p>Isi semua field untuk menjalankan analisis</p>
          </div>
        </div>
        <div class="card-body">
          <form method="POST">
            <!-- Identitas -->
            <div class="form-section-label">Identitas Pelanggan</div>
            <div class="form-row">
              <label class="form-label">Nama Product</label>
              <input type="text" name="nama" class="form-control" placeholder="Nama Product Yuureco" required>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
              <div class="form-row">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select">
                  <option value="L">Laki-Laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
              <div class="form-row">
                <label class="form-label">Usia (tahun)</label>
                <input type="number" name="usia" class="form-control" placeholder="Contoh: 28" min="1" max="99" required>
              </div>
            </div>
            <div class="form-row">
              <label class="form-label">Durasi Tidur per Malam (jam)</label>
              <input type="number" name="durasi_tidur" class="form-control" placeholder="Contoh: 7" min="1" max="24" required>
            </div>

            <!-- Preferensi -->
            <div class="form-section-label">Preferensi Produk (skala 1–5)</div>
            <div class="form-row">
              <label class="form-label">Sensitivitas Harga</label>
              <div class="rating-group">
                <?php for ($i=1;$i<=5;$i++): ?>
                <input type="radio" name="harga" id="h<?=$i?>" value="<?=$i?>" <?=$i==3?'checked':''?> required>
                <label for="h<?=$i?>"><?=$i?></label>
                <?php endfor; ?>
              </div>
              <div class="form-hint">1 = Tidak sensitif &nbsp;·&nbsp; 5 = Sangat sensitif terhadap harga</div>
            </div>
            <div class="form-row">
              <label class="form-label">Prioritas Desain Produk</label>
              <div class="rating-group">
                <?php for ($i=1;$i<=5;$i++): ?>
                <input type="radio" name="desain" id="d<?=$i?>" value="<?=$i?>" <?=$i==3?'checked':''?> required>
                <label for="d<?=$i?>"><?=$i?></label>
                <?php endfor; ?>
              </div>
              <div class="form-hint">1 = Tidak diutamakan &nbsp;·&nbsp; 5 = Sangat memperhatikan desain</div>
            </div>
            <div class="form-row">
              <label class="form-label">Tingkat Kepentingan Kenyamanan</label>
              <div class="rating-group">
                <?php for ($i=1;$i<=5;$i++): ?>
                <input type="radio" name="kenyamanan" id="k<?=$i?>" value="<?=$i?>" <?=$i==3?'checked':''?> required>
                <label for="k<?=$i?>"><?=$i?></label>
                <?php endfor; ?>
              </div>
              <div class="form-hint">1 = Tidak diutamakan &nbsp;·&nbsp; 5 = Sangat mengutamakan kenyamanan</div>
            </div>

            <button name="simpan" class="btn-submit">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/>
              </svg>
              Jalankan Analisis AI
            </button>
          </form>
        </div>
        <div class="info-row">
          <span class="info-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Data diproses secara lokal
          </span>
          <span class="info-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
            Respons real-time
          </span>
        </div>
      </div>
    </div>

    <!-- RIGHT: RESULT -->
    <div>
      <div class="card">
        <div class="card-header">
          <div class="card-header-icon icon-green">📊</div>
          <div class="card-header-text">
            <h3>Hasil Analisis Model</h3>
            <p>Output prediksi dari 4 algoritma machine learning</p>
          </div>
        </div>
        <div class="card-body">

          <?php if (!$show_result): ?>
          <div class="result-placeholder">
            <div class="placeholder-icon">🤖</div>
            <div class="placeholder-title">Belum ada data untuk dianalisis</div>
            <div class="placeholder-sub">Isi form di sebelah kiri dan klik "Jalankan Analisis AI" untuk melihat hasil prediksi dari keempat model machine learning.</div>
          </div>
          <?php else: ?>

          <!-- 4 model cards -->
          <div class="models-grid">
            <div class="model-card <?= $rf_status ?>">
              <div class="model-card-label">
                <span class="status-dot dot-<?= $rf_status ?: 'neutral' ?>"></span>
                Random Forest
              </div>
              <div class="model-card-value"><?= $rf_text ?></div>
            </div>
            <div class="model-card <?= $gb_status ?>">
              <div class="model-card-label">
                <span class="status-dot dot-<?= $gb_status ?: 'neutral' ?>"></span>
                Gradient Boosting
              </div>
              <div class="model-card-value"><?= $gb_text ?></div>
            </div>
            <div class="model-card <?= $nb_status ?>">
              <div class="model-card-label">
                <span class="status-dot dot-<?= $nb_status ?: 'neutral' ?>"></span>
                Naive Bayes
              </div>
              <div class="model-card-value"><?= $nb_text ?></div>
            </div>
            <div class="model-card <?= $cluster_status ?>">
              <div class="model-card-label">
                <span class="status-dot dot-<?= $cluster_status ?: 'neutral' ?>"></span>
                K-Means Clustering
              </div>
              <div class="model-card-value"><?= $cluster_text ?></div>
            </div>
          </div>

          <!-- Scores -->
          <div class="scores-section">
            <p style="font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px;">Customer Preference Score</p>
            <div class="score-row">
              <div class="score-label">Kenyamanan</div>
              <div class="score-bar-wrap"><div class="score-bar bar-blue" style="width:<?= $score_kenyamanan ?>%"></div></div>
              <div class="score-pct"><?= $score_kenyamanan ?>%</div>
            </div>
            <div class="score-row">
              <div class="score-label">Desain Produk</div>
              <div class="score-bar-wrap"><div class="score-bar bar-green" style="width:<?= $score_desain ?>%"></div></div>
              <div class="score-pct"><?= $score_desain ?>%</div>
            </div>
            <div class="score-row" style="margin-bottom:0">
              <div class="score-label">Sensitivitas Harga</div>
              <div class="score-bar-wrap"><div class="score-bar bar-amber" style="width:<?= $score_harga ?>%"></div></div>
              <div class="score-pct"><?= $score_harga ?>%</div>
            </div>
          </div>

          <!-- Conclusion -->
          <div class="conclusion-card <?= $kesimpulan_status ?>">
            <div class="conclusion-label">Kesimpulan Akhir</div>
            <div class="conclusion-text"><?= $kesimpulan ?></div>
          </div>

          <?php endif; ?>
        </div>
        <?php if ($show_result): ?>
        <div class="info-row">
          <span class="info-tag">Model dijalankan: 4 algoritma</span>
          <span class="info-tag"><?= date('d M Y, H:i') ?></span>
        </div>
        <?php endif; ?>
      </div>
    </div>

  </div><!-- /main-grid -->

  <!-- NOTEBOOKS SECTION -->
  <div class="section-head">
    <div>
      <div class="section-title">Model Notebooks</div>
      <div class="section-subtitle">Source code notebook Jupyter untuk setiap model machine learning yang digunakan</div>
    </div>
  </div>
  <div class="notebooks-grid">
    <div class="nb-card">
      <div class="nb-icon" style="background:#EFF6FF;">🌲</div>
      <div class="nb-title">Random Forest</div>
      <div class="nb-desc">Model klasifikasi yang terdiri dari banyak pohon keputusan (decision tree). Hasil prediksi diperoleh dari voting mayoritas seluruh pohon sehingga lebih akurat dan stabil dibanding satu pohon keputusan..</div>
      <span class="nb-badge badge-blue">Classifier</span>
    </div>
    <div class="nb-card">
      <div class="nb-icon" style="background:#FFF7ED;">⚡</div>
      <div class="nb-title">Gradient Boosting</div>
      <div class="nb-desc">Model ensemble yang membangun pohon keputusan secara bertahap. Setiap pohon baru dibuat untuk memperbaiki kesalahan pohon sebelumnya sehingga menghasilkan prediksi yang lebih baik..</div>
      <span class="nb-badge badge-orange">Boosting</span>
    </div>
    <div class="nb-card">
      <div class="nb-icon" style="background:#F0FDF4;">📐</div>
      <div class="nb-title">Naive Bayes</div>
      <div class="nb-desc">Model klasifikasi berbasis teori probabilitas (Bayes Theorem). Mengasumsikan setiap fitur bersifat independen dan sering digunakan karena cepat serta efektif pada berbagai kasus klasifikasi..</div>
      <span class="nb-badge badge-green">Probabilistic</span>
    </div>
    <div class="nb-card">
      <div class="nb-icon" style="background:#F5F3FF;">🔵</div>
      <div class="nb-title">K-Means Clustering</div>
      <div class="nb-desc">Model unsupervised learning yang digunakan untuk mengelompokkan data ke dalam beberapa cluster berdasarkan kemiripan karakteristik tanpa memerlukan label data.</div>
      <span class="nb-badge badge-purple">Clustering</span>
    </div>
  </div>

</div><!-- /main-wrap -->

<!-- ADMIN MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Administrator Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php if(!empty($login_error)){ ?>
        <div class="alert-error"><?= $login_error ?></div>
        <?php } ?>
        <form method="POST">
          <div class="mb-modal">
            <label class="modal-form-label">Username</label>
            <input type="text" name="username" class="modal-input" placeholder="Masukkan username" required>
          </div>
          <div class="mb-modal">
            <label class="modal-form-label">Password</label>
            <input type="password" name="password" class="modal-input" placeholder="Masukkan password" required>
          </div>
          <button name="login_admin" class="btn-login">Masuk ke Dashboard</button>
        </form>
      </div>
    </div>
  </div>
</div>

<footer>
  <small>Pillow Analytics AI System &copy; <?= date('Y') ?> &nbsp;·&nbsp; Powered by Flask + Scikit-learn</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
