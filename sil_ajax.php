<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $stmt = $baglanti->prepare("DELETE FROM takim WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "hata" => "Silme başarısız."]);
    }
} else {
    echo json_encode(["success" => false, "hata" => "Geçersiz istek."]);
}
