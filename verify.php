<?php
include 'includes/conn.php'; // Include the database connection file

if(isset($_GET['token'])){
    $token = $_GET['token'];

    // Check if the token exists and is not expired
    $sql = "SELECT * FROM voters WHERE token = '$token'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $current_time = date('Y-m-d H:i:s');

        if($row['verification_expiry'] > $current_time){
            // Verify the user
            $sql = "UPDATE voters SET verified = 1, token = '', verification_expiry = NULL WHERE token = '$token'";
            if($conn->query($sql)){
                $base_url = "http://" . $_SERVER['HTTP_HOST'];
                echo "<div style='text-align: center; margin-top: 50px;'>
                        <h2>Email berhasil diverifikasi! Anda sekarang dapat <a href='{$base_url}/index.php'>log in</a>.</h2>
                      </div>";
            } else {
                echo "<div style='text-align: center; margin-top: 50px;'>
                        <h2>Tautan verifikasi tidak valid.</h2>
                      </div>";
            }
        } else {
            $base_url = "http://" . $_SERVER['HTTP_HOST'];
            echo "<div style='text-align: center; margin-top: 50px;'>
                    <h2>Tautan verifikasi telah kedaluwarsa. Silakan <a href='{$base_url}/register.php'>daftar</a> lagi.</h2>
                  </div>";
        }
    } else {
        echo "<div style='text-align: center; margin-top: 50px;'>
                <h2>Tautan verifikasi tidak valid.</h2>
              </div>";
    }
} else {
    echo "<div style='text-align: center; margin-top: 50px;'>
            <h2>Tidak ada token verifikasi yang diberikan.</h2>
          </div>";
}
?>