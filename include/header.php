<?php
include 'include/init.php';
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
// Only count valid numeric keys > 0
$validCart = array_filter(
    $_SESSION['cart'] ?? [],
    function($v, $k) { return is_numeric($k) && $k > 0; },
    ARRAY_FILTER_USE_BOTH
);
$count = array_sum($validCart);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AURA</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="include/header.css" />
</head>
<body>

  <header class="navbar">
    <button class="nav-toggle" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="main-nav">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <div class="logo">
      <a href="accueil.php">
        <img src="aura.png" alt="AURA Logo" class="logo-img" />
      </a>
    </div>

    <nav class="main-nav" id="main-nav">
      <div class="nav-left">
        <form method="post" action="change_language.php" class="lang-form">
          <div class="lang-select-wrapper">
            <select name="lang" class="lang-select" onchange="this.form.submit()">
             <option value="fr" <?= ($_SESSION['lang'] ?? 'fr') == 'fr' ? 'selected' : '' ?>>FR</option>
             <option value="en" <?= ($_SESSION['lang'] ?? 'fr') == 'en' ? 'selected' : '' ?>>EN</option>
            </select>
          </div>
        </form>

        <form id="searchForm" role="search" autocomplete="off">
          <button type="button" id="searchIcon" aria-label="Afficher la recherche">
            <i class="fas fa-search"></i>
          </button>
          <input 
            type="text" 
            id="searchInput" 
            placeholder="Rechercher un parfum..." 
            aria-label="Rechercher un parfum"
            autocomplete="off"
          />
          <div id="suggestions" role="listbox" aria-label="Suggestions"></div>
        </form>
      </div>
      <div class="nav-center">
        <a href="perfume.php"><?= $lang['perfumes'] ?></a>
        <div class="collection-wrapper">
            <button type="button" class="collection-button"><?= $lang['collections'] ?></button>
            <div class="collection-select">
                <form method="post" action="collections.php">
                    <ul class="collection-list">
                        <li><button type="submit" name="designer" value="louis_vuitton">Louis Vuitton</button></li>
                        <li><button type="submit" name="designer" value="jean_paul_gaultier">Jean Paul Gaultier</button></li>
                        <li><button type="submit" name="designer" value="byredo">Byredo</button></li>
                    </ul>
                </form>
            </div>
        </div>
        <a href="offres.php"><?= $lang['offers'] ?></a>
        <a href="newarrivals.php"><?= $lang['new_arrivals'] ?></a>
      </div>
      <div class="nav-right">
        <a href="connexion.php"><i class="fas fa-user"></i></a>
        <a href="wishlist.php"><i class="fas fa-heart"></i></a>
        <a href="cart.php" class="cart-link" aria-label="Voir le panier">
          <i class="fa fa-shopping-cart"></i>
          <?php if ($count > 0): ?>
            <span class="cart-badge"><?= $count ?></span>
          <?php endif; ?>
        </a>
      </div>
    </nav>
  </header>

  <script>
    // Hamburger menu toggle for mobile
    const navToggle = document.querySelector('.nav-toggle');
    const mainNav = document.querySelector('.main-nav');

    navToggle.addEventListener('click', function() {
      mainNav.classList.toggle('open');
      const expanded = navToggle.getAttribute('aria-expanded') === 'true';
      navToggle.setAttribute('aria-expanded', !expanded);
    });

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

    const items = [
  { name: 'Nouveau Monde', img: 'perfumes/1.png' },
  { name: "Heures d'Absence", img: 'perfumes/2.png' },
  { name: 'Imagination', img: 'perfumes/3.png' },
  { name: 'Fleur du Desert', img: 'perfumes/4.png' },
  { name: 'Ombre Nomade', img: 'perfumes/5.png' },
  { name: 'Apogée', img: 'perfumes/6.png' },
  { name: "Bal d'Afrique", img: 'perfumes/7.jpg' },
  { name: 'Black Saffron', img: 'perfumes/8.jpg' },
  { name: 'Mojave Ghost', img: 'perfumes/8.jpg' },
  { name: 'Super Cedar', img: 'perfumes/10.jpg' },
  { name: 'Rouge Chaotique', img: 'perfumes/11.jpg' },
  { name: 'Sellier', img: 'perfumes/12.jpg' },
  { name: 'Le Male Le Parfum', img: 'perfumes/13.png' },
  { name: 'Ultra Male', img: 'perfumes/14.png' },
  { name: 'Scandal Pour Homme', img: 'perfumes/15.png' },
  { name: 'Divine', img: 'perfumes/16.png' },
  { name: 'Scandal le parfum', img: 'perfumes/17.png' },
  { name: 'Le Male Elixir', img: 'perfumes/18.png' },
];

  const searchIcon = document.getElementById('searchIcon');
  const searchInput = document.getElementById('searchInput');
  const suggestions = document.getElementById('suggestions');

  searchIcon.addEventListener('click', (e) => {
    e.preventDefault(); // prevent default link action
    searchInput.style.display = 'block';
    searchInput.focus();
    searchIcon.style.display = 'none';
  });

  searchInput.addEventListener('input', () => {
  const query = searchInput.value.toLowerCase().trim();

  if (query.length < 1) {
    suggestions.style.display = 'none';
    suggestions.innerHTML = '';
    return;
  }

  const filtered = items.filter(item => item.name.toLowerCase().includes(query));

  if(filtered.length === 0) {
    suggestions.style.display = 'none';
    suggestions.innerHTML = '';
    return;
  }

  suggestions.innerHTML = '';
  filtered.forEach(item => {
    const div = document.createElement('div');
    div.style.display = 'flex';
    div.style.alignItems = 'center';
    div.style.padding = '5px';
    div.style.cursor = 'pointer';

    // Create image element
    const img = document.createElement('img');
    img.src = item.img;
    img.alt = item.name;
    img.style.width = '32px';
    img.style.height = '32px';
    img.style.objectFit = 'cover';
    img.style.marginRight = '10px';
    img.style.borderRadius = '6px';

    // Add image and text
    div.appendChild(img);
    div.appendChild(document.createTextNode(item.name));

    div.addEventListener('click', () => {
      const urlName = encodeURIComponent(item.name);
      window.location.href = `product.php?name=${urlName}`;
    });

    suggestions.appendChild(div);
  });

  suggestions.style.display = 'block';
});

  document.addEventListener('click', e => {
    if (!searchInput.contains(e.target) && !suggestions.contains(e.target) && !searchIcon.contains(e.target)) {
      suggestions.style.display = 'none';
      if(searchInput.value.trim() === '') {
        searchInput.style.display = 'none';
        searchIcon.style.display = 'inline-block';
      }
    }
  });
  
</script>

</body>
</html>
