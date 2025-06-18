<?php
if (isset($_POST["reset"])) {

    $email = trim($_POST["email"]);

    if (empty($email)) {
        showError("The email field cannot be empty.");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        showError("Please enter a valid email address.");
        exit;
    }

    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 120); // 50 mins

    $mysqli = require __DIR__ . "/database.php";

    $sql = "UPDATE users
            SET resetToken = ?,
                tokenDate = ?
            WHERE email = ?";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        showError("A server error occurred. Please try again later.");
        exit;
    }

    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {

        $mail = require __DIR__ . "/mailer.php";

        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->isHTML(true);
        $mail->Body = <<<END
            <p>Click <a href="http://localhost/3/reset-password.php?token=$token">here</a> to reset your password. This link will expire in 30 minutes.</p>
        END;

        try {
            $mail->send();
            showSuccess("✔️ Email Sent!", "Please check your inbox to reset your password.", "accueil.php");
        } catch (Exception $e) {
            showError("We couldn't send the email. Please try again later.");
        }

    } else {
        showError("No user found with this email address.");
    }
}

// Success Message Function
function showSuccess($title, $message, $redirect) {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="6;url=$redirect">
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f8f8f8;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .message-box {
                background: #ffffff;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .message-box h2 {
                color: #4CAF50;
            }
            .message-box p {
                color: #555;
            }
        </style>
    </head>
    <body>
        <div class="message-box">
            <h2>$title</h2>
            <p>$message</p>
            <p>Redirecting in a few seconds...</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = '$redirect';
            }, 6000);
        </script>
    </body>
    </html>
    HTML;
}

// Error Message Function
function showError($message) {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="6;url=accueil.php">
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #fff0f0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .error-box {
                background: #ffe6e6;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 0 10px rgba(255, 0, 0, 0.1);
                text-align: center;
            }
            .error-box h2 {
                color: #e53935;
            }
            .error-box p {
                color: #b71c1c;
            }
        </style>
    </head>
    <body>
        <div class="error-box">
            <h2>❌ Error</h2>
            <p>$message</p>
            <p>Redirecting to <strong>Accueil</strong> in a few seconds...</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'accueil.php';
            }, 6000);
        </script>
    </body>
    </html>
    HTML;
}

?>
