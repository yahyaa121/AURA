<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AURA</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
    }
    .navbar {
      background-color: white;
      padding: 20px 30px;
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      transition: all 0.3s ease;
      box-shadow: 0 8px 10px -5px rgba(0, 0, 0, 0.3);
      position: static;
    }
    .logo {
      margin-bottom: 20px;
    }
    .logo a {
      text-decoration: none;
      display: inline-block;
    }
    .logo-img {
      height: 55px;
      object-fit: contain;
    }
    .main-nav {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .nav-left,
    .nav-center,
    .nav-right {
      display: flex;
      align-items: center;
    }
    .nav-left {
      justify-content: flex-start;
      flex: 1;
      gap: 25px;
    }
    .nav-center {
      justify-content: center;
      flex: 2;
      gap: 25px;
    }
    .nav-right {
      justify-content: flex-end;
      flex: 1;
      gap: 25px;
    }
    .main-nav a {
      text-decoration: none;
      color: #333;
      font-size: 16px;
      font-weight: 500;
      transition: color 0.3s;
      display: flex;
      align-items: center;
    }
    .main-nav a:hover {
      color: #888;
    }
    .main-nav i {
      font-size: 18px;
    }
    .navbar.sticky {
      position: fixed;
      top: 0;
      width: 100%;
      left: 0;
      z-index: 100;
      background-color: teal;
      color: white;
      padding: 18px 30px;
      transform: translateY(0);
    }
    .navbar.hidden {
      transform: translateY(-100%);
    }
    .navbar.sticky .main-nav a {
      color: white;
    }
    .navbar.sticky .logo-img {
      filter: brightness(0) invert(1);
    }
    .lang-form {
      display: inline-block;
      margin: 0;
      padding: 0;
    }
    .lang-select-wrapper {
      position: relative;
      display: inline-block;
    }
    .lang-select {
      background: transparent;
      border: none;
      outline: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      color: inherit;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      padding-right: 20px;
    }
    .lang-select option {
      background: white;
      color: #333;
    }
    .navbar.sticky .lang-select {
      color: white;
    }
    .lang-select-wrapper::after {
      content: '▼';
      position: absolute;
      right: 5px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 12px;
      pointer-events: none;
      color: #333;
    }
    .navbar.sticky .lang-select-wrapper::after {
      color: white;
    }
    .collection-wrapper {
      position: relative;
      display: inline-block;
    }
    .collection-button {
      background: none;
      border: none;
      color: #333;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      padding-right: 20px;
      position: relative;
    }
    .navbar.sticky .collection-button {
      color: white;
    }
    .collection-wrapper::after {
      content: '▼';
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      font-size: 12px;
      pointer-events: none;
      color: #333;
    }
    .navbar.sticky .collection-wrapper::after {
      color: white;
    }
    .collection-select {
      position: absolute;
      top: 100%;
      left: 0;
      background-color: white;
      border: 1px solid #ccc;
      font-size: 15px;
      padding: 5px;
      display: none;
      z-index: 200;
      min-width: 160px;
    }
    .collection-wrapper:hover .collection-select {
      display: block;
    }
    .collection-list {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .collection-list li {
      padding: 8px 12px;
    }
    .collection-list li button {
      background: none;
      border: none;
      width: 100%;
      text-align: left;
      font-size: 15px;
      cursor: pointer;
      color: #333;
    }
    .collection-list li button:hover {
      background-color: #f0f0f0;
    }
    .navbar.sticky .collection-select {
      background-color: white;
    }
    .navbar.sticky .collection-list li button {
      color: #333;
    }
  </style>
</head>
<body>
  <header class="navbar">
    <div class="logo">
      <a href="accueil.php">
        <img src="aura.png" alt="AURA Logo" class="logo-img" />
      </a>
    </div>
    <nav class="main-nav">
      <div class="nav-left">
        <form method="post" action="change_language.php" class="lang-form">
          <div class="lang-select-wrapper">
            <select name="lang" class="lang-select" onchange="this.form.submit()">
              <option value="fr" selected>FR</option>
              <option value="en">EN</option>
            </select>
          </div>
        </form>
        <a href="#"><i class="fas fa-search"></i></a>
      </div>
      <div class="nav-center">
        <a href="perfume.php">Perfumes</a>
        <div class="collection-wrapper">
          <button type="button" class="collection-button">Collections</button>
          <div class="collection-select">
            <form method="post" action="collections.php">
              <ul class="collection-list">
                <li><button type="submit" name="designer" value="louis_vuitton">Louis Vuitton</button></li>
                <li><button type="submit" name="designer" value="jean_paul_gaultier">Jean Paul Gaultier</button></li>
                <li><button type="submit" name="designer" value="Byerdo">Byerdo</button></li>
              </ul>
            </form>
          </div>
        </div>
        <a href="#">Offres & Discount</a>
        <a href="#">New arrivals</a>
      </div>
      <div class="nav-right">
        <a href="connexion.php"><i class="fas fa-user"></i></a>
        <a href="#"><i class="fas fa-heart"></i></a>
        <a href="#"><i class="fas fa-shopping-cart"></i></a>
      </div>
    </nav>
  </header>
  <script>
    // Sticky navbar on scroll
    let lastScroll = 0;
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
      const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
      if (currentScroll < lastScroll && currentScroll > 10) {
        navbar.classList.add('sticky');
        navbar.classList.remove('hidden');
      } 
      else if (currentScroll > lastScroll) {
        navbar.classList.remove('sticky');
        navbar.classList.add('hidden');
      }
      else if (currentScroll <= 10) {
        navbar.classList.remove('sticky', 'hidden');
      }
      lastScroll = currentScroll <= 0 ? 0 : currentScroll;
    });
  </script>
</body>
</html>