from flask import Flask, request, jsonify
import pickle
import numpy as np
import os

app = Flask(__name__)

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

def load_pkl(filename):
    path = os.path.join(BASE_DIR, filename)
    with open(path, "rb") as f:
        return pickle.load(f)

# Load semua model
rf_data     = load_pkl("rf_model.pkl")
gb_data     = load_pkl("gb_model.pkl")
nb_data     = load_pkl("nb_model.pkl")
kmeans_data = load_pkl("kmeans_model.pkl")

# Ekstrak model & info dari dict
rf_model  = rf_data["model"]
gb_model  = gb_data["model"]
nb_model  = nb_data["model"]

kmeans_model   = kmeans_data["model"]
kmeans_scaler  = kmeans_data["scaler"]
cluster_premium     = kmeans_data["cluster_premium"]
cluster_non_premium = kmeans_data["cluster_non_premium"]


@app.route('/')
def home():
    return "Flask API Berjalan"


@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()

    # Validasi field yang wajib ada
    required = ['jenis_kelamin', 'usia', 'harga', 'desain', 'kenyamanan', 'durasi_tidur']
    missing = [f for f in required if f not in data]
    if missing:
        return jsonify({"error": f"Field tidak lengkap: {missing}"}), 400

    fitur = np.array([[
        int(data['jenis_kelamin']),   # 0 = L, 1 = P
        int(data['usia']),
        int(data['harga']),
        int(data['desain']),
        int(data['kenyamanan']),
        int(data['durasi_tidur'])
    ]])

    # Prediksi klasifikasi (RF, GB, NB)
    rf_pred = int(rf_model.predict(fitur)[0])
    gb_pred = int(gb_model.predict(fitur)[0])
    nb_pred = int(nb_model.predict(fitur)[0])

    # Prediksi KMeans — harus di-scale dulu, lalu mapping ke label yang benar
    fitur_scaled = kmeans_scaler.transform(fitur)
    raw_cluster  = int(kmeans_model.predict(fitur_scaled)[0])
    kmeans_label = "Premium" if raw_cluster == cluster_premium else "Non-Premium"

    # Hitung kesimpulan dari voting 3 model klasifikasi
    votes_premium = rf_pred + gb_pred + nb_pred  # jumlah model yang bilang premium
    if votes_premium >= 2:
        kesimpulan = "Menyukai Produk Premium"
    else:
        kesimpulan = "Tidak Menyukai Produk Premium"

    hasil = {
        "random_forest":       rf_pred,           # 0 atau 1
        "gradient_boosting":   gb_pred,           # 0 atau 1
        "naive_bayes":         nb_pred,           # 0 atau 1
        "kmeans_cluster":      raw_cluster,       # nomor cluster (0 atau 1)
        "kmeans_label":        kmeans_label,      # "Premium" / "Non-Premium"
        "votes_premium":       votes_premium,     # berapa model yang bilang premium (0-3)
        "kesimpulan":          kesimpulan
    }

    return jsonify(hasil)


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)