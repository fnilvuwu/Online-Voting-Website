<?php
include 'includes/conn.php';
require 'vendor/autoload.php'; // Include PHPMailer
session_start(); // Ensure session is started

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to reset expired verifications
function resetExpiredVerifications($conn)
{
  $current_time = date('Y-m-d H:i:s');
  $sql = "UPDATE voters SET password = '', token = '', verified = 0 WHERE verified = 0 AND verification_expiry < ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $current_time);
  $stmt->execute();
  $stmt->close();
}

// Reset expired verifications
resetExpiredVerifications($conn);

if (isset($_POST['register'])) {
  $nim = $_POST['nim'];
  $email = strtolower($_POST['email']); // Convert input email to lowercase
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Check if email is valid
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Alamat email tidak valid.';
    header('location: register.php');
    exit();
  }

  // Check if passwords match
  if ($password !== $confirm_password) {
    $_SESSION['error'] = 'Kata sandi tidak sesuai.';
    header('location: register.php');
    exit();
  }

  // Check password length and complexity
  if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
    $_SESSION['error'] = 'Kata sandi harus terdiri dari minimal 8 karakter dan terdiri dari huruf dan angka.';
    header('location: register.php');
    exit();
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
  $token = bin2hex(random_bytes(50)); // Generate a unique token
  $verification_expiry = date('Y-m-d H:i:s', strtotime('+5 minutes')); // Set verification expiry time

  // Check if NIM exists in the voters table
  $sql = "SELECT * FROM voters WHERE nim = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $nim);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Check if the account is already verified
    if ($row['verified'] == 1) {
      $_SESSION['error'] = 'Akun ini sudah terverifikasi dan tidak dapat diubah.';
      header('location: register.php');
      exit();
    }

    // Check if the email matches the existing email (case-insensitive)
    if (!empty($row['email']) && strtolower($row['email']) !== $email) {
      $masked_email = maskEmail($row['email']);
      $_SESSION['error'] = "Email tidak dapat diubah. Email Anda seharusnya $masked_email";
      header('location: register.php');
      exit();
    }

    // Check if the verification time has expired
    $current_time = date('Y-m-d H:i:s');
    if ($row['verification_expiry'] > $current_time) {
      $_SESSION['error'] = 'Silakan verifikasi akun Anda atau tunggu 5 menit hingga waktu verifikasi berakhir.';
      header('location: register.php');
      exit();
    } else {
      // Reset the password, token, and verification expiry
      $sql = "UPDATE voters SET email = ?, password = ?, token = ?, verified = 0, verification_expiry = ? WHERE nim = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('sssss', $email, $hashed_password, $token, $verification_expiry, $nim);

      if ($stmt->execute()) {
        // Construct the base URL dynamically
        $base_url = "http://" . $_SERVER['HTTP_HOST'];
        $verification_link = "{$base_url}/verify.php?token=$token";
        if (sendVerificationEmail($email, $verification_link)) {
          $_SESSION['success'] = "Pendaftaran berhasil! Silakan periksa email Anda untuk memverifikasi akun Anda.";
        } else {
          $_SESSION['error'] = "Gagal mengirim email verifikasi.";
        }
        header('location: register.php');
        exit();
      } else {
        $_SESSION['error'] = $stmt->error;
        header('location: register.php');
        exit();
      }
    }
  } else {
    $_SESSION['error'] = 'NIM tidak ditemukan.';
    header('location: register.php');
    exit();
  }

  $stmt->close();
}

// Function to send verification email
function sendVerificationEmail($email, $verification_link)
{
  $mail = new PHPMailer\PHPMailer\PHPMailer();
  try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'YOUR_GMAIL_ADDRESS'; // Your Gmail address
    $mail->Password = 'YOUR_APP_PASSWORD'; // Your Gmail App Password
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('YOUR_GMAIL_ADDRESS', 'Verifikasi Voting FK-UH 2025');
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Verifikasi email Anda';
    $mail->Body    = "Klik tautan ini untuk memverifikasi email Anda: <a href='$verification_link'>$verification_link</a>";

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}

// Function to mask email
function maskEmail($email)
{
  if (empty($email)) {
    return '';
  }
  $email = strtolower($email); // Convert email to lowercase
  $email_parts = explode('@', $email);
  $name = $email_parts[0];
  $domain = $email_parts[1];
  $masked_name = substr($name, 0, 1) . str_repeat('*', strlen($name) - 2) . substr($name, -1);
  return $masked_name . '@' . $domain;
}
?>
<?php include 'includes/header.php'; ?>
<style>
  html,
  body {
    height: 100%;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f0f0f0;
  }

  .login-box {
    width: 100%;
    max-width: 600px;
    margin: 0 20px;
  }

  .login-logo {
    margin-bottom: 20px;
    text-align: center;
  }

  .login-logo img {
    max-width: 100%;
    height: 60px;
  }

  .login-box-body {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  @media (min-width: 768px) {
    .login-box {
      max-width: 800px;
      /* Increase the max-width for larger screens */
    }

    .login-box-body {
      padding: 40px;
      /* Increase padding for larger screens */
    }
  }
</style>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img src="\images\unhas-logo.png" alt="Unhas Logo">
    </div>

    <div class="login-box-body">
      <h4 style="text-align: center; margin-bottom: 20px; color: #333; font-weight: bold;">Registrasi Akun</h4>

      <form method="POST" action="register.php">
        <div class="form-group has-feedback" style="margin-bottom: 15px;">
          <input type="text" class="form-control" name="nim" placeholder="NIM" required style="height: 40px; padding-left: 15px;">
          <span class="glyphicon glyphicon-user form-control-feedback" style="line-height: 40px;"></span>
        </div>
        <div class="form-group has-feedback" style="margin-bottom: 15px;">
          <input type="email" class="form-control" name="email" placeholder="Email" required style="height: 40px; padding-left: 15px;">
          <span class="glyphicon glyphicon-envelope form-control-feedback" style="line-height: 40px;"></span>
        </div>
        <div class="form-group has-feedback" style="margin-bottom: 15px;">
          <input type="password" class="form-control" name="password" placeholder="Password" required style="height: 40px; padding-left: 15px;">
          <span class="glyphicon glyphicon-lock form-control-feedback" style="line-height: 40px;"></span>
        </div>
        <div class="form-group has-feedback" style="margin-bottom: 15px;">
          <input type="password" class="form-control" name="confirm_password" placeholder="Konfirmasi Password" required style="height: 40px; padding-left: 15px;">
          <span class="glyphicon glyphicon-lock form-control-feedback" style="line-height: 40px;"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat" style="background-color: #007bff; border-color: #007bff; height: 40px; font-size: 16px;" name="register">Daftar</button>
          </div>
        </div>
      </form>
      <br>
      <div class="row">
        <div class="col-xs-12" style="display: flex; justify-content: center; align-items: center; height: 100%;">
          <a href="index.php" style="height: 40px; font-size: 16px;">Login</a>
        </div>
      </div>
    </div>
    <?php
    if (isset($_SESSION['error'])) {
      echo "
        <div class='alert alert-danger text-center mt20' style='margin-top: 20px;'>
          <p>" . $_SESSION['error'] . "</p> 
        </div>
      ";
      unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
      echo "
        <div class='alert alert-success text-center mt20' style='margin-top: 20px;'>
          <p>" . $_SESSION['success'] . "</p> 
        </div>
      ";
      unset($_SESSION['success']);
    }
    ?>
  </div>

  <?php include 'includes/scripts.php' ?>
</body>

</html>