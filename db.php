<?php
$baglanti = mysqli_connect("localhost", "root", "", "insaat");

if (!$baglanti) {
    die("Veritabanı bağlantı hatası: " . mysqli_connect_error());
}
?>
