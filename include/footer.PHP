<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AURA Footer</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Futura', 'Montserrat', 'Arial', sans-serif;
    }

    footer {
      background: linear-gradient(135deg,rgb(3, 119, 119) 80%, #20b2aa 100%);
      padding: 50px 20px;
      margin-top: 0; /* or a smaller value like 30px */
      color: white;
      border-radius: 18px 18px 0 0;
      box-shadow: 0 -2px 16px rgba(0,0,0,0.08);
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
      margin: 0 0 18px 0;
      text-align: left;
      display: flex;
      align-items: center;
      justify-content: flex-start;
    }

    .footer-logo img {
      height: 100px;
      width: 200px;
      display: block;
      margin: 0;
      filter: drop-shadow(0 2px 8px rgba(0,0,0,0.10));
    }

    .contact-info {
      text-align: left;
      line-height: 1.6;
      opacity: 0.95;
    }

    .social-icons {
      display: flex;
      gap: 16px;
      margin-top: 30px;
    }

    .social-icons a img {
      width: 28px;
      height: 28px;
      filter: brightness(0) invert(1);
      transition: filter 0.3s, transform 0.2s;
      border-radius: 50%;
      padding: 4px;
      background: rgba(255,255,255,0.08);
    }

    .social-icons a img:hover {
      filter: brightness(1.2) invert(0.8) sepia(0.5) hue-rotate(160deg) saturate(1.5);
      transform: scale(1.10);
      background: rgba(255,255,255,0.22);
    }

    .footer-center,
    .footer-right {
      flex: 1;
      min-width: 150px;
      text-align: left;
      align-items: flex-start;
    }

    .column-title {
      font-weight: bold;
      margin-bottom: 15px;
      font-size: 16px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .footer-menu,
    .footer-categories {
      width: 100%;
    }

    .footer-menu ul,
    .footer-categories ul {
      list-style: none;
      padding: 0;
      align-items: flex-start;
      text-align: left;
    }

    .footer-menu li,
    .footer-categories li {
      margin-bottom: 8px;
    }

    .footer-menu a,
    .footer-categories a {
      text-decoration: none;
      color: white;
      transition: color 0.2s, background 0.2s;
      border-radius: 4px;
      padding: 2px 4px;
    }

    .footer-menu a:hover,
    .footer-categories a:hover {
      /* No underline */
      color: #ffe082;
      background: rgba(255,255,255,0.13);
      text-decoration: none;
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
      opacity: 0.85;
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
      transition: filter 0.2s, transform 0.2s;
      border-radius: 6px;
      background: rgba(255,255,255,0.06);
      padding: 3px;
    }

    .payment-methods img:hover {
      filter: brightness(0.8) invert(0.8) sepia(1) hue-rotate(160deg) saturate(2);
      transform: scale(1.08);
      background: rgba(255,255,255,0.16);
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

      .footer-logo {
        justify-content: center;
        text-align: center;
        margin-bottom: 16px;
      }

      .footer-logo img {
        height: 38px;
      }
    }
  </style>
</head>
<footer>
  <div class="footer">
    <div class="footer-main">
      <!-- Colonne gauche -->
      <div class="footer-left">
        <div class="footer-logo">
          <img src="Logo/whiteAura.png" alt="AURA Logo">
        </div>
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
        <div class="column-title"><?= $lang["menu"] ?></div>
        <div class="footer-menu">
          <ul>
            <li><a href="accueil.php"><?= $lang["home"] ?></a></li>
            <li><a href="about.php"><?= $lang["about"] ?></a></li>
            <li><a href="contact.php"><?= $lang["contact_us"] ?></a></li>
            <li><a href="terms.php"><?= $lang["terms_conditions"] ?></a></li>
          </ul>
        </div>
      </div>

      <!-- Droite -->
      <div class="footer-right">
        <div class="column-title"><?= $lang["categories"] ?></div>
        <div class="footer-categories">
          <ul>
            <li><a href="perfume.php"><?= $lang["all_products"] ?></a></li>
            <li><a href="offres.php"><?= $lang["offers"] ?></a></li>
            <li><a href="collections.php"><?= $lang["footer_collections"] ?></a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Bas de page -->
    <div class="footer-bottom">
      <div class="copyright"><?= $lang["copyright"] ?></div>
      <div class="payment-methods">
        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/paypal.svg" alt="PayPal">
        <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/stripe.svg" alt="Stripe">
      </div>
    </div>
  </div>
</footer>
