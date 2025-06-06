
<?php
include 'db.php';

// Hakkımızda verisini çek
$sonuc = $baglanti->query("SELECT * FROM hakkimizda WHERE id=1");
$veri = $sonuc->fetch_assoc();
if (!$veri) {
    $veri = ['baslik1' => '', 'baslik2' => '', 'aciklama' => 'Veri bulunamadı.'];
}

// Referans (testimonial başlık) verisini çek
$referans_sonuc = $baglanti->query("SELECT * FROM reference_content WHERE id=1");
$referans_veri = $referans_sonuc->fetch_assoc();
if (!$referans_veri) {
    $referans_veri = ['title1' => '', 'title2' => '', 'paragraph' => 'Referans verisi bulunamadı.'];
}
?>
<!DOCTYPE html>
<html lang="tr">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>İnşaat Sitesi</title>

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
        background-color:rgb(32, 30, 30) !important;
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
        background-color: #1e1e1e !important;
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
    </style>
  </head>


<body>

  <!-- ***** Preloader Start ***** -->
  <!-- <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div> -->
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container header-text">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav ">
                    <!-- ***** Logo Start ***** -->
                   
                    <!-- ***** Serach Start ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                      <li class="scroll-to-section" ><a href="/insaat/index.php" class="active" style="color: black;">Home</a></li>
                      
                      <li class="scroll-to-section"><a href="#hakkimizda"  style="color: black;">About Us</a></li>
                      <li class="scroll-to-section"><a href="#products"  style="color: black;">Products</a></li>
                      <li class="scroll-to-section"><a href="#team"  style="color: black;">Team</a></li>
                      <li class="scroll-to-section"><a href="#referanslar"  style="color: black;">Reference</a></li>
                     
                    
                      <li class="scroll-to-section"><a href="urun.php">Admin</a></li>
                     
                  
                   
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

  <div class="main-banner" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-banner">
            <div class="item item-1">
              <div class="header-text">
            
                <h2>Projeleriniz İçin En Güvenilir Çözüm Ortağınız</h2>
                <p>İster küçük ölçekli konut, ister büyük çaplı ticari yapılar olsun, uzman kadromuz ve güçlü teknik altyapımızla her türlü projeyi titizlikle planlıyor ve hayata geçiriyoruz. Sürecin her adımında şeffaflık, kalite ve zamanında teslim önceliğimizdir.

                </p>
                <div class="buttons">
                  <div class="main-button">
                    
                  </div>
                  <div class="icon-button">
                    
                  </div>
                </div>
              </div>
            </div>
            <div class="item item-2">
              <div class="header-text">
          
                <h2>Estetik ve Kaliteyi Bir Araya Getiriyoruz</h2>
                <p>Yaşam ve çalışma alanlarınızı sadece güzelleştirmekle kalmıyor; aynı zamanda size özel çözümlerle daha işlevsel hale getiriyoruz. Profesyonel iç mimarlık hizmetimiz ile tarzınızı yansıtan modern, yenilikçi ve kullanıcı dostu ortamlar oluşturuyoruz.

                </p>
                <div class="buttons">
                  <div class="main-button">
                  
                  </div>
                  <div class="icon-button">
                   
                  </div>
                </div>
              </div>
            </div>
            <div class="item item-3">
              <div class="header-text">
            
                <h2>Profesyonel Ekip, Kusursuz Yönetim</h2>
                <p>Sadece tasarlamakla kalmıyor; projelerinizi etkin bir şekilde yönetiyor, kaynakları doğru planlıyor ve olası riskleri minimize ediyoruz. Planlama, uygulama ve teslim süreçlerinde çözüm odaklı yaklaşımımızla işlerinizi zamanında ve eksiksiz tamamlıyoruz.</p>
                <div class="buttons">
                  <div class="main-button">
                   
                  </div>
                  <div class="icon-button">
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
 <div class="section about-us">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-1">
        <div class="accordion" id="accordionExample">
          
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Ürünleriniz nerede üretiliyor?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Tüm inşaat malzemelerimiz Türkiye’de alanında uzman üreticiler tarafından üretilmekte ve kalite kontrolleri sağlandıktan sonra satışa sunulmaktadır.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Sipariş süreci nasıl işliyor?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Ürün seçildikten sonra kolay sipariş sistemiyle işleminizi tamamlayabilirsiniz. Teslimat süresi genellikle 1-3 iş günüdür.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Ürünler garantili mi?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                Tüm ürünlerimiz üretici firmaların garantisi altındadır. Her ürün detay sayfasında garanti süresi açıkça belirtilmektedir.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Hangi ürün gruplarını sunuyorsunuz?
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                İnşaat demiri, demir, çelik profil, kereste, tuğla, PVC boru, polikarbon levhalar gibi birçok ürünü tek çatı altında sunuyoruz.
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-5 align-self-center">
        <div class="section-heading" id="hakkimizda">
        <h4 style="color: #e76f51;"><?= htmlspecialchars($veri['baslik1']) ?></h4>
    <h2 style="color:#ffb347;"><?= htmlspecialchars($veri['baslik2']) ?></h2>
    <p><?= nl2br(htmlspecialchars($veri['aciklama'])) ?></p>
        <div class="main-button">
           
            
            <a href="hakkimizda_duzenle.php"> Güncelle</a>
          </div>
        </div>
      </div>  
      </div>
      
      
     
    </div>
  </div>
</div>


      <?php include 'gorseller.php'; ?>
      <?php include 'takim.php';?>
      <div class="section testimonials">
      
    <div class="container">

      <div class="row">
        <div class="col-lg-7">
      
          <div class="owl-carousel owl-testimonials">
            <div class="item">
              <p>Şantiyedeki tüm süreçlerin koordinasyonundan, ekip yönetimine ve işin zamanında tamamlanmasına kadar her aşamayı takip ediyorum. Her birimle iletişim içinde olarak projenin sorunsuz ilerlemesini sağlamak benim temel görevim.</p>
              <div class="author">
                <img src="assets/images/testimonial-author.jpg" alt="">
                <span class="category">Proje Müdürü</span>
                <h4>Süleyman YILDIRIM</h4>  
              </div>
            </div>
            <div class="item">
            <p>İşçilerin günlük görevlerini organize ediyor, malzeme ve iş güvenliği kontrollerini yapıyorum. Şantiye şefinin sağ kolu olarak, işlerin düzenli ve güvenli ilerlemesini sağlamak benim işim.</p>

              <div class="author">
                <img src="assets/images/member-02.jpg" alt="">
                <span class="category">Usta Başçavuş</span>
                <h4>Ömer ÜREN</h4>
              </div>
            </div>
  
            <div class="item">
            <p>Mimari ve statik projelerin çizimlerini yapıyor, ölçülendirme ve planlama çalışmalarında mühendislerle birlikte çalışıyorum. Proje ruhsatları için gerekli teknik dokümanları hazırlayarak sürecin yasal olarak ilerlemesini sağlıyorum.</p>

              <div class="author">
                <img src="assets/images/member-04.jpg" alt="">
                <span class="category">Teknik Ressam</span>
                <h4>Talha ÖZBEK</h4>
              </div>
            </div>
  
            <div class="item">
            <p>Ben, bir inşaat projesinin sahadaki uygulamasından sorumlu teknik uzmanım. Şantiyede işlerin planlanan şekilde, zamanında ve güvenli bir şekilde ilerlemesini sağlamak benim görevim. </p>

              <div class="author">
                <img src="assets/images/member-01.jpg" alt="">
                <span class="category">Şantiye Şefi</span>
                <h4>İbrahim PARLAK</h4>
              </div>
            </div>
  
          </div>
          
        </div>
        
        <div class="col-lg-5 align-self-center">
  <div class="section-heading" id="referanslar">
    <h4 style="color: #e76f51;"><?= htmlspecialchars($referans_veri['title1']) ?></h4>
    <h2 style="color:#ffb347;"><?= htmlspecialchars($referans_veri['title2']) ?></h2>
    <p style="color:#ffb347;"><?= nl2br(htmlspecialchars($referans_veri['paragraph'])) ?></p>
    <div class="main-button">
           
            <p><a href="reference_duzenle.php"> Güncelle</a></p>
           
         </div>
  </div>
</div>
          
        </div>
      </div>
    </div>
  </div>
  

    
    
  </div>
</div>
  
  
 
        
  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p> İbrahim PARLAK - Tüm Hakları Saklıdır !
      
      </p>
      <ul class="social-icons">
          <?php if (!empty($item['github_link'])): ?>
            <li><a href="<?= htmlspecialchars($item['github_link']) ?>" target="_blank" title="GitHub"><i class="fa-brands fa-github"></i></a></li>
          <?php endif; ?>
          <?php if (!empty($item['instagram_link'])): ?>
            <li><a href="<?= htmlspecialchars($item['instagram_link']) ?>" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </footer>

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