<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Newsletter Signup</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="include/newsletter.css" />
</head>
<body>
  <div class="bg-image">
    <div class="newsletter">
      <h3><?= $lang['newsletter_title'] ?></h3>
      <p><?= nl2br($lang['newsletter_text']) ?></p>
      <form>
        <input type="email" placeholder="<?= $lang['newsletter_placeholder_email'] ?>" required />
        <button type="submit"><?= $lang['newsletter_button_subscribe'] ?></button>
      </form>
    </div>
  </div>
</body>
</html>
