<?php include('include/header.php'); ?>

<style>
  main {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0 20px;
  }

  .reset-container {
    background-color: #fff;
    max-width: 500px;
    margin: 50px auto;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .reset-container h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 25px;
    color: #333;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 8px;
    color: #444;
  }

  .required-label {
    float: right;
    font-size: 13px;
    color: #777;
  }

  input[type="email"] {
    width: 100%;
    padding: 12px 15px;
    font-size: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
  }

  input[type="email"]:focus {
    border-color: #555;
    outline: none;
  }

  button[type="submit"] {
    width: 100%;
    padding: 14px;
    background-color: #000;
    color: white;
    font-size: 16px;
    font-weight: 600;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  button[type="submit"]:hover {
    background-color: #333;
  } 
</style>
<div class="reset-container">
  <h2>Reset Your Password</h2>
  <form action="#" method="post">
    <div class="form-group">
      <label for="email">
        Email Address <span class="required">*</span>
      </label>
      <span class="required-label">Required</span>
      <input type="email" id="email" name="email" required placeholder="Enter your email address to reset your password">
    </div>
    <button type="submit" name="rest">Reset Password</button>
  </form>
</div>
<?php include('include/newsletter.php'); ?>
<?php include('include/footer.php'); ?>