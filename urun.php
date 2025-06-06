<?php
// Durum bilgisini al
$durum = $_GET['durum'] ?? '';

$mesaj = '';
$tur = ''; // success, error vb.

switch ($durum) {
    case 'guncellendi':
        $mesaj = "Ürün başarıyla guncellendi.";
        $tur = "success";
        break;
    case 'silindi':
        $mesaj = "Ürün başarıyla silindi.";
        $tur = "success";
        break;
    case 'silme_hatasi':
        $mesaj = "Lütfen bir ürün görseli seçin.";
        $tur = "error";
        break;
    default:
        $mesaj = '';
        $tur = '';
        break;
}
?>
<?php
include 'db.php'; 

// Silme işlemi varsa
if (isset($_GET['sil'])) {
    $id = (int)$_GET['sil'];
    $stmt = $baglanti->prepare("DELETE FROM urunler WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: urun.php?durum=silindi");
        exit;
    } else {
        header("Location: urun.php?durum=silme_hatasi");
        exit;
    }
}

// Ürünleri çek
$result = $baglanti->query("SELECT * FROM urunler ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
   
  <title>Ürünler</title>

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
    <link rel="stylesheet" href="assets/css/flex-slider.css">
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
      body.dark-mode p,
      body.dark-mode footer {
        color: #90caf9 !important;
      }

      /* Karanlık modda header arka plan */
      body.dark-mode header.header-area {
        background-color: #121212!important;
      }

      /* Örnek, ürün kutularının arka planlarını koyulaştır */
      body.dark-mode .events_item {
        background-color: #222 !important;
        border-color: #444 !important;
      }

      /* Buton görünümü */
      #theme-toggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
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

    .notification {
      max-width: 600px;
      margin: 100px auto;
      padding: 15px;
      border-radius: 6px;
      font-weight: 600;
      text-align: center;
      margin-bottom: -150px;
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

    .product-img {
      max-width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 6px;
    }

    .card-footer a {
      width: 48%;
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
  <header class="header-area header-sticky" style="background-color: white;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                   
                    <!-- ***** Serach Start ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                      <li class="scroll-to-section"><a href="/insaat/index.php">Home</a></li>
                      <li class="scroll-to-section"><a href="/insaat/urunekle.php">Add Products</a></li>
                      <li class="scroll-to-section"><a href="ekle.php">Add Member</a></li>
                      <div class="container">

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


  <section class="section courses" id="courses">
    <div class="container">
      <div class="row event_box">

        <?php if ($result && $result->num_rows > 0) : ?>
          <?php while ($urun = $result->fetch_assoc()) : ?>
            <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 design">
              <div class="events_item">
                <div class="thumb">
                  <?php if (!empty($urun['gorsel'])) : ?>
                    <a href="#"><img src="<?php echo htmlspecialchars($urun['gorsel']); ?>" alt="Ürün Görseli" class="product-img"></a>
                  <?php else : ?>
                    <a href="#"><img src="assets/images/no-image.png" alt="Görsel Yok" class="product-img"></a>
                  <?php endif; ?>
                  <span class="category"><?php echo htmlspecialchars($urun['kategori']); ?></span>
                  <span class="price"><h6 style="font-size: 16px;"><em>₺</em><?php echo number_format($urun['fiyat'], 2); ?></h6></span>
                </div>
                <div class="down-content">
                  <span class="author"><?php echo htmlspecialchars($urun['urun_adi']); ?></span>
                  <h4><?php echo htmlspecialchars($urun['aciklama']); ?></h4>
                </div>
                <div class="card-footer d-flex justify-content-between p-2">
                  <a href="urun_guncelle.php?id=<?php echo $urun['id']; ?>" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Güncelle
                  </a>
                  <a href="urun.php?sil=<?php echo $urun['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu ürünü silmek istediğinize emin misiniz?');">
                    <i class="fa fa-trash"></i> Sil
                  </a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else : ?>
          <p class="text-center">Henüz ürün yok.</p>
        <?php endif; ?>

      </div>
    </div>
  </section>



  <!-- Scripts -->
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
