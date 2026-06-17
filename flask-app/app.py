from flask import Flask, request, jsonify
import pickle
import numpy as np
import os
  
app = Flask(__name__)

BASE_DIR = os.path.dirname(os.path.abspath(__file__))

rf = pickle.load(open(os.path.join(BASE_DIR, "rf_model.pkl"), "rb"))
gb = pickle.load(open(os.path.join(BASE_DIR, "gb_model.pkl"), "rb"))
nb = pickle.load(open(os.path.join(BASE_DIR, "nb_model.pkl"), "rb"))
kmeans = pickle.load(open(os.path.join(BASE_DIR, "kmeans_model.pkl"), "rb"))

@app.route('/')
def home():
    return "Flask API Berjalan"

@app.route('/predict', methods=['POST'])
def predict():

    data = request.get_json()

    fitur = np.array([[
        data['jenis_kelamin'],
        data['usia'],
        data['harga'],
        data['desain'],
        data['kenyamanan'],
        data['durasi_tidur']
    ]])

    hasil = {
        "random_forest": int(rf.predict(fitur)[0]),
        "gradient_boosting": int(gb.predict(fitur)[0]),
        "naive_bayes": int(nb.predict(fitur)[0]),
        "kmeans_cluster": int(kmeans.predict(fitur)[0])
    }

    return jsonify(hasil)

if __name__ == '__main__':
    app.run(
        host='0.0.0.0',
        port=5000,
        debug=True
    )