<?php
include "include/init.php";
include "include/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Terms & Conditions - Aura</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="terms.css">
</head>
<body>
<div class="terms-header">
<h1><?= $lang['terms_title'] ?></h1>
</div>

  <div class="container">
    <h2><?= $lang['terms_general'] ?></h2>
    <p><?= $lang['terms_general_text'] ?></p>

    <h2><?= $lang['terms_disclaimer'] ?></h2>
    <p><?= $lang['terms_disclaimer_text'] ?></p>

    <h2><?= $lang['terms_info_service'] ?></h2>
    <p><?= $lang['terms_info_service_text'] ?></p>

    <h2><?= $lang['terms_trademarks'] ?></h2>
    <p><?= $lang['terms_trademarks_text'] ?></p>

    <h2><?= $lang['terms_privacy'] ?></h2>
    <p><?= $lang['terms_privacy_text'] ?></p>

    <h2><?= $lang['terms_cookies'] ?></h2>
    <p><?= $lang['terms_cookies_text'] ?></p>

    <h2><?= $lang['terms_links'] ?></h2>
    <p><?= $lang['terms_links_text'] ?></p>

    <h2><?= $lang['terms_payment'] ?></h2>
    <p><?= $lang['terms_payment_text'] ?></p>

    <h2><?= $lang['terms_shipping'] ?></h2>
    <p><?= $lang['terms_shipping_text'] ?></p>

    <h2><?= $lang['terms_cancellation'] ?></h2>
    <p><?= $lang['terms_cancellation_text'] ?></p>

    <h2><?= $lang['terms_faulty'] ?></h2>
    <p><?= $lang['terms_faulty_text'] ?></p>

    <h2><?= $lang['terms_violation'] ?></h2>
    <p><?= $lang['terms_violation_text'] ?></p>

    <h2><?= $lang['terms_force_majeure'] ?></h2>
    <p><?= $lang['terms_force_majeure_text'] ?></p>

    <h2><?= $lang['terms_law'] ?></h2>
    <p><?= $lang['terms_law_text'] ?></p>

    <p><em><?= $lang['terms_last_update'] ?></em></p>
  </div>

<?php include "include/footer.php"; ?>
</body>
</html>
