<?php
include 'includes/session.php';

if(isset($_POST['add'])){
    $nim = $_POST['nim'];
    $fullname = $_POST['fullname'];

    // Check if NIM already exists
    $sql = "SELECT * FROM voters WHERE nim = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $_SESSION['error'] = 'NIM already exists.';
    } else {
        $sql = "INSERT INTO voters (nim, fullname, email, password, token, verified) VALUES (?, ?, '', '', '', 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $nim, $fullname);

        if($stmt->execute()){
            $_SESSION['success'] = 'Voter added successfully.';
        } else {
            $_SESSION['error'] = $stmt->error;
        }
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'Fill up add form first';
}

header('location: voters.php');
?>