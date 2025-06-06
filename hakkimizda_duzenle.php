<?php
include 'db.php';

// Güncelleme işlemi yapıldıysa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['guncelle'])) {
        $baslik1 = $_POST['baslik1'];
        $baslik2 = $_POST['baslik2'];
        $aciklama = $_POST['aciklama'];

        $stmt = $baglanti->prepare("UPDATE hakkimizda SET baslik1=?, baslik2=?, aciklama=? WHERE id=1");
        $stmt->bind_param("sss", $baslik1, $baslik2, $aciklama);
        if ($stmt->execute()) {
          echo "<script>alert('Güncelleme başarılı'); window.location.href='index.php#hakkimizda';</script>";
          exit;
      }
    } elseif (isset($_POST['geri'])) {
        header("Location: index.php#hakkimizda");
        exit;
    }
}

// Mevcut veriyi çek
$sonuc = $baglanti->query("SELECT * FROM hakkimizda WHERE id=1");
$veri = $sonuc->fetch_assoc();
if (!$veri) {
    die("Hakkımızda verisi bulunamadı.");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <title>Hakkımızda Güncelle</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  <style>
    /* Genel stil */
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
      color: #333;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .container {
      max-width: 600px;
      margin: 80px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .update-title {
      background-color: #e76f51;
      color: white;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
      font-weight: 700;
      margin-bottom: 20px;
      user-select: none;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #555;
      font-weight: 600;
      user-select: none;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1.5px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      box-sizing: border-box;
      transition: border-color 0.3s ease, background-color 0.3s ease, color 0.3s ease;
    }

    input[type="text"]:focus,
    textarea:focus {
      border-color: #e76f51;
      outline: none;
      background-color: #fff;
      color: #333;
    }

    .btn-custom {
      background-color: #e76f51;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-bottom: 10px;
      user-select: none;
    }

    .btn-custom:hover {
      background-color: #c6533f;
    }

    .btn-secondary {
      width: 100%;
      margin-top: 5px;
      padding: 12px;
      border-radius: 6px;
      font-size: 16px;
      user-select: none;
    }

    /* Karanlık mod stilleri */
    body.dark-mode {
      background-color: #121212 !important;
      color: #e0e0e0 !important;
    }

    body.dark-mode .container {
      background-color: #1e1e1e !important;
      box-shadow: 0 10px 20px rgba(0,0,0,0.6);
      color: #e0e0e0 !important;
    }

    body.dark-mode .update-title {
      background-color: #bb4f3d !important;
      color: #f0e6de !important;
    }

    body.dark-mode label {
      color: #ccc !important;
    }

    body.dark-mode input[type="text"],
    body.dark-mode textarea {
      background-color: #333 !important;
      border-color: #555 !important;
      color: #eee !important;
    }

    body.dark-mode input[type="text"]:focus,
    body.dark-mode textarea:focus {
      background-color: #444 !important;
      border-color: #e76f51 !important;
      color: #fff !important;
    }

    body.dark-mode .btn-custom {
      background-color: #bb4f3d !important;
      color: #f0e6de !important;
    }

    body.dark-mode .btn-custom:hover {
      background-color: #993e2c !important;
    }

    body.dark-mode .btn-secondary {
      background-color: #444 !important;
      color: #ddd !important;
      border: none;
    }

    /* Tema değiştirme butonu */
    #theme-toggle {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 999;
        background-color:black;
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18);
        transition: background-color 0.3s ease;
      }

      #theme-toggle:hover {
        background-color: rgba(96, 94, 94, 0.33);
      }
  </style>
</head>
<body>

<div class="container">
  <div class="update-title">Hakkımızda Bilgilerini Güncelle</div>

  <form method="post" action="hakkimizda_duzenle.php">
    <div class="mb-3">
      <label for="baslik1">Başlık 1</label>
      <input type="text" name="baslik1" id="baslik1" required value="<?= htmlspecialchars($veri['baslik1']) ?>" />
    </div>

    <div class="mb-3">
      <label for="baslik2">Başlık 2</label>
      <input type="text" name="baslik2" id="baslik2" required value="<?= htmlspecialchars($veri['baslik2']) ?>" />
    </div>

    <div class="mb-3">
      <label for="aciklama">Açıklama</label>
      <textarea name="aciklama" id="aciklama" rows="4" required><?= htmlspecialchars($veri['aciklama']) ?></textarea>
    </div>

    <button type="submit" name="guncelle" class="btn-custom">Güncelle</button>
    <button type="submit" name="geri" class="btn btn-secondary">Geri Dön</button>
  </form>
</div>

<button id="theme-toggle" aria-label="Tema değiştir">
  <i class="fa-solid fa-moon"></i>
</button>

<script>
  const toggleButton = document.getElementById('theme-toggle');
  const icon = toggleButton.querySelector('i');
  const body = document.body;

  // Sayfa yüklendiğinde tema durumunu kontrol et
  const savedTheme = localStorage.getItem('theme') || 'light';
  if (savedTheme === 'dark') {
    body.classList.add('dark-mode');
    icon.classList.remove('fa-moon');
    icon.classList.add('fa-sun');
  }

  toggleButton.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    const isDark = body.classList.contains('dark-mode');

    if (isDark) {
      icon.classList.remove('fa-moon');
      icon.classList.add('fa-sun');
      localStorage.setItem('theme', 'dark');
    } else {
      icon.classList.remove('fa-sun');
      icon.classList.add('fa-moon');
      localStorage.setItem('theme', 'light');
    }
  });
</script>

</body>
</html>
