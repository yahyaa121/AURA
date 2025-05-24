<?php
if (isset($_POST["reset"])) {

    $email = $_POST["email"];
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $mysqli = require __DIR__ . "/database.php";

    $sql = "UPDATE users
            SET resetToken = ?,
                tokenDate = ?
            WHERE email = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();

    if ($mysqli->affected_rows) {

        $mail = require __DIR__ . "/mailer.php";

        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->isHTML(true);
        $mail->Body = <<<END
            <p>Click <a href="http://example.com/reset-password.php?token=$token">here</a> to reset your password.</p>
        END;

        try {
            $mail->send();

            // Output HTML+JS to show message and redirect
            echo <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="refresh" content="5;url=accueil.php">
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
                        <h2>✔️ Email Sent!</h2>
                        <p>Please check your inbox to reset your password.</p>
                        <p>Redirecting to <strong>Accueil</strong> in a few seconds...</p>
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = 'accueil.php';
                        }, 6000); // 5 seconds
                    </script>
                </body>
                </html>
            HTML;

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }

    } else {
        echo "No user found with this email address.";
    }
}
?>
