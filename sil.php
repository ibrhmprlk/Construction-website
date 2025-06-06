<?php
include 'db.php';

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $stmt = $baglanti->prepare("DELETE FROM takim WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: takim.php?durum=silindi");
        exit;
    } else {
        header("Location: takim.php?durum=silme_hatasi");
        exit;
    }
} else {
    header("Location: takim.php?durum=silme_hatasi");
    exit;
}
