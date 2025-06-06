
<?php
include 'db.php';  // mysqli bağlantısı $baglanti değişkeninde

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $urunAdi = $_POST['productName'] ?? '';
    $aciklama = $_POST['productDesc'] ?? '';
    $fiyat = $_POST['productPrice'] ?? 0;
    $kategori = $_POST['productCategory'] ?? '';
    $gorselYolu = '';

    // Görsel yükleme işlemi
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === 0) {
        $hedefKlasor = "uploads/";
        if (!is_dir($hedefKlasor)) {
            mkdir($hedefKlasor, 0755, true);
        }

        $dosyaAdi = time() . "_" . basename($_FILES["productImage"]["name"]);
        $hedefYol = $hedefKlasor . $dosyaAdi;

        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $hedefYol)) {
            $gorselYolu = $hedefYol;
        } else {
            // Görsel yükleme başarısızsa yine yönlendiriyoruz
            header("Location: urunekle.php?durum=upload_error");
            exit;
        }
    } else {
        // Dosya seçilmemiş veya hata var ise
        header("Location: urunekle.php?durum=no_file");
        exit;
    }

    // Veritabanına kayıt (mysqli ile)
    $sorgu = "INSERT INTO urunler (urun_adi, aciklama, fiyat, kategori, gorsel) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($baglanti, $sorgu);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssdss", $urunAdi, $aciklama, $fiyat, $kategori, $gorselYolu);
        $calisti = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        if ($calisti) {
            header("Location: urunekle.php?durum=basarili");
            exit;
        } else {
            header("Location: urunekle.php?durum=db_error");
            exit;
        }
    } else {
        header("Location: urunekle.php?durum=stmt_error");
        exit;
    }
}
?>
