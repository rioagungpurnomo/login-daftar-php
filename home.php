<?php
session_start();

require 'proses.php';

if (!isset($_SESSION["login"])) {
    Flasher::setFlash('Anda harus Login terlebih dahulu!', 'red');
    header("Location: index.php");
    exit;
}

$email = $_SESSION["login"];
$data = mysqli_query($koneksi, "SELECT * FROM akun WHERE email = '$email'");
$ambil = mysqli_fetch_assoc($data);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>

    <h1>Selamat datang di Website saya</h1>

    <p>Info Akun</p>
    <ul>
        <li>Email : <?= $ambil['email']; ?></li>
        <li>Bergabung pada : <?= date('d - m - Y', $ambil['waktu']); ?></li>
    </ul>

    <a href="keluar.php">Keluar</a>

</body>

</html>
