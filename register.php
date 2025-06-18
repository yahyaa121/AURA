<?php
include "include/init.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $lang["register_title"] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <header>
        <?php include('include/header.php'); ?>
    </header>

    <div class="login-container">
        <div class="login-title"><?= $lang["register_title"] ?></div>
        <div class="login-subtitle"><?= $lang["register_subtitle"] ?></div>

        <form method="post" action="process-register.php">
            <div class="form-group">
                <input type="text" name="name" placeholder="<?= $lang["register_name_placeholder"] ?>" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="<?= $lang["register_email_placeholder"] ?>" required>
            </div>
            <div class="form-group">
                <input type="text" name="adresse" placeholder="<?= $lang["register_address_placeholder"] ?>" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="<?= $lang["register_password_placeholder"] ?>" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="<?= $lang["register_confirm_password_placeholder"] ?>" required>
            </div>
            <button type="submit" class="login-button"><?= $lang["register_button"] ?></button>
        </form>

        <div class="create-account">
            <?= $lang["register_already_account"] ?>
            <a href="connexion.php"> <?= $lang["register_log_in"] ?></a>
        </div>
    </div>

    <div class="newsletter-container">
        <?php include('include/newsletter.php'); ?>
    </div>

    <footer>
        <?php include('include/footer.php'); ?>
    </footer>
</body>
</html>