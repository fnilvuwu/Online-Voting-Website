<?php
include 'includes/session.php';

$return = 'home.php';
if (isset($_GET['return'])) {
    $return = $_GET['return'];
}

if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $voting_status = $_POST['voting_status'];

    $file = 'config.ini';
    $content = "election_title = $title\nvoting_status = $voting_status\n";

    if (file_put_contents($file, $content)) {
        $_SESSION['success'] = 'Configuration updated successfully';
    } else {
        $_SESSION['error'] = 'Failed to update configuration';
    }
} else {
    $_SESSION['error'] = "Fill up config form first";
}

header('location: ' . $return);
?>