import os
from PIL import Image

# Folder utama tempat gambar berada
BASE_DIR = r"C:\Users\merta\Downloads\Compressed\7am"

# Kualitas kompresi (0–100)
QUALITY = 30

def compress_image(path):
    try:
        img = Image.open(path)

        # Convert ke RGB jika image memiliki alpha (PNG)
        if img.mode in ("RGBA", "P"):
            img = img.convert("RGB")

        img = img.resize((img.width // 2, img.height // 2))
        img.save(path, quality=70)
        print(f"Compressed: {path}")

    except Exception as e:
        print(f"Failed: {path} -> {e}")


for root, dirs, files in os.walk(BASE_DIR):
    for file in files:
        if file.lower().endswith((".jpg", ".jpeg", ".png")):
            full_path = os.path.join(root, file)
            compress_image(full_path)

print("Done!")
