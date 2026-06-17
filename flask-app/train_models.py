import os
import pandas as pd
import pickle
 
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.ensemble import GradientBoostingClassifier
from sklearn.naive_bayes import GaussianNB
from sklearn.cluster import KMeans

# ==========================
# LOKASI FILE CSV
# ==========================

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

csv_path = os.path.join(
    BASE_DIR,
    '..',
    'dataset',
    'data_bantal.csv'
)

print("Lokasi CSV :", csv_path)

if not os.path.exists(csv_path):
    raise FileNotFoundError(
        f"File tidak ditemukan:\n{csv_path}"
    )

# ==========================
# MEMBACA DATASET
# ==========================

df = pd.read_csv(csv_path)

print("\nJumlah Data :", len(df))
print(df.head())

# ==========================
# PREPROCESSING
# ==========================

df['jenis_kelamin'] = df['jenis_kelamin'].map({
    'L': 0,
    'P': 1
})

# Target/Kelas
df['kelas'] = (
    df['harga']
    + df['desain']
    + df['kenyamanan']
)

df['kelas'] = df['kelas'].apply(
    lambda x: 1 if x >= 12 else 0
)

# ==========================
# FITUR DAN TARGET
# ==========================

X = df[
    [
        'jenis_kelamin',
        'usia',
        'harga',
        'desain',
        'kenyamanan',
        'durasi_tidur'
    ]
]

y = df['kelas']

# ==========================
# SPLIT DATA
# ==========================

X_train, X_test, y_train, y_test = train_test_split(
    X,
    y,
    test_size=0.2,
    random_state=42
)

print("\nData Training :", len(X_train))
print("Data Testing  :", len(X_test))

# ==========================
# RANDOM FOREST
# ==========================

rf = RandomForestClassifier(
    n_estimators=100,
    random_state=42
)

rf.fit(X_train, y_train)

# ==========================
# GRADIENT BOOSTING
# ==========================

gb = GradientBoostingClassifier(
    random_state=42
)

gb.fit(X_train, y_train)

# ==========================
# NAIVE BAYES
# ==========================

nb = GaussianNB()

nb.fit(X_train, y_train)

# ==========================
# K-MEANS
# ==========================

kmeans = KMeans(
    n_clusters=2,
    random_state=42,
    n_init=10
)

kmeans.fit(X)

# ==========================
# SIMPAN MODEL
# ==========================

rf_path = os.path.join(BASE_DIR, 'rf_model.pkl')
gb_path = os.path.join(BASE_DIR, 'gb_model.pkl')
nb_path = os.path.join(BASE_DIR, 'nb_model.pkl')
km_path = os.path.join(BASE_DIR, 'kmeans_model.pkl')

pickle.dump(rf, open(rf_path, 'wb'))
pickle.dump(gb, open(gb_path, 'wb'))
pickle.dump(nb, open(nb_path, 'wb'))
pickle.dump(kmeans, open(km_path, 'wb'))

print("\n===================================")
print("MODEL BERHASIL DISIMPAN")
print("===================================")
print("Random Forest     :", rf_path)
print("Gradient Boosting :", gb_path)
print("Naive Bayes       :", nb_path)
print("KMeans            :", km_path)