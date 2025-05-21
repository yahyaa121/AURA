<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            
            width: 100%;
            max-width: 1400px;
            margin: 60px auto;
            text-align: center;
            flex-grow: 1;
        }

        .login-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .login-subtitle {
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            max-width: 400px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .login-button {
            background-color: black;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            max-width: 400px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 25px;
        }

        .create-account {
            font-weight: bold;
            font-size: 14px;
            margin-top: 20px;
        }

        .newsletter-container {
            background-color:rgb(192, 191, 191);
            width: 100%;
            padding: 20px 0;
            margin-top: auto;
        }

        header, footer {
            background-color: white;
            text-align: center;
            width: 100%;
        }

        
    </style>
</head>
<body>
    <header>
        <?php include('include/header.php'); ?>
    </header>

    <div class="login-container">
        <div class="login-title">CREATE AN ACCOUNT</div>
        <div class="login-subtitle">Fill in the form below to register:</div>

        <form method="post" action="process-register.php">
            <div class="form-group">
                <input type="text" name="name" placeholder="Full name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email address" required>
            </div>
            <div class="form-group">
                <input type="adresse" name="adresse" placeholder="Home address" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm password" required>
            </div>
            <button type="submit" class="login-button">Register</button>
        </form>

        <div class="create-account">
            Already have an account?<a href="connexion.php"> Log in</a>
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
