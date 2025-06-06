<?php
// Veritabanı bağlantısı
if (!isset($baglanti)) {
    include 'db.php';
}

// Ürünleri çek
$query = "SELECT * FROM urunler ORDER BY id DESC";
$result = $baglanti->query($query);
$products = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Kategori listesini oluştur
$categories = [];
foreach ($products as $p) {
    if (!in_array($p['kategori'], $categories)) {
        $categories[] = $p['kategori'];
    }
}
?>

<section class="section products" id="products">
  <div class="container">

    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="section-heading">
          <h6 style="font-size: 36px;">Products</h6>
        </div>
      </div>
    </div>

    <!-- Filtreler -->
    <ul class="event_filter">
      <li><a href="#!" class="is_active" data-filter="*">Tüm Kategoriler</a></li>
      <?php foreach ($categories as $cat): ?>
        <li><a href="#!" data-filter=".<?= htmlspecialchars(str_replace(' ', '-', strtolower($cat))) ?>"><?= htmlspecialchars($cat) ?> Malzemeleri </a></li>
      <?php endforeach; ?>
    </ul>

    <div class="row event_box">
      <?php foreach ($products as $product): ?>
        <?php 
          $categoryClass = str_replace(' ', '-', strtolower($product['kategori'])); 
        ?>
        <div class="col-lg-4 col-md-6 align-self-center mb-30 event_outer <?= htmlspecialchars($categoryClass) ?>">
          <div class="events_item">
            <div class="thumb" style="position: relative;">
              <a href="#">
                <img src="<?= htmlspecialchars($product['gorsel']) ?>" alt="<?= htmlspecialchars($product['urun_adi']) ?>" />
              </a>
              <span class="category"><?= htmlspecialchars($product['kategori']) ?></span>
              <span class="price"><h6 style="font-size: 16px;"><em>₺</em> <?= htmlspecialchars($product['fiyat']) ?></h6></span>
            </div>
            <div class="down-content">
              <span class="author"><?= htmlspecialchars($product['urun_adi']) ?></span>
              <h4><?= htmlspecialchars($product['aciklama']) ?></h4>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const filterLinks = document.querySelectorAll('.event_filter a');
    const items = document.querySelectorAll('.event_box .event_outer');

    filterLinks.forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();

        filterLinks.forEach(l => l.classList.remove('is_active'));
        this.classList.add('is_active');

        const filter = this.getAttribute('data-filter');

        items.forEach(item => {
          if (filter === '*') {
            item.style.display = '';
          } else {
            const filterClass = filter.slice(1).toLowerCase();
            if (item.classList.contains(filterClass)) {
              item.style.display = '';
            } else {
              item.style.display = 'none';
            }
          }
        });
      });
    });
  });
</script>
