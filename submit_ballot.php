<?php
include 'includes/session.php';
include 'includes/slugify.php'; // Include the file that contains the slugify function

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voter_id = $voter['id'];
    $sql = "SELECT * FROM positions";
    $query = $conn->query($sql);

    $error = false;
    $positions = array();

    while ($row = $query->fetch_assoc()) {
        $position = slugify($row['description']);
        $positions[] = array('slug' => $position, 'id' => $row['id']);
    }

    foreach ($positions as $position) {
        $position_slug = $position['slug'];
        if (!isset($_POST[$position_slug]) || empty($_POST[$position_slug])) {
            $_SESSION['error'][] = 'Anda harus memilih setidaknya satu kandidat untuk setiap kategori.';
            header('location: home.php');
            exit();
        }
    }

    foreach ($positions as $position) {
        $position_slug = $position['slug'];
        $position_id = $position['id'];
        if (isset($_POST[$position_slug])) {
            if (is_array($_POST[$position_slug])) {
                foreach ($_POST[$position_slug] as $candidate) {
                    $sql = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('$voter_id', '$candidate', '$position_id')";
                    $conn->query($sql);
                }
            } else {
                $candidate = $_POST[$position_slug];
                $sql = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('$voter_id', '$candidate', '$position_id')";
                $conn->query($sql);
            }
        }
    }

    // Update voted status
    $sql = "UPDATE voters SET voted = 1 WHERE id = '$voter_id'";
    $conn->query($sql);

    $_SESSION['success'] = 'Suara Anda telah diberikan.';
    header('location: home.php');
} else {
    $_SESSION['error'][] = 'Pilih kandidat yang akan dipilih terlebih dahulu.';
    header('location: home.php');
}
?>