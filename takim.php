<?php
include 'db.php';

// Mesaj durumları
$durum = $_GET['durum'] ?? '';
$mesaj = '';
$tur = '';

switch ($durum) {
    case 'guncellendi':
        $mesaj = "Ürün başarıyla güncellendi.";
        $tur = "success";
        break;
    case 'silindi':
        $mesaj = "Ürün başarıyla silindi.";
        $tur = "success";
        break;
    case 'silme_hatasi':
        $mesaj = "Silme işlemi başarısız.";
        $tur = "error";
        break;
}

// Silme işlemi
if (isset($_GET['sil'])) {
    $id = (int)$_GET['sil'];
    $stmt = $baglanti->prepare("DELETE FROM takim WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: takim.php?durum=silindi");
        exit;
    } else {
        header("Location: takim.php?durum=silme_hatasi");
        exit;
    }
}

// Üyeleri çek
$query = "SELECT * FROM takim ORDER BY id DESC";
$result = $baglanti->query($query);
$products = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<title>Takım Listesi</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
    .btn-group {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
  }
  .btn {
    border: none;
    background-color: #3b82f6; /* Güncelle butonu rengi: Mavi */
    color: white;
    cursor: pointer;
    font-size: 14px;          /* Küçültüldü */
    padding: 6px 10px;        /* Daha dar ve alçak */
    border-radius: 4px;       /* Hafif yuvarlak */
    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  .btn:hover {
    background-color:rgb(37, 199, 235);
    transform: scale(1.05);
  }

  .btn.sil {
    background-color:#2563eb; /* Sil butonu rengi: Kırmızı */
  }

  .btn.sil:hover {
    background-color:rgba(146, 94, 75, 0.64);
  }

  .btn.guncelle {
    background-color:#2563eb; /* Güncelle butonu rengi: Yeşil */
  }

  .btn.guncelle:hover {
    background-color:rgba(146, 94, 75, 0.64);
  }

  
  .mesaj-kutusu {
    padding: 12px 20px;
    border-radius: 6px;
    margin-bottom: 20px;
    width: fit-content;
    max-width: 90%;
    font-weight: bold;
    margin-left: auto;
    margin-right: auto;
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

  .container {
    text-align: center;
    margin-bottom: 20px;
  }

  .btn-ekle {
    background-color: #2563eb;
    color: white;
    padding: 12px 25px;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 16px;
    display: inline-block;
    transition: background-color 0.3s ease;
  }

  .btn-ekle:hover {
    background-color: #1e40af;
  }

  .kutular-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin: 0 auto;
  max-width: 1200px;
  justify-content: center;
  min-height: 300px; /* Bunu ekle */
}
  .kutu {
    width: 280px;
    height: 320px;
    background: rgba(30, 58, 138, 0.9); /* Lacivert */
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(255, 127, 80, 0.25); /* Hafif turuncu gölge */
    text-align: center;
    padding: 20px 15px;
    box-sizing: border-box;
    position: relative;
    color: #e0e7ff;
    transition: background-color 0.3s ease, box-shadow 0.3s ease, color 0.3s ease;
    cursor: default;
  }

  .kutu:hover {
    background-color: rgb(66, 121, 209); /* Açık mavi */
    box-shadow: 0 10px 30px rgba(255, 127, 80, 0.4);
    color: #fff;
    cursor: pointer;
  }

  .profil-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  }

  .category {
    font-weight: 700;
    color: #a5b4fc;
    margin-bottom: 8px;
    display: block;
    font-size: 14px;
    letter-spacing: 1px;
  }

  h4 {
    margin: 0 0 15px 0;
    font-size: 20px;
    color: #bfdbfe;
  }

  .social-icons {
    list-style: none;
    padding: 0;
    margin: 0 0 15px 0;
  }

  .social-icons li {
    display: inline-block;
    margin: 0 8px;
  }

  .social-icons a {
    color:rgb(16, 191, 239); /* Lacivert */
    font-size: 22px;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .social-icons a:hover {
    color: #ff7f50; /* Turuncu */
  }

  .btn-group {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
  }

  .btn {
    border: none;
    background: transparent;
    cursor: pointer;
    font-size: 22px;
    margin: 0 8px;
    color:rgba(30, 59, 138, 0.8); /* Lacivert */
    transition: color 0.3s ease;
  }

  .btn:hover {
    color: #ff7f50; /* Turuncu hover */
  }

  .btn.sil:hover {
    color: #f87171; /* Kırmızımsı hover */
  }

  #bos-mesaj {
  font-size: 18px;
  color: #888;
  margin-top: 40px;
  margin-bottom: 40px;
  text-align: center;
}

  @media (max-width: 900px) {
    .kutular-container {
      justify-content: center;
    }

    .kutu {
      width: 90%;
      height: auto;
    }
  }
  html{
  height: 100%;
  margin: 0;
  padding: 0;
}
</style>



</head>
<body>

<div class="row">
      <div class="col-lg-12 text-center" id="team">
        <div class="section-heading">
          <h6 style="font-size: 36px;">Team</h6>
        </div>
      </div>
    </div>
<?php if ($mesaj): ?>
  <div class="mesaj-kutusu <?= $tur ?>">
    <?= htmlspecialchars($mesaj) ?>
  </div>
<?php endif; ?>

<?php if (count($products) === 0): ?>
  <p id="bos-mesaj" style="color: #2563eb;">Henüz kayıtlı takım üyesi yok.</p>
<?php else: ?>
  <div class="kutular-container" id="kutular-container">
    <?php foreach ($products as $item): ?>
      <div class="kutu" data-id="<?= $item['id'] ?>">
        <?php if (!empty($item['img'])): ?>
          <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['isim']) ?>" class="profil-img" />
        <?php else: ?>
          <img src="assets/images/default-profile.png" alt="Profil Resmi Yok" class="profil-img" />
        <?php endif; ?>
        <span class="category"><?= htmlspecialchars($item['unvan']) ?></span>
        <h4><?= htmlspecialchars($item['isim']) ?></h4>
        <ul class="social-icons">
          <?php if (!empty($item['github_link'])): ?>
            <li><a href="<?= htmlspecialchars($item['github_link']) ?>" target="_blank" title="GitHub"><i class="fa-brands fa-github"></i></a></li>
          <?php endif; ?>
          <?php if (!empty($item['instagram_link'])): ?>
            <li><a href="<?= htmlspecialchars($item['instagram_link']) ?>" target="_blank" title="Instagram"><i class="fa-brands fa-instagram"></i></a></li>
          <?php endif; ?>
        </ul>
        <div class="btn-group">
          <form action="guncelle.php" method="get" style="display:inline;">
            <input type="hidden" name="id" value="<?= $item['id'] ?>" />
            <button type="submit" class="btn guncelle" title="Güncelle"><i class="fa-solid fa-pen-to-square"></i></button>
          </form>
          <button class="btn sil" title="Sil" onclick="silUye(<?= $item['id'] ?>, this)"><i class="fa-solid fa-trash"></i></button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<script>
  // Flex kutular-container'ın justify-content ayarını kontrol eden fonksiyon
  function ayarlaKutularContainer() {
    const container = document.getElementById('kutular-container');
    if (!container) return;

    const kutuSayisi = container.children.length;
    if (kutuSayisi === 1) {
      container.style.justifyContent = 'center';
    } else {
      container.style.justifyContent = 'flex-start';
    }
  }

  // Sayfa yüklendiğinde çalıştır
  window.addEventListener('DOMContentLoaded', ayarlaKutularContainer);

  function silUye(id, btn) {
    if (!confirm("Silmek istediğinize emin misiniz?")) return;

    fetch("sil_ajax.php", {
      method: "POST",
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `id=${id}`
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const kutu = btn.closest('.kutu');
        kutu.remove();

        // Kutular container'ı güncelle
        ayarlaKutularContainer();

        if (document.querySelectorAll('.kutu').length === 0) {
          const bosMesaj = document.createElement('p');
          bosMesaj.id = 'bos-mesaj';
         
          bosMesaj.style.textAlign = 'center';
          document.body.appendChild(bosMesaj);
        }

        mesajGoster("Üye başarıyla silindi.", "success");
      } else {
        mesajGoster("Silme başarısız: " + (data.hata || "Bilinmeyen hata"), "error");
      }
    })
    .catch(() => {
      mesajGoster("Silme işlemi sırasında bir hata oluştu.", "error");
    });
  }

  function mesajGoster(mesaj, tur) {
    let kutu = document.querySelector('.mesaj-kutusu');
    if (!kutu) {
      kutu = document.createElement('div');
      kutu.classList.add('mesaj-kutusu');
      document.body.insertBefore(kutu, document.body.firstChild);
    }
    kutu.textContent = mesaj;
    kutu.className = 'mesaj-kutusu ' + tur;

    setTimeout(() => {
      kutu.textContent = '';
      kutu.className = 'mesaj-kutusu';
    }, 4000);
  }
</script>

</body>
</html>

