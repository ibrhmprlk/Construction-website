<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title1 = $_POST['title1'] ?? '';
    $title2 = $_POST['title2'] ?? '';
    $paragraph = $_POST['paragraph'] ?? '';

    $stmt = $baglanti->prepare("UPDATE reference_content SET title1=?, title2=?, paragraph=? WHERE id=1");
    $stmt->bind_param("sss", $title1, $title2, $paragraph);

    if ($stmt->execute()) {
        echo "<script>alert('Güncelleme başarılı'); window.location.href='index.php#referanslar';</script>";
    } else {
        echo "Hata oluştu: " . $stmt->error;
    }

    $stmt->close();
    exit;
}

$referans_sonuc = $baglanti->query("SELECT * FROM reference_content WHERE id=1");
$referans_veri = $referans_sonuc->fetch_assoc();

if (!$referans_veri) {
    $referans_veri = ['title1' => '', 'title2' => '', 'paragraph' => ''];
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <title>Referans Başlık Güncelle</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 40px 20px;
    background-color: #121212;
    color: #e0e0e0;
    min-height: 100vh;
    margin: 0;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  h2 {
    text-align: center;
    color: #ff5722;
    font-weight: 700;
    margin-bottom: 30px;
    user-select: none;
  }

  form {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    background-color: #1e1e1e;
    padding: 30px 20px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(255, 87, 34, 0.3);
    border: 1px solid #333;
    transition: background-color 0.3s ease, color 0.3s ease;
    color: #e0e0e0;
    box-sizing: border-box;
  }

  label {
    display: block;
    margin-top: 20px;
    font-weight: 600;
    color: #ccc;
    user-select: none;
  }

  input, textarea {
    width: 100%;
    padding: 12px 15px;
    margin-top: 8px;
    border: 1px solid #444;
    border-radius: 8px;
    background-color: #2a2a2a;
    color: #eee;
    font-size: 1rem;
    transition: border-color 0.3s ease, background-color 0.3s ease, color 0.3s ease;
    box-sizing: border-box;
  }

  input:focus, textarea:focus {
    outline: none;
    border-color: #ff5722;
    background-color: #3a3a3a;
    color: #fff;
  }

  button, .back-button {
    margin-top: 30px;
    padding: 12px 28px;
    background-color: #ff5722;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease;
    user-select: none;
  }

  button:hover, .back-button:hover {
    background-color: #e64a19;
  }

  .back-button {
    margin-left: 15px;
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

  /* Açık mod için stiller */
  body.light-mode {
    background-color: #f8f9fa;
    color: #333;
  }

  body.light-mode form {
    background-color: #fff;
    color: #333;
    border: 1.5px solid #ddd;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }

  body.light-mode h2 {
    color: #e76f51;
  }

  body.light-mode label {
    color: #555;
  }

  body.light-mode input, body.light-mode textarea {
    background-color: #fff;
    color: #333;
    border: 1.5px solid #ccc;
  }

  body.light-mode input:focus, body.light-mode textarea:focus {
    border-color: #e76f51;
    background-color: #fff;
    color: #333;
  }

  body.light-mode button, body.light-mode .back-button {
    background-color: #e76f51;
    color: white;
  }

  body.light-mode button:hover, body.light-mode .back-button:hover {
    background-color: #c6533f;
  }
</style>

</head>
<body>

  <h2>Referans Bölümünü Güncelle</h2>

  <form method="POST">
    <label for="title1">Başlık 1</label>
    <input type="text" id="title1" name="title1" value="<?= htmlspecialchars($referans_veri['title1']) ?>" required>

    <label for="title2">Başlık 2</label>
    <input type="text" id="title2" name="title2" value="<?= htmlspecialchars($referans_veri['title2']) ?>" required>

    <label for="paragraph">Açıklama</label>
    <textarea id="paragraph" name="paragraph" rows="5" required><?= htmlspecialchars($referans_veri['paragraph']) ?></textarea>

    <button type="submit">Güncelle</button>
    <a href="index.php#referanslar" class="back-button">Geri Dön</a>
  </form>

  <button id="theme-toggle" aria-label="Tema değiştir">
    <i class="fa-solid fa-moon"></i>
  </button>

  <script>
    const toggleButton = document.getElementById('theme-toggle');
    const icon = toggleButton.querySelector('i');
    const body = document.body;

    // Sayfa yüklendiğinde tema durumunu kontrol et
    const savedTheme = localStorage.getItem('theme') || 'dark';
    if (savedTheme === 'light') {
      body.classList.add('light-mode');
      icon.classList.remove('fa-moon');
      icon.classList.add('fa-sun');
    } else {
      body.classList.remove('light-mode');
      icon.classList.remove('fa-sun');
      icon.classList.add('fa-moon');
    }

    toggleButton.addEventListener('click', () => {
      if (body.classList.contains('light-mode')) {
        body.classList.remove('light-mode');
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
        localStorage.setItem('theme', 'dark');
      } else {
        body.classList.add('light-mode');
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
        localStorage.setItem('theme', 'light');
      }
    });
  </script>

</body>
</html>
