<?php
    include 'includes/session.php';

    // Delete all votes
    $sql = "DELETE FROM votes";
    if($conn->query($sql)){
        // Reset voted status for all users
        $sql = "UPDATE voters SET voted = 0";
        if($conn->query($sql)){
            $_SESSION['success'] = "Votes reset successfully and user votes reset to 0";
        }
        else{
            $_SESSION['error'] = "Something went wrong in resetting user votes";
        }
    }
    else{
        $_SESSION['error'] = "Something went wrong in resetting votes";
    }

    header('location: votes.php');
?>