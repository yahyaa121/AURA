<?php
session_start();

$error = null;
if (isset($_SESSION['idUser'])) {
    // User already logged in, redirect to loginout.php
    header("Location: loginout.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";
    $email = strtolower(trim($_POST["email"] ?? ''));
    $password = $_POST["password"] ?? '';

    // Prepared statement
    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id();
        $_SESSION["idUser"] = $user["idUser"];
        $_SESSION['email'] = $user['email'];
        $_SESSION['username'] = $user['username'];
        header("Location: loginout.php"); // redirect after login
        exit;
    } else {
        $error = "Incorrect email or password. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <?php include('include/header.php'); ?>
    </header>

    <?php if ($error): ?>
        <div class="error">
            <i class="fas fa-exclamation-circle" style="margin-right:8px;"></i>
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="post" class="login-container" novalidate>
        <div class="login-title">LOGIN</div>
        <div class="login-subtitle">Please enter your email and password:</div>

        <div class="form-group">
            <input type="email" id="email" name="email" placeholder="Enter your email"
                   value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
        </div>

        <div class="form-group">
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>

        <div class="forgot-password">
            <a href="reset_request.php">Forgotten password?</a>
        </div>

        <button type="submit" class="login-button">Login</button>

        <div class="create-account">
            <a href="register.php">CREATE AN ACCOUNT</a>
        </div>

        <div class="benefits">
            <div class="benefit">
                <div class="benefit-icon"><i class="fas fa-truck"></i></div>
                <div class="benefit-title">FREE DELIVERY</div>
                <div class="benefit-subtitle">for all orders</div>
            </div>
            <div class="benefit">
                <div class="benefit-icon"><i class="fas fa-gift"></i></div>
                <div class="benefit-title">FREE SAMPLES</div>
                <div class="benefit-subtitle">with every order</div>
            </div>
            <div class="benefit">
                <div class="benefit-icon"><i class="fas fa-lock"></i></div>
                <div class="benefit-title">SECURE PAYMENT</div>
                <div class="benefit-subtitle">100% protected</div>
            </div>
        </div>
    </form>

    <div class="newsletter-container">
        <?php include('include/newsletter.php'); ?>
    </div>
<br><br><br><br>
    <footer>
        <div class="footer-content">
            <?php include('include/footer.php'); ?>
        </div>
    </footer>
</body>
</html>