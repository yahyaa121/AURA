<?php 
include "include/init.php";
include('include/header.php'); 

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM users WHERE resetToken = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["tokenDate"]) <= time()) {
    die("token has expired");
}
?>


<style>
  body {
    font-family:'Futura PT Medium', Arial, sans-serif;
    background: linear-gradient(120deg, #e8f8f9 0%, #fafdff 100%);
    margin: 0;
    min-height: 100vh;
  }
  .reset-container {
    background: #fff;
    max-width: 420px;
    margin: 60px auto 32px auto;
    padding: 44px 32px 32px 32px;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(45,175,186,0.13), 0 2px 8px rgba(0,0,0,0.06);
    border: 1.5px solid #e0e0e0;
    position: relative;
  }
  .reset-container h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 24px;
    color: #1a8c98;
    letter-spacing: 1px;
    font-weight: 700;
  }
  .form-group {
    margin-bottom: 22px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
  }
  .form-group label {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #2daeba;
    letter-spacing: 0.2px;
  }
  .required {
    color: #d32f2f;
    font-weight: bold;
    margin-left: 2px;
  }
  input[type="email"], input[type="password"] {
    width: 100%;
    padding: 13px 15px;
    font-size: 15px;
    border: 1.5px solid #cce6ea;
    border-radius: 8px;
    background-color: #fafdff;
    box-sizing: border-box;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    box-shadow: 0 1px 6px rgba(45,175,186,0.06);
  }
  input[type="email"]:focus, input[type="password"]:focus {
    border-color: #2daeba;
    box-shadow: 0 2px 10px rgba(45,175,186,0.13);
    background: #f3fcff;
  }
  button[type="submit"] {
    width: 100%;
    padding: 14px 0;
    background: linear-gradient(90deg, #2daeba 0%, #1a8c98 100%);
    color: #fff;
    border: none;
    font-size: 17px;
    font-weight: 700;
    border-radius: 10px;
    box-shadow: 0 4px 16px rgba(45,175,186,0.13);
    letter-spacing: 0.7px;
    text-align: center;
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
    text-transform: uppercase;
  }
  button[type="submit"]:hover {
    background: linear-gradient(90deg, #1a8c98 0%, #2daeba 100%);
    box-shadow: 0 8px 24px rgba(45,175,186,0.18);
    transform: translateY(-2px) scale(1.03);
  }
  @media (max-width: 600px) {
    .reset-container {
      max-width: 98vw;
      padding: 24px 8px 18px 8px;
    }
  }
</style>

<div class="reset-container">
  <h2>Reset Password</h2>
  <?php if ($token): ?>
    <form action="reset-pwd-database.php" method="post">
      <div class="form-group">
        <label for="password">
          New Password <span class="required">*</span>
        </label>
        <input type="password" id="password" name="password" required placeholder="Enter a new password">
      </div>
      <div class="form-group">
        <label for="password_confirm">
          Confirm Password <span class="required">*</span>
        </label>
        <input type="password" id="password_confirm" name="password_confirm" required placeholder="Confirm your new password">
      </div>
      <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
      <button type="submit" name="change_password">Changer le mot de passe</button>
    </form>
  <?php endif; ?>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br>
<?php include('include/footer.php'); ?>