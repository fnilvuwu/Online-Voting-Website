<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $verified = isset($_POST['verified']) ? 1 : 0;

    $sql = "SELECT * FROM voters WHERE id = $id";
    $query = $conn->query($sql);
    $row = $query->fetch_assoc();

    $password = $row['password']; // Keep the current password

    $sql = "UPDATE voters SET nim = '$nim', fullname = '$fullname', email = '$email', verified = '$verified' WHERE id = '$id'";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Voter updated successfully';
    } else {
        $_SESSION['error'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Fill up edit form first';
}

header('location: voters.php');
?>