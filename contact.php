<?php
include "include/init.php";
include "include/header.php";
?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $lang['contact_title'] ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="contact.css">
</head>
<body>
  <div class="contact-header-bar">
    <span><?= $lang['contact_title'] ?></span>
  </div>

  <div class="contact-container">
    <?php if (isset($_GET['error'])): ?>
      <div class="alert-ui alert-danger-ui">
        <i class="fas fa-exclamation-circle"></i>
        <?php
          switch ($_GET['error']) {
            case 'missing_fields':
              echo $lang['contact_error_missing_fields'] ?? 'Please fill in all required fields.';
              break;
            case 'invalid_phone':
              echo $lang['contact_error_invalid_phone'] ?? 'Invalid phone number format.';
              break;
            case 'invalid_email':
              echo $lang['contact_error_invalid_email'] ?? 'Invalid email address.';
              break;
            default:
              echo $lang['contact_error_general'] ?? 'An error occurred. Please try again.';
          }
        ?>
      </div>
    <?php elseif (isset($_GET['success'])): ?>
      <div class="alert-ui alert-success-ui">
        <i class="fas fa-check-circle"></i>
        <?= $lang['contact_success'] ?? 'Your message has been sent successfully!'; ?>
      </div>
    <?php endif; ?>

    <h1 class="title"><?= $lang['contact_title'] ?></h1>

    <div class="contact-info">
      <div class="info-box">
        <div class="icon"><i class="fas fa-envelope"></i></div>
        <h4><?= $lang['contact_email'] ?></h4>
        <p><?= $lang['contact_email_value'] ?></p>
      </div>
      <div class="info-box">
        <div class="icon"><i class="fab fa-whatsapp"></i></div>
        <h4><?= $lang['contact_whatsapp'] ?></h4>
        <p><?= $lang['contact_whatsapp_value'] ?></p>
      </div>
      <div class="info-box">
        <div class="icon"><i class="fas fa-store"></i></div>
        <h4><?= $lang['contact_online_store'] ?></h4>
        <p><?= $lang['contact_online_store_value'] ?></p>
      </div>
    </div>

    <h2 class="subtitle"><?= $lang['contact_form_title'] ?></h2>

    <div class="contact-form-card">
      <form class="contact-form" method="post" action="contact-process.php">
        <div class="form-row">
          <input type="text" name="name" placeholder="<?= $lang['contact_form_name'] ?>" required>
          <input type="email" name="email" placeholder="<?= $lang['contact_form_email'] ?>" required>
        </div>
        <div class="form-row">
          <input type="text" name="phone" placeholder="<?= $lang['contact_form_phone'] ?>" required>
          <input type="text" name="subject" placeholder="<?= $lang['contact_form_subject'] ?>" required>
        </div>
        <textarea name="message" placeholder="<?= $lang['contact_form_message'] ?>" rows="8" required></textarea>
        <div class="form-check">
          <input type="checkbox" id="terms" name="terms" required>
          <label for="terms"><?= $lang['contact_form_terms'] ?></label>
        </div>
        <button type="submit" class="send-btn"><?= $lang['contact_form_send'] ?></button>
      </form>
    </div>
  </div>
</body>
<?php include "include/footer.php"; ?>
</html>
