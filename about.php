<?php
include "include/init.php";
include "include/header.php";
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'fr' ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $lang['about_title'] ?></title>
  <style>
    body {
      font-family: 'Helvetica Neue', sans-serif;
      background-color: #f9f9f9;
      color: #333;
      line-height: 1.8;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 900px;
      margin: 80px auto;
      padding: 0 20px;
    }

    h1 {
      font-size: 32px;
      margin-bottom: 0;
      color: rgb(255, 255, 255);
      position: relative;
    }

    h1::after {
      display: none;
    }

    p {
      font-size: 18px;
      margin-bottom: 25px;
    }

    strong {
      color:#0a2e38;
    }

    .teal {
      color: #0a2e38;
      font-weight: bold;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 28px;
      }
      p {
        font-size: 16px;
      }
    }

    .about-header {
      background-color: #2daeba;
      color: #ffe6a7;
      padding: 16px 40px 10px 40px;
      text-align: center;
      margin-bottom: 32px;
    }
  </style>
</head>
<body>
  <div class="about-header">
    <h1><?= $lang['about_title'] ?></h1>
  </div>
  <div class="container">
    <p><strong><?= $lang['about_welcome_strong'] ?></strong> <?= $lang['about_welcome'] ?></p>
    <p><span class="teal"><?= $lang['about_believe_1'] ?></span> <strong><?= $lang['about_believe_strong'] ?></strong> <?= $lang['about_believe_2'] ?></p>
    <p><?= $lang['about_collection'] ?></p>
    <p><strong><?= $lang['about_mission_strong'] ?></strong><br><?= $lang['about_mission'] ?></p>
    <p><?= $lang['about_explore'] ?></p>
  </div>
<?php include "include/footer.php"; ?>
</body>
</html>
