import os
import re
import pandas as pd
import numpy as np
import pickle

from sklearn.model_selection import train_test_split
from sklearn.preprocessing import MinMaxScaler
from sklearn.ensemble import RandomForestClassifier, GradientBoostingClassifier
from sklearn.naive_bayes import GaussianNB
from sklearn.cluster import KMeans

# ==========================
# LOKASI FILE CSV
# ==========================

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

csv_path = os.path.join(BASE_DIR, '..', 'dataset', 'data_bantal.csv')
print("Lokasi CSV :", csv_path)

if not os.path.exists(csv_path):
    raise FileNotFoundError(f"File tidak ditemukan:\n{csv_path}")

# ==========================
# LOAD DATA (support CSV & SQL INSERT)
# ==========================

with open(csv_path, 'r', encoding='utf-8') as f:
    content = f.read()

if 'INSERT INTO' in content or 'VALUES' in content:
    print("Format terdeteksi : SQL INSERT")
    rows = re.findall(r"\(([^)]+)\)", content)
    data = []
    for row in rows:
        if any(k in row.lower() for k in ['nama', 'insert', 'jenis_kelamin']):
            continue
        vals = [v.strip().strip("'") for v in row.split(',')]
        if len(vals) >= 7:
            data.append(vals[:12])

    cols = ['nama', 'jenis_kelamin', 'usia', 'harga', 'desain',
            'kenyamanan', 'durasi_tidur', 'random_forest', 'gradient_boosting',
            'naive_bayes', 'kmeans_cluster', 'kesimpulan']
    df = pd.DataFrame(data, columns=cols[:len(data[0])] if data else cols)
else:
    print("Format terdeteksi : CSV")
    df = pd.read_csv(csv_path)
    df.columns = df.columns.str.strip().str.lower().str.replace(' ', '_')
    for col in df.columns:
        df = df[df[col].astype(str).str.strip().str.lower() != col]
    df = df.reset_index(drop=True)

print(f"Jumlah Data : {len(df)}")
print(df.head())

# ==========================
# PREPROCESSING
# ==========================

# Encode jenis kelamin
df['jenis_kelamin'] = df['jenis_kelamin'].astype(str).str.strip().str.upper()
df['jenis_kelamin'] = df['jenis_kelamin'].map({'L': 0, 'P': 1}).fillna(0).astype(int)

# Konversi kolom numerik
for col in ['usia', 'harga', 'desain', 'kenyamanan', 'durasi_tidur']:
    df[col] = pd.to_numeric(df[col].astype(str).str.strip(), errors='coerce')
    df[col] = df[col].fillna(df[col].median())  # isi NaN dengan median, jangan drop

print("\nDistribusi data setelah preprocessing:")
print(df[['usia', 'harga', 'desain', 'kenyamanan', 'durasi_tidur']].describe().round(2))

# ==========================
# LABEL TARGET — PERBAIKAN THRESHOLD
# ==========================
# ❌ Sebelumnya: >= 12 → terlalu tinggi, hampir semua jadi Premium
# ✅ Sekarang  : >= median → distribusi seimbang ~50:50

df['skor'] = df['harga'] + df['desain'] + df['kenyamanan']
threshold = df['skor'].median()
df['kelas'] = (df['skor'] >= threshold).astype(int)

print(f"\nThreshold (median)  : {threshold}")
print(f"Kelas 1 - Premium   : {df['kelas'].sum()} ({df['kelas'].mean()*100:.1f}%)")
print(f"Kelas 0 - Non-Prem  : {(df['kelas']==0).sum()} ({(1-df['kelas'].mean())*100:.1f}%)")

# ==========================
# FITUR DAN TARGET
# ==========================

X = df[['jenis_kelamin', 'usia', 'harga', 'desain', 'kenyamanan', 'durasi_tidur']]
y = df['kelas']

# ==========================
# SPLIT DATA (stratified)
# ==========================

X_train, X_test, y_train, y_test = train_test_split(
    X, y,
    test_size=0.2,
    random_state=42,
    stratify=y        # ← pastikan proporsi kelas sama di train & test
)

print(f"\nData Training : {len(X_train)}")
print(f"Data Testing  : {len(X_test)}")

# ==========================
# RANDOM FOREST
# ==========================

rf = RandomForestClassifier(
    n_estimators=100,
    random_state=42,
    class_weight='balanced'   # tahan terhadap imbalance
)
rf.fit(X_train, y_train)
print(f"\nRandom Forest     accuracy: {rf.score(X_test, y_test):.4f}")

# ==========================
# GRADIENT BOOSTING
# ==========================

gb = GradientBoostingClassifier(
    n_estimators=100,
    learning_rate=0.1,
    max_depth=3,
    random_state=42
)
gb.fit(X_train, y_train)
print(f"Gradient Boosting accuracy: {gb.score(X_test, y_test):.4f}")

# ==========================
# NAIVE BAYES
# ==========================

nb = GaussianNB()
nb.fit(X_train, y_train)
print(f"Naive Bayes       accuracy: {nb.score(X_test, y_test):.4f}")

# ==========================
# K-MEANS — dengan scaler & labeling otomatis
# ==========================

scaler = MinMaxScaler()
X_scaled = scaler.fit_transform(X)

kmeans = KMeans(n_clusters=2, random_state=42, n_init=10)
kmeans.fit(X_scaled)

# Tentukan cluster mana yang Premium berdasarkan rata-rata skor
df['cluster_raw'] = kmeans.labels_
df['skor_preferensi'] = df['harga'] + df['desain'] + df['kenyamanan']
rata = df.groupby('cluster_raw')['skor_preferensi'].mean()
cluster_premium     = int(rata.idxmax())
cluster_non_premium = 1 - cluster_premium

print(f"\nKMeans — Cluster {cluster_premium} = Premium, Cluster {cluster_non_premium} = Non-Premium")
print(f"  Rata-rata skor per cluster:\n{rata.to_string()}")

# ==========================
# SIMPAN MODEL
# ==========================

rf_path = os.path.join(BASE_DIR, 'rf_model.pkl')
gb_path = os.path.join(BASE_DIR, 'gb_model.pkl')
nb_path = os.path.join(BASE_DIR, 'nb_model.pkl')
km_path = os.path.join(BASE_DIR, 'kmeans_model.pkl')

# Simpan sebagai dict agar konsisten dengan app.py
pickle.dump({'model': rf,     'threshold': threshold}, open(rf_path, 'wb'))
pickle.dump({'model': gb,     'threshold': threshold}, open(gb_path, 'wb'))
pickle.dump({'model': nb,     'threshold': threshold}, open(nb_path, 'wb'))
pickle.dump({
    'model':               kmeans,
    'scaler':              scaler,
    'cluster_premium':     cluster_premium,
    'cluster_non_premium': cluster_non_premium
}, open(km_path, 'wb'))

print("\n===================================")
print("MODEL BERHASIL DISIMPAN")
print("===================================")
print("Random Forest     :", rf_path)
print("Gradient Boosting :", gb_path)
print("Naive Bayes       :", nb_path)
print("KMeans            :", km_path)