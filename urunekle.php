<?php
// Durum bilgisini al
$durum = $_GET['durum'] ?? '';

$mesaj = '';
$tur = ''; // success, error vb.

switch ($durum) {
    case 'basarili':
        $mesaj = "Ürün başarıyla eklendi.";
        $tur = "success";
        break;
    case 'upload_error':
        $mesaj = "Görsel yüklenirken hata oluştu.";
        $tur = "error";
        break;
    case 'db_error':
        $mesaj = "Veritabanına kayıtta hata oluştu.";
        $tur = "error";
        break;
    case 'stmt_error':
        $mesaj = "Veritabanı sorgusu hazırlanamadı.";
        $tur = "error";
        break;
    case 'no_file':
        $mesaj = "Lütfen bir ürün görseli seçin.";
        $tur = "error";
        break;
    default:
        $mesaj = '';
        $tur = '';
        break;
}
?>

<!DOCTYPE html>
<html lang="tr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Ürün Ekleme</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-scholar.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    
    <style>
      /* Karanlık mod için basit stiller */
      body.dark-mode {
        background-color: #121212 !important;
        color: #e0e0e0 !important;
        transition: background-color 0.3s ease, color 0.3s ease;
      }

      /* Karşıt renk uyumu için linkler */
      body.dark-mode a,
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

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky" style="background-color:white">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                   
                    <!-- ***** Serach Start ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                    <li class="scroll-to-section"><a href="/insaat/index.php">Home</a></li>
                    <li class="scroll-to-section"><a href="/insaat/urun.php">Products</a></li>
                     
                  
                   
                  </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

 <?php if ($mesaj): ?>
    <div id="notification" class="notification <?php echo $tur; ?>">
        <?php echo htmlspecialchars($mesaj); ?>
    </div>

    <script>
        // 30 saniye (30000 ms) sonra bildirimi gizle
        setTimeout(function() {
            var notif = document.getElementById('notification');
            if (notif) {
                notif.style.transition = "opacity 1s ease";
                notif.style.opacity = "0";
                // 1 saniye sonra tamamen kaldır
                setTimeout(function() {
                    notif.style.display = "none";
                }, 1000);
            }
        }, 3000);
    </script>
<?php endif; ?>

<div class="header-text">
</div>

  <!-- Content -->
  <div class="container-form">
    <h2>Ürün Ekle</h2>
    <form action="urun_ekle.php" method="POST" enctype="multipart/form-data">
      <label for="productName">Ürün Adı</label>
      <input type="text" id="productName" name="productName" required>

      <label for="productDesc">Açıklama</label>
      <textarea id="productDesc" name="productDesc" rows="4" required></textarea>

      <label for="productPrice">Fiyat (₺)</label>
      <input type="number" id="productPrice" name="productPrice" step="0.01" min="0" required>

      <label for="productCategory">Kategori</label>
      <select id="productCategory" name="productCategory" required>
        <option value="">Kategori Seçin</option>
        <option value="Duvar">Duvar Malzemeleri</option>
        <option value="Metal">Metal Malzemeler</option>
        <option value="Ahsap">Ahsap Malzemeler</option>
        <option value="Plastik">Plastik ve Sentetik Malzemeler</option>
      </select>

      <label for="productImage">Ürün Görseli</label>
      <input type="file" id="productImage" name="productImage" accept="image/*" required>

      <button class="button-form" type="submit">Ürünü Ekle</button>
    </form>
  </div>



  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
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
