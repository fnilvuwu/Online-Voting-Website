<?php
  session_start();
  if(isset($_SESSION['admin'])){
    header('location:home.php');
  }
?>
<?php include 'includes/header.php'; ?>
<style>
  html, body {
    height: 100%;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f0f0f0;
  }
  .login-page, .register-page {
    background: none; /* Override the background color */
  }
  .login-box {
    width: 100%;
    max-width: 600px;
    margin: 0 20px;
  }
  .login-logo {
    margin-bottom: 20px;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .login-logo img {
    max-width: 100%;
    height: 60px;
  }
  .login-logo .fa-lock {
    font-size: 2em;
    margin-left: 10px;
    color: #333;
  }
  .login-box-body {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }
  @media (min-width: 768px) {
    .login-box {
      max-width: 800px; /* Increase the max-width for larger screens */
    }
    .login-box-body {
      padding: 40px; /* Increase padding for larger screens */
    }
  }
</style>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <i class="fa fa-lock"></i>
  </div>
  
  <div class="login-box-body">
    <h4 style="text-align: center; margin-bottom: 20px; color: #333; font-weight: bold;">Admin Login</h4>

    <form action="login.php" method="POST">
      <div class="form-group has-feedback" style="margin-bottom: 15px;">
        <input type="text" class="form-control" name="username" placeholder="Username" required style="height: 40px; padding-left: 15px;">
        <span class="glyphicon glyphicon-user form-control-feedback" style="line-height: 40px;"></span>
      </div>
      <div class="form-group has-feedback" style="margin-bottom: 15px;">
        <input type="password" class="form-control" name="password" placeholder="Password" required style="height: 40px; padding-left: 15px;">
        <span class="glyphicon glyphicon-lock form-control-feedback" style="line-height: 40px;"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="background-color: #007bff; border-color: #007bff; height: 40px; font-size: 16px;" name="login">Sign In</button>
        </div>
      </div>
    </form>
  </div>
  <?php
    if(isset($_SESSION['error'])){
      echo "
        <div class='alert alert-danger text-center mt20' style='margin-top: 20px;'>
          <p>".$_SESSION['error']."</p> 
        </div>
      ";
      unset($_SESSION['error']);
    }
  ?>
</div>

<?php include 'includes/scripts.php' ?>
</body>
</html>