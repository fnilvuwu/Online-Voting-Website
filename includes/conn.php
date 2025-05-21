<?php
$conn = new mysqli('localhost', 'root', '', 'votesystem');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check voting status
$parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
$voting_status = $parse['voting_status'] === 'true' ? true : false;

if (!$voting_status && !isset($_SESSION['admin'])) {
    if (basename($_SERVER['PHP_SELF']) !== 'voting_stopped.php') {
        session_start();
        header('location: voting_stopped.php');
        exit();
    }
}
?>