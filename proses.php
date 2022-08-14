<?php
$koneksi = mysqli_connect("localhost", "root", "", "login");

class Flasher
{
    public static function setFlash($pesan, $warna)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'warna' => $warna
        ];
    }
    public static function flash()
    {
        if (isset($_SESSION['flash'])) {
            echo '<p style="color: ' . $_SESSION['flash']['warna'] . ';font-weight: bold;">' . $_SESSION['flash']['pesan'] . '</p>';
            unset($_SESSION['flash']);
        }
    }
}

function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function login($data)
{

    global $koneksi;
    $email = $data["email"];
    $kata_sandi = $data["kata-sandi"];

    $data = mysqli_query($koneksi, "SELECT * FROM akun WHERE email = '$email'");

    $ambil = mysqli_fetch_assoc($data);

    if (mysqli_num_rows($data) === 1) {

        if (password_verify($kata_sandi, $ambil["kata_sandi"])) {

            $_SESSION["login"] = $email;

            header("Location: home.php");
            exit;
        } else {
            Flasher::setFlash('Kata Sandi Salah!', 'red');
            return false;
        }
    } else {
        Flasher::setFlash('Email belum terdaftar!', 'red');
        return false;
    }
}

function daftar($data)
{
    global $koneksi;

    $email = $data["email"];
    $kata_sandi = mysqli_real_escape_string($koneksi, $data["kata-sandi"]);
    $konfirmasi_kata_sandi = $data['konfirmasi-kata-sandi'];
    $waktu = time();

    $hash = password_hash($kata_sandi, PASSWORD_DEFAULT);

    $cek_email = mysqli_query($koneksi, "SELECT email FROM akun WHERE email = '$email'");

    if (mysqli_num_rows($cek_email) != 1) {
        if ($kata_sandi == $konfirmasi_kata_sandi) {
            $query = "INSERT INTO akun VALUES('', '$email', '$hash', '$waktu')";
            mysqli_query($koneksi, $query);

            return mysqli_affected_rows($koneksi);
        } else {
            Flasher::setFlash('Kata Sandi tidak sama!', 'red');
            return false;
        }
    } else {
        Flasher::setFlash('Email sudah ada!', 'red');
        return false;
    }
}
