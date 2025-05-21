<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a href="#" class="navbar-brand">
          <img src="images/unhas-logo.png" alt="Logo" class="brand-logo">
          <div class="brand-text-container">
            <span class="brand-text">ONLINE VOTING</span>
            <span class="brand-subtext">UNIVERSITAS HASANUDDIN</span>
          </div>
        </a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['student'])): ?>
            <li><a href="index.php">HOME</a></li>
            <li><a href="transaction.php">TRANSACTION</a></li>
          <?php endif; ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <!-- User Profile -->
          <a href="#" class="user-profile user user-menu">
            <li>
              <?php if (!empty($voter['photo'])): ?>
                <img src="images/<?php echo $voter['photo']; ?>" class="user-image" alt="User Image">
              <?php else: ?>
                <i class="fa fa-user user-icon"></i>
              <?php endif; ?>
            </li>
            <li>

              <span class="user-name"><?php echo $voter['fullname']; ?></span>

            </li>
          </a>
          <!-- Logout -->
          <li><a href="logout.php" class="btn btn-logout"><i class="fa fa-sign-out"></i> LOGOUT</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<style>
  /* Navbar Styling */
  .main-header {
    background-color: #0862BC;
  }

  .navbar {
    margin-bottom: 0;
    min-height: 80px;
    /* Adjusted to accommodate larger logo */
    border: none;
    display: flex;
    align-items: center;
    /* Center items vertically */
  }

  .navbar-header {
    display: flex;
    align-items: center;
  }

  .navbar-brand {
    height: auto;
    display: flex;
    align-items: center;
    padding: 10px 15px;
  }

  .brand-logo {
    height: 60px;
    margin-right: 10px;
  }

  .brand-text-container {
    display: flex;
    flex-direction: column;
  }

  .brand-text {
    color: white;
    font-size: 20px;
    font-family: 'Arial', sans-serif;
    font-weight: 600;
  }

  .brand-subtext {
    color: white;
    font-size: 16px;
    font-family: 'Arial', sans-serif;
    font-weight: 400;
  }

  .navbar-nav {
    display: flex;
    align-items: center;
    /* Center items vertically */
  }

  .navbar-nav>li>a {
    color: white;
    font-size: 16px;
    font-family: Arial, sans-serif;
    padding: 20px 15px;
    transition: background-color 0.3s;
  }

  .navbar-nav>li>a:hover,
  .navbar-nav>li>a:focus {
    background-color: rgba(255, 255, 255, 0.1);
  }

  /* User Profile Fix */
  .user-profile {
    display: flex;
    align-items: center;
    padding: 0 15px;
    /* Adjust padding to align with other items */
  }

  .user-profile li {
    display: flex;
    align-items: center;
  }

  .user-image {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255, 255, 255, 0.3);
    margin-right: 10px;
  }

  .user-icon {
    font-size: 35px;
    color: white;
    margin-right: 10px;
    display: flex;
    align-items: center;
  }

  .user-name {
    color: white;
    font-size: 16px;
    font-family: Arial, sans-serif;
    display: flex;
    align-items: center;
  }

  /* Logout Button */
  .btn-logout {
    display: flex;
    align-items: center;
    padding: 20px 15px;
    color: white;
    font-size: 16px;
    font-family: Arial, sans-serif;
    transition: background-color 0.3s;
  }


  /* Navbar Toggle for Mobile */
  .navbar-toggle {
    border-color: rgba(255, 255, 255, 0.5);
    margin-top: 13px;
  }

  .navbar-toggle .icon-bar {
    background-color: white;
  }

  /* Responsive Fixes */
  @media (max-width: 768px) {
    .navbar-brand {
      padding: 15px 15px;
    }

    .brand-logo {
      height: 30px;
    }

    .brand-text {
      font-size: 16px;
    }

    .brand-subtext {
      font-size: 14px;
    }

    .navbar-nav>li>a {
      padding: 15px;
    }

    .navbar-nav {
      margin: 0 -15px;
    }

    .navbar-right {
      margin-top: 0;
      margin-bottom: 0;
    }

    .navbar-nav>li {
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar-nav>li:last-child {
      border-bottom: none;
    }

    .user-menu>a {
      display: flex;
      align-items: center;
    }
  }
</style>