<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['login'])) {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM voters WHERE nim = '$nim'";
    $query = $conn->query($sql);

    if ($query->num_rows < 1) {
        $_SESSION['error'] = 'Tidak dapat menemukan pemilih dengan NIM tersebut';
    } else {
        $row = $query->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            if ($row['verified'] == 1) {
                $_SESSION['voter'] = $row['id'];
            } else {
                $_SESSION['error'] = 'Daftar dan verifikasi email Anda sebelum masuk.';
            }
        } else {
            $_SESSION['error'] = 'Kata sandi salah atau belum mendaftar';
        }
    }
} else {
    $_SESSION['error'] = 'Masukkan data pemilih terlebih dahulu';
}

header('location: index.php');
