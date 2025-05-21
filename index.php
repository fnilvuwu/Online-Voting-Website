<?php
session_start();
if (isset($_SESSION['admin'])) {
  header('location: admin/home.php');
}

if (isset($_SESSION['voter'])) {
  header('location: home.php');
}
?>
<?php include 'includes/header.php'; ?>
<!-- aVBOjI8oYk7nwRX already vote-->
<!-- YTgArKEpVnRuwzt not vote yet -->
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
  <?php
  $parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
  $title = $parse['election_title'];
  ?>
  <div class="login-box">
    <div class="login-logo">
      <img src="\images\unhas-logo.png" alt="Unhas Logo">
    </div>

    <div class="login-box-body">
      <h4 style="text-align: center; margin-bottom: 20px; color: #333; font-weight: bold;"><?php echo $title; ?></h4>

      <form action="login.php" method="POST">
        <div class="form-group has-feedback" style="margin-bottom: 15px;">
          <input type="text" class="form-control" name="nim" placeholder="NIM" required style="height: 40px; padding-left: 15px;">
          <span class="glyphicon glyphicon-user form-control-feedback" style="line-height: 40px;"></span>
        </div>
        <div class="form-group has-feedback" style="margin-bottom: 15px;">
          <input type="password" class="form-control" name="password" placeholder="Password" required style="height: 40px; padding-left: 15px;">
          <span class="glyphicon glyphicon-lock form-control-feedback" style="line-height: 40px;"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat" style="background-color: #007bff; border-color: #007bff; height: 40px; font-size: 16px;" name="login">Login</button>
          </div>
        </div>
      </form>
      <br>
      <div class="row">
        <div class="col-xs-12" style="display: flex; justify-content: center; align-items: center; height: 100%;">
          <a href="register.php" style="height: 40px; font-size: 16px;">Daftar</a>
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
    ?>
  </div>

  <?php include 'includes/scripts.php' ?>
</body>

</html>