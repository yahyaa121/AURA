<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AURA Footer</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
    }

    footer {
      background-color: teal;
      padding: 40px 20px;
      color: white;
    }

    .footer {
      max-width: 1200px;
      margin: 0 auto;
      font-size: 14px;
    }

    .footer-main {
      display: flex;
      justify-content: space-between;
      gap: 40px;
      margin-bottom: 30px;
      flex-wrap: wrap;
    }

    .footer-left {
      flex: 1;
      min-width: 200px;
    }

    .footer-logo {
      font-size: 50px;
      font-weight: bold;
      margin-top: 20px;
      margin-bottom: 10px;
      text-align: left;
    }

    .contact-info {
      text-align: left;
      line-height: 1.6;
    }

    .social-icons {
      display: flex;
      gap: 10px;
      margin-top: 30px;
    }

    .social-icons a img {
      width: 20px;
      height: 20px;
      filter: brightness(0) invert(1); /* rendre les icônes blanches */
      transition: filter 0.3s;
    }

    .social-icons a img:hover {
      filter: none;
    }

    .footer-center,
    .footer-right {
      flex: 1;
      min-width: 150px;
      text-align: center;
    }

    .column-title {
      font-weight: bold;
      margin-bottom: 15px;
      font-size: 16px;
      text-transform: uppercase;
    }

    .footer-menu ul,
    .footer-categories ul {
      list-style: none;
      padding: 0;
    }

    .footer-menu li,
    .footer-categories li {
      margin-bottom: 8px;
    }

    .footer-menu a,
    .footer-categories a {
      text-decoration: none;
      color: white;
    }

    .footer-menu a:hover,
    .footer-categories a:hover {
      text-decoration: underline;
    }

    .footer-bottom {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-top: 1px solid rgba(255, 255, 255, 0.3);
      margin-top: 20px;
      padding-top: 20px;
      flex-wrap: wrap;
    }

    .copyright {
      font-size: 12px;
      padding-left: 30px;
    }

    .payment-methods {
      display: flex;
      gap: 15px;
      align-items: center;
      padding-right: 30px;
    }

    .payment-methods img {
      width: 40px;
      height: auto;
      filter: brightness(0) invert(1);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .footer-main {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .footer-left,
      .footer-center,
      .footer-right {
        text-align: center;
      }

      .contact-info {
        text-align: center;
      }

      .footer-bottom {
        flex-direction: column;
        gap: 10px;
        text-align: center;
        padding-left: 0;
        padding-right: 0;
      }

      .copyright,
      .payment-methods {
        padding: 0;
      }
    }
  </style>
</head>
<body>
  <footer>
    <div class="footer">
      <div class="footer-main">
        <!-- Colonne gauche -->
        <div class="footer-left">
          <div class="footer-logo">AURA</div>
          <div class="contact-info">
            <div>info@AURA.com</div>
            <div>Whatsapp: +99 535 353-17 54</div>
          </div>
          <div class="social-icons">
            <a href="#"><img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/instagram.svg" alt="Instagram"></a>
            <a href="#"><img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook"></a>
            <a href="#"><img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter"></a>
          </div>
        </div>

        <!-- Centre -->
        <div class="footer-center">
          <div class="column-title">Menu</div>
          <div class="footer-menu">
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Contact us</a></li>
              <li><a href="#">Terms & conditions</a></li>
            </ul>
          </div>
        </div>

        <!-- Droite -->
        <div class="footer-right">
          <div class="column-title">Categories</div>
          <div class="footer-categories">
            <ul>
              <li><a href="#">All products</a></li>
              <li><a href="#">Perfumes</a></li>
              <li><a href="#">Collections</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Bas de page -->
      <div class="footer-bottom">
        <div class="copyright">© 2025 Aura - ALL Rights Reserved</div>
        <div class="payment-methods">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/paypal.svg" alt="PayPal">
          <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/stripe.svg" alt="Stripe">
        </div>
      </div>
    </div>
  </footer>
</body>
</html>