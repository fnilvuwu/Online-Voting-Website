<?php
include 'includes/session.php';

if (isset($_POST['editPassword'])) {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE voters SET password = '$hashed_password' WHERE id = '$id'";
    if ($conn->query($sql)) {
        $_SESSION['success'] = 'Password updated successfully';
    } else {
        $_SESSION['error'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Fill up edit form first';
}

header('location: voters.php');
?>