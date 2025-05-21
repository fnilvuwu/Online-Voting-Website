<?php
    include 'includes/session.php';

    if(isset($_POST['edit'])){
        $id = $_POST['id'];
        $fullname = $_POST['fullname'];
        $position = $_POST['position'];
        $platform = $_POST['platform'];

        $sql = "UPDATE candidates SET fullname = ?, position_id = ?, platform = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sisi', $fullname, $position, $platform, $id);

        if($stmt->execute()){
            $_SESSION['success'] = 'Candidate updated successfully';
        }
        else{
            $_SESSION['error'] = $stmt->error;
        }

        $stmt->close();
    }
    else{
        $_SESSION['error'] = 'Fill up edit form first';
    }

    header('location: candidates.php');
?>