# 1. Import library
import pickle
import numpy as np
import pandas as pd
from fastapi import FastAPI
from pydantic import BaseModel

# 2. Inisialisasi FastAPI
app = FastAPI(
    title="API Deteksi Stunting (Random Forest Multioutput)",
    description="API ini memanfaatkan model Random Forest multioutput (dilatih dengan target one-hot) untuk prediksi status gizi balita.",
    version="2.2.0"
)

# 3. Struktur input
class StuntingFeatures(BaseModel):
    umur_bulan: float
    tinggi_badan_cm: float
    jenis_kelamin: str  # 'laki-laki' atau 'perempuan'

# 4. Muat model, encoder, scaler
try:
    with open("model/random_forest_model.pkl", "rb") as f:
        model = pickle.load(f)

    with open("model/onehot_encoder.pkl", "rb") as f:
        encoder = pickle.load(f)

    with open("model/standard_scaler.pkl", "rb") as f:
        scaler = pickle.load(f)

    print("✅ Model, encoder, dan scaler berhasil dimuat.")
except FileNotFoundError as e:
    print("❌ File model/encoder/scaler tidak ditemukan:", e)
    model, encoder, scaler = None, None, None

# 5. Label mapping sesuai urutan training
label_mapping = {
    0: "normal",
    1: "severely stunted",
    2: "stunted",
    3: "tinggi"
}

# 6. Endpoint prediksi
@app.post("/predict")
async def predict_stunting(features: StuntingFeatures):
    if None in [model, encoder, scaler]:
        return {"error": "Model, encoder, atau scaler belum dimuat dengan benar."}

    # Buat DataFrame dari input pengguna
    input_df = pd.DataFrame([{
        "Umur (bulan)": features.umur_bulan,
        "Tinggi Badan (cm)": features.tinggi_badan_cm,
        "Jenis Kelamin": features.jenis_kelamin
    }])

    # --- Preprocessing ---
    numeric_features = ["Umur (bulan)", "Tinggi Badan (cm)"]
    input_df[numeric_features] = scaler.transform(input_df[numeric_features])

    # Siapkan kolom encoder
    encoder_input = pd.DataFrame(columns=encoder.feature_names_in_)
    for col in encoder.feature_names_in_:
        if col == "Jenis Kelamin":
            encoder_input[col] = [features.jenis_kelamin]
        else:
            # Kolom dummy untuk kolom yang tidak digunakan (seperti 'Status Gizi')
            encoder_input[col] = [encoder.categories_[encoder.feature_names_in_.tolist().index(col)][0]]

    # Encode kategorikal
    encoded_cat = encoder.transform(encoder_input)
    encoded_cat_df = pd.DataFrame(encoded_cat, columns=encoder.get_feature_names_out())

    # Gabungkan numerik + encoded 'Jenis Kelamin'
    final_input = pd.concat([input_df[numeric_features], encoded_cat_df.filter(like="Jenis Kelamin")], axis=1)

    # --- Prediksi ---
    y_pred = model.predict(final_input)

    # Tangani probabilitas (multioutput = list of arrays)
    prob_list = model.predict_proba(final_input)
    # Ambil probabilitas kelas "1" untuk tiap label one-hot
    probs = np.array([p[0, 1] for p in prob_list])

    # Tentukan kelas dengan probabilitas tertinggi
    pred_index = int(np.argmax(probs))
    confidence_score = float(np.max(probs))
    pred_label = label_mapping[pred_index]

    return {
        "prediction_label": pred_label,
        "confidence_score": round(confidence_score, 4)
    }

# 7. Root endpoint
@app.get("/")
def root():
    return {"status": "API Deteksi Stunting berjalan dengan baik!"}
