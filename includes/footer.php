<style>
  .main-footer {
    background: #0862BC;
    /* Solid background color */
    padding: 2rem 0;
    position: relative;
    overflow: hidden;
  }

  .footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
  }

  .footer-info {
    flex: 1;
    min-width: 250px;
  }

  .copyright {
    color: white;
    font-size: 1.2rem;
    /* Increased font size */
    margin: 0;
    font-weight: 500;
    letter-spacing: 0.5px;
  }

  .footer-links {
    display: flex;
    gap: 2.5rem;
    flex-wrap: wrap;
  }

  .footer-link {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    font-size: 1.2rem;
    /* Increased font size */
    font-weight: 500;
    position: relative;
  }

  .footer-link::after {
    content: "";
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 0;
    height: 2px;
    background: white;
  }

  .footer-link:hover {
    color: white;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .footer-content {
      flex-direction: column;
      text-align: center;
      gap: 2rem;
    }

    .footer-links {
      justify-content: center;
      gap: 2rem;
    }

    .main-footer {
      padding: 2.5rem 0;
    }
  }
</style>

<footer class="main-footer">
  <div class="container">
    <div class="footer-content">
      <div class="footer-info">
        <p class="copyright">© 2025 fnilvuwu. All rights reserved.</p>
      </div>
      <div class="footer-links">
        <a href="#" class="footer-link">Privacy Policy</a>
        <a href="#" class="footer-link">Terms of Service</a>
        <a href="#" class="footer-link">Contact</a>
      </div>
    </div>
  </div>
</footer>