<?php
include 'db.php';

// ID'yi al
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $baglanti->prepare("SELECT * FROM takim WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$uye = $result->fetch_assoc();

$upload_error = '';

// POST ile gönderim varsa güncelle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isim = $_POST['isim'];
    $unvan = $_POST['unvan'];
    $github = $_POST['github_link'];
    $instagram = $_POST['instagram_link'];

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $tmp_name = $_FILES['img']['tmp_name'];
        $filename = basename($_FILES['img']['name']);
        $target_file = $upload_dir . time() . '_' . $filename;

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = mime_content_type($tmp_name);

        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($tmp_name, $target_file)) {
                $img = $target_file;
            } else {
                $upload_error = "Dosya yüklenirken hata oluştu.";
                $img = $uye['img'];
            }
        } else {
            $upload_error = "Yalnızca JPG, PNG, GIF ve WEBP dosyalarına izin verilir.";
            $img = $uye['img'];
        }
    } else {
        $img = $uye['img'];
    }

    $stmt = $baglanti->prepare("UPDATE takim SET isim = ?, unvan = ?, img = ?, github_link = ?, instagram_link = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $isim, $unvan, $img, $github, $instagram, $id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=$id&success=1");
        exit();
    } else {
        echo "Hata oluştu: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Üye Güncelle</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .success-message {
            margin-bottom: 15px;
            padding: 12px 16px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            text-align: center;
            transition: opacity 0.5s ease;
        }
        :root {
            --bg-color: #121212;
            --form-bg: #1f1f1f;
            --text-color: #eee;
            --label-color: #ccc;
            --input-bg: #2a2a2a;
            --input-border: #444;
            --input-focus-bg: #3a3a3a;
            --button-bg: #ff5722;
            --button-hover: #e64a19;
            --back-btn-bg: #555;
            --back-btn-hover: #444;
            --box-shadow: 0 4px 15px rgba(255, 87, 34, 0.4);
        }
        body.light {
            --bg-color: #f8f9fa;
            --form-bg: #fff;
            --text-color: #333;
            --label-color: #555;
            --input-bg: #fff;
            --input-border: #ccc;
            --input-focus-bg: #fff;
            --button-bg: #e76f51;
            --button-hover: #c6533f;
            --back-btn-bg: #888;
            --back-btn-hover: #777;
            --box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            padding: 30px 15px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .theme-toggle {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background-color:black;
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18);
            transition: background-color 0.3s ease;
        }
        .theme-toggle:hover {
            background-color: rgba(96, 94, 94, 0.33);
        }
        body.light .theme-toggle:hover {
            background-color:  #444  !important;
            border-color: #222 !important;
        }
        form {
            background: var(--form-bg);
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 480px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        h2 {
            text-align: center;
            color: var(--button-bg);
            margin-bottom: 25px;
            font-weight: 700;
            transition: color 0.3s ease;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: var(--label-color);
            transition: color 0.3s ease;
        }
        .input-group {
            display: flex;
            align-items: center;
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 8px;
            padding: 0 10px;
            margin-top: 6px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .input-group i {
            color: var(--button-bg);
            margin-right: 10px;
            transition: color 0.3s ease;
        }
        .input-group input[type=text], .input-group input[type=file] {
            flex: 1;
            padding: 12px 10px;
            background: transparent;
            border: none;
            color: var(--text-color);
            font-size: 1rem;
            transition: color 0.3s ease;
        }
        .input-group input[type=text]:focus, .input-group input[type=file]:focus {
            outline: none;
            border-color: var(--button-bg);
            background-color: var(--input-focus-bg);
        }
        .buttons {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        button, .back-button {
            padding: 12px 28px;
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
            user-select: none;
        }
        button {
            background-color: var(--button-bg);
        }
        button:hover {
            background-color: var(--button-hover);
        }
        .back-button {
            background-color: var(--back-btn-bg);
        }
        .back-button:hover {
            background-color: var(--back-btn-hover);
        }
        .upload-preview {
            margin-top: 10px;
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .error-message {
            margin-top: 10px;
            color: #f44336;
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<body>

<button class="theme-toggle" aria-label="Tema değiştir" onclick="toggleTheme()">
    <i id="themeIcon" class="fa-solid fa-moon"></i>
</button>

<form method="post" enctype="multipart/form-data" novalidate>
    <h2><i class="fa-solid fa-user-pen"></i> Takım Üyesini Güncelle</h2>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="success-message" id="successMsg">Güncelleme başarılı!</div>
    <?php endif; ?>

    <label><i class="fa-solid fa-user"></i> İsim</label>
    <div class="input-group">
        <i class="fa-solid fa-user"></i>
        <input type="text" name="isim" value="<?= htmlspecialchars($uye['isim']) ?>" required>
    </div>

    <label><i class="fa-solid fa-id-badge"></i> Ünvan</label>
    <div class="input-group">
        <i class="fa-solid fa-id-badge"></i>
        <input type="text" name="unvan" value="<?= htmlspecialchars($uye['unvan']) ?>" required>
    </div>

    <label><i class="fa-solid fa-image"></i> Fotoğraf (Yeni yüklemezsen eski kalır)</label>
    <div class="input-group">
        <i class="fa-solid fa-file-image"></i>
        <input type="file" name="img" accept="image/*">
    </div>
    <?php if ($uye['img'] && file_exists($uye['img'])): ?>
        <img src="<?= htmlspecialchars($uye['img']) ?>" alt="Mevcut Fotoğraf" class="upload-preview" loading="lazy" />
    <?php endif; ?>
    <?php if ($upload_error): ?>
        <div class="error-message"><?= htmlspecialchars($upload_error) ?></div>
    <?php endif; ?>

    <label><i class="fa-brands fa-github"></i> GitHub Linki</label>
    <div class="input-group">
        <i class="fa-brands fa-github"></i>
        <input type="text" name="github_link" value="<?= htmlspecialchars($uye['github_link']) ?>">
    </div>

    <label><i class="fa-brands fa-instagram"></i> Instagram Linki</label>
    <div class="input-group">
        <i class="fa-brands fa-instagram"></i>
        <input type="text" name="instagram_link" value="<?= htmlspecialchars($uye['instagram_link']) ?>">
    </div>

    <div class="buttons">
        <button type="submit" aria-label="Güncelle"><i class="fa-solid fa-floppy-disk"></i> Güncelle</button>
        <a href="index.php#team" class="back-button" aria-label="Geri dön"><i class="fa-solid fa-arrow-left"></i> Geri</a>
    </div>
</form>

<script>
 window.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        const themeIcon = document.getElementById('themeIcon');

        if (savedTheme === 'light') {
            document.body.classList.add('light');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            document.body.classList.remove('light');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
    });

    // Tema değiştirme fonksiyonu
    function toggleTheme() {
        const body = document.body;
        const themeIcon = document.getElementById('themeIcon');

        const isLight = body.classList.toggle('light');

        if (isLight) {
            localStorage.setItem('theme', 'light');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            localStorage.setItem('theme', 'dark');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
    }
    window.onload = function () {
        const successMessage = document.getElementById('successMsg');
        if (successMessage) {
            setTimeout(function () {
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 500);
            }, 2000);
        }
    };
</script>

</body>
</html>
