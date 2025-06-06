<?php
include 'db.php';

$mesaj = '';
$tur = '';
$hata = '';
$basarili = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isim = $_POST['isim'] ?? '';
    $unvan = $_POST['unvan'] ?? '';
    $github = $_POST['github_link'] ?? '';
    $instagram = $_POST['instagram_link'] ?? '';
    $img = '';

    // Görsel yükleme işlemi zorunlu
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $dosyaAdi = basename($_FILES['img']['name']);
        $hedefKlasor = 'uploads/';
        $hedefYol = $hedefKlasor . $dosyaAdi;

        if (!is_dir($hedefKlasor)) {
            mkdir($hedefKlasor, 0755, true);
        }

        if (move_uploaded_file($_FILES['img']['tmp_name'], $hedefYol)) {
            $img = $hedefYol;
        } else {
            $hata = "Görsel yüklenirken bir hata oluştu.";
        }
    } else {
        $hata = "Lütfen bir ürün görseli seçin.";
    }

    if (!$hata) {
        $stmt = $baglanti->prepare("INSERT INTO takim (isim, unvan, img, github_link, instagram_link) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $isim, $unvan, $img, $github, $instagram);
        if ($stmt->execute()) {
            $basarili = "Üye başarıyla eklendi.";
            // Formu temizlemek için değişkenleri boş yapabiliriz
            $isim = $unvan = $github = $instagram = '';
            $img = '';
        } else {
            $hata = "Ekleme sırasında hata oluştu: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    // İlk yüklemede boş değerler
    $isim = $unvan = $github = $instagram = '';
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title>Yeni Takım Üyesi Ekle</title>
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #121212;
    color: #eee;
    min-height: 100vh;
    padding: 40px 20px;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    transition: background-color 0.3s ease, color 0.3s ease;
}
body.light-mode {
    background-color: #f8f9fa;
    color: #333;
}
form {
    background: #1f1f1f;
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(255, 87, 34, 0.4);
    width: 100%;
    max-width: 500px;
    transition: background-color 0.3s ease, color 0.3s ease;
}
body.light-mode form {
    background-color: #fff;
    color: #333;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
    color: #ff5722;
    margin-bottom: 30px;
    font-weight: 700;
    font-size: 1.6rem;
}
body.light-mode h2 {
    color: #e76f51;
}
label {
    display: block;
    margin-top: 20px;
    font-weight: 600;
    color: #ccc;
    font-size: 0.95rem;
}
body.light-mode label {
    color: #555;
}
input[type=text], input[type=file], textarea {
    width: 100%;
    padding: 12px 14px;
    margin-top: 8px;
    border-radius: 8px;
    border: 1px solid #444;
    background-color: #2a2a2a;
    color: #eee;
    font-size: 1rem;
    transition: border-color 0.3s ease, background-color 0.3s ease, color 0.3s ease;
    resize: vertical;
    box-sizing: border-box;
}
body.light-mode input[type=text], 
body.light-mode input[type=file], 
body.light-mode textarea {
    background-color: #fff;
    color: #333;
    border: 1.5px solid #ccc;
}
input:focus, textarea:focus {
    outline: none;
    border-color: #ff5722;
    background-color: #3a3a3a;
}
body.light-mode input:focus, body.light-mode textarea:focus {
    border-color: #e76f51;
    background-color: #fff;
    color: #333;
}
.buttons {
    margin-top: 30px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
button, .back-button {
    flex: 1;
    padding: 12px 20px;
    font-weight: 600;
    font-size: 1rem;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    color: white;
    text-decoration: none;
    text-align: center;
    display: inline-block;
}
button {
    background-color: #ff5722;
}
button:hover {
    background-color: #e64a19;
}
.back-button {
    background-color: #555;
}
.back-button:hover {
    background-color: #444;
}
body.light-mode button, 
body.light-mode .back-button {
    background-color: #e76f51;
    color: white;
}
body.light-mode button:hover, 
body.light-mode .back-button:hover {
    background-color: #c6533f;
}
.message {
    margin-top: 20px;
    padding: 12px 15px;
    border-radius: 8px;
    font-weight: 600;
    text-align: center;
    font-size: 0.95rem;
}
.error {
    background-color: #a94442;
    color: #fff;
}
.success {
    background-color: #4caf50;
    color: #fff;
}
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

<form method="post" enctype="multipart/form-data">
    <h2>Yeni Takım Üyesi Ekle</h2>

    <?php if ($hata): ?>
        <div class="message error"><?= htmlspecialchars($hata) ?></div>
    <?php endif; ?>

    <?php if ($basarili): ?>
        <div class="message success"><?= htmlspecialchars($basarili) ?></div>
    <?php endif; ?>

    <label for="isim">İsim:</label>
    <input type="text" id="isim" name="isim" required value="<?= htmlspecialchars($isim) ?>" autocomplete="off">

    <label for="unvan">Ünvan:</label>
    <input type="text" id="unvan" name="unvan" required value="<?= htmlspecialchars($unvan) ?>" autocomplete="off">

    <label for="img">Ürün Görseli (Zorunlu):</label>
    <input type="file" id="img" name="img" required accept="image/*">

    <label for="github_link">GitHub Linki:</label>
    <input type="text" id="github_link" name="github_link" value="<?= htmlspecialchars($github) ?>" autocomplete="off">

    <label for="instagram_link">Instagram Linki:</label>
    <input type="text" id="instagram_link" name="instagram_link" value="<?= htmlspecialchars($instagram) ?>" autocomplete="off">

    <div class="buttons">
        <a href="index.php#team" class="back-button">Home</a>
        <button type="submit">Ekle</button>
        <a href="urun.php" class="back-button">Geri Dön</a>
    </div>
</form>

<button id="theme-toggle" aria-label="Tema değiştir">
    <i id="themeIcon" class="fa-solid fa-moon"></i>
</button>

<script>
function toggleTheme() {
    document.body.classList.toggle('light-mode');
    let isLight = document.body.classList.contains('light-mode');
    localStorage.setItem('theme', isLight ? 'light' : 'dark');
    updateIcon(isLight);
}
function updateIcon(isLight) {
    const icon = document.getElementById('themeIcon');
    if (isLight) {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
    } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
    }
}
window.onload = () => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        updateIcon(true);
    } else {
        updateIcon(false);
    }
    document.getElementById('theme-toggle').addEventListener('click', toggleTheme);

    const successMsg = document.querySelector('.message.success');
    if(successMsg){
        setTimeout(() => {
            successMsg.style.opacity = '0';
            setTimeout(() => successMsg.style.display = 'none', 500);
        }, 2000);
    }
};
</script>

</body>
</html>
