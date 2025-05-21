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
      <h4 style="text-align: center; margin-bottom: 20px; color: #333; font-weight: bold;">Voting Stopped</h4>
      <p style="text-align: center; color: #333;">Voting has been stopped. Please contact the administrator for more information.</p>
      <div class="row">
        <div class="col-xs-12" style="display: flex; justify-content: center; align-items: center; height: 100%;">
          <a href="index.php" style="height: 40px; font-size: 16px;">Go to Home</a>
        </div>
      </div>
    </div>
  </div>

  <?php include 'includes/scripts.php'; ?>
</body>

</html>