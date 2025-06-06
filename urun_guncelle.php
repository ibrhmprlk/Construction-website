<?php
include 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: urun.php");
    exit;
}

// Ürün bilgileri çek
$stmt = $baglanti->prepare("SELECT * FROM urunler WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$urun = $result->fetch_assoc();
$stmt->close();

if (!$urun) {
    header("Location: urun.php");
    exit;
}

$hataMesaji = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $urunAdi = $_POST['urun_adi'] ?? '';
    $aciklama = $_POST['aciklama'] ?? '';
    $fiyat = $_POST['fiyat'] ?? 0;
    $kategori = $_POST['kategori'] ?? '';
    $gorselYolu = $urun['gorsel'];

    // Görsel yüklenmişse
    if (isset($_FILES['gorsel']) && $_FILES['gorsel']['error'] === 0) {
        $hedefKlasor = "uploads/";
        if (!is_dir($hedefKlasor)) mkdir($hedefKlasor, 0755, true);

        $dosyaAdi = time() . "_" . basename($_FILES['gorsel']['name']);
        $hedefYol = $hedefKlasor . $dosyaAdi;

        if (move_uploaded_file($_FILES['gorsel']['tmp_name'], $hedefYol)) {
            $gorselYolu = $hedefYol;
        } else {
            $hataMesaji = "Görsel yüklenemedi.";
        }
    }

    if (!$hataMesaji) {
        $stmt = $baglanti->prepare("UPDATE urunler SET urun_adi=?, aciklama=?, fiyat=?, kategori=?, gorsel=? WHERE id=?");
        $stmt->bind_param("ssdssi", $urunAdi, $aciklama, $fiyat, $kategori, $gorselYolu, $id);
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: urun.php?durum=guncellendi");
            exit;
        } else {
            $hataMesaji = "Güncelleme sırasında hata oluştu.";
            $stmt->close();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="utf-8" />
  <title>Ürün Güncelle</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-scholar.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    
  <style>
  body {
    background-color: #f8f9fa;
    font-family: "Segoe UI", sans-serif;
  }

  h2 {
    font-weight: bold;
    color: #343a40;
  }

  form {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  }

  .form-label {
    font-weight: 600;
    color: #495057;
  }

  .form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
  }

  .form-control:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
  }

  .btn-success {
    background-color: #198754;
    border: none;
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 8px;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  .btn-success:hover {
    background-color: #157347;
    transform: translateY(-2px);
  }

  .btn-secondary {
    background-color: #6c757d;
    border: none;
    padding: 10px 20px;
    font-weight: 500;
    border-radius: 8px;
    margin-left: 10px;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  .btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
  }

  img {
    border: 1px solid #dee2e6;
    padding: 4px;
    background-color: #fff;
  }

  .alert-danger {
    font-weight: 500;
    border-radius: 8px;
    box-shadow: 0 0 6px rgba(220, 53, 69, 0.15);
  }

  .mb-3 label::after {
    content: " *";
    color: red;
  }
  body.dark-mode {
        background-color: #121212 !important;
        color: #e0e0e0 !important;
        transition: background-color 0.3s ease, color 0.3s ease;
      }

      /* Karşıt renk uyumu için linkler */
      body.dark-mode a,
      body.dark-mode h2,
      body.dark-mode .nav a,
      body.dark-mode .category,
      body.dark-mode .price h6,
      body.dark-mode footer {
        color: #90caf9 !important;
      }

      /* Karanlık modda header arka plan */
      body.dark-mode header.header-area {
        background-color:#121212 !important;
      }

      /* Örnek, ürün kutularının arka planlarını koyulaştır */
      body.dark-mode .events_item {
        background-color: #222 !important;
        border-color: #444 !important;
      }

      /* Buton görünümü */
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

    /* Form kapsayıcı */
    .container-form {
      max-width: 500px;
      background-color: #fff;
      margin: 50px auto;
      padding: 30px;
      margin-top: 120px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    /* Form etiketleri ve girdileri */
    label {
      display: block;
      margin-bottom: 5px;
      color: #555;
      font-weight: 600;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    select,
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
      font-size: 14px;
    }

    /* Buton */
    .button-form {
      background-color: #121212;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .button-form:hover {
      background-color: #434343;
    }
    .notification {
        max-width: 500px;
        margin: 100px auto;
        padding: 15px;
        border-radius: 5px;
        font-weight: bold;
        text-align: center;
        border-radius: 20px;
         margin-bottom: -100px;
    }
    .success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

</style>

  
</head>

<body class="container py-5">

<h2 class="mb-4 text-center">Ürün Güncelle</h2>

<?php if ($hataMesaji): ?>
<div class="alert alert-danger" role="alert">
  <?php echo htmlspecialchars($hataMesaji); ?>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 600px;">
  <div class="mb-3">
    <label for="urun_adi" class="form-label">Ürün Adı</label>
    <input type="text" class="form-control" id="urun_adi" name="urun_adi" required value="<?php echo htmlspecialchars($urun['urun_adi']); ?>">
  </div>

  <div class="mb-3">
    <label for="aciklama" class="form-label">Açıklama</label>
    <textarea class="form-control" id="aciklama" name="aciklama" rows="3" required><?php echo htmlspecialchars($urun['aciklama']); ?></textarea>
  </div>

  <div class="mb-3">
    <label for="fiyat" class="form-label">Fiyat (₺)</label>
    <input type="number" step="0.01" class="form-control" id="fiyat" name="fiyat" required value="<?php echo htmlspecialchars($urun['fiyat']); ?>">
  </div>

  <div class="mb-3">
    <label for="kategori" class="form-label">Kategori</label>
    <input type="text" class="form-control" id="kategori" name="kategori" required value="<?php echo htmlspecialchars($urun['kategori']); ?>">
  </div>

  <div class="mb-3">
    <label for="gorsel" class="form-label">Görsel (varsa yenisi ile değiştirmek için)</label>
    <input class="form-control" type="file" id="gorsel" name="gorsel" accept="image/*">
  </div>

  <?php if ($urun['gorsel']): ?>
    <div class="mb-3">
      <p>Mevcut Görsel:</p>
      <img src="<?php echo htmlspecialchars($urun['gorsel']); ?>" alt="Ürün Görseli" style="max-width:150px; border-radius: 6px;">
    </div>
  <?php endif; ?>

  <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Güncelle</button>
  <a href="urun.php" class="btn btn-secondary">Geri Dön</a>
</form>
<script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>

  <button id="theme-toggle">
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
