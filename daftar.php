<?php
session_start();

require 'proses.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["daftar"])) {
        if (daftar($_POST) > 0) {
            Flasher::setFlash('Berhasil Mendaftar!', 'green');
        } else {
            echo mysqli_error($koneksi);
        }
    }
}

if (isset($_SESSION["login"])) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
</head>

<body>


    <form action="" method="post" style="padding: 25px;">
        <h1>Form Daftar</h1>
        <?php Flasher::flash(); ?>
        <div style="margin-bottom: 10px;">
            <label for="email" style="display: block;">Email</label>
            <input type="email" name="email" id="email" style="width: 290px;" placeholder="Masukkan Email" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label for="kata-sandi" style="display: block;">Kata Sandi</label>
            <input type="password" name="kata-sandi" id="kata-sandi" style="width: 290px;" placeholder="Masukkan Kata Sandi" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label for="konfirmasi-kata-sandi" style="display: block;">Konfimasi Kata Sandi</label>
            <input type="password" name="konfirmasi-kata-sandi" id="konfirmasi-kata-sandi" style="width: 290px;" placeholder="Konfirmasi Kata Sandi" required>
        </div>
        <button type="submit" name="daftar" style="width: 300px;">Daftar</button>
        <p>Sudah mempunyai akun? <a href="index.php">Login</a></p>
    </form>

</body>

</html>
