<?php
session_start();
include('include/init.php');

// Si non connecté, redirection vers la page de connexion
if (!isset($_SESSION["idUser"])) {
    header("Location: connexion.php");
    exit;
}

// Récupération des infos utilisateur depuis la session
$userName = $_SESSION['username'] ?? 'Utilisateur';
$userEmail = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Bienvenue sur votre espace</title>
    <style>
        :root {
            --primary:rgb(2, 116, 127);
            --primary-light: #f4f6fa;
            --bg-light: #f5f7fa;
            --bg-gradient: #f4f6fa;
            --text-main: #23272f;
            --text-secondary: #6b7280;
            --card-bg: #fff;
            --card-radius: 26px;
            --shadow: 0 8px 32px rgba(60, 72, 88, 0.13);
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-gradient);
            color: var(--text-main);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header, footer {
            background: var(--card-bg);
            padding: 18px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        
        
        main {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }
        .dashboard {
            background: var(--card-bg);
            max-width: 400px;
            width: 100%;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
            padding: 56px 32px 36px 32px;
            text-align: left;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 159px;
        }
        .profile-icon {
            width: 84px;
            height: 84px;
            background: linear-gradient(135deg, var(--primary) 60%, var(--primary-light) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -60px auto 18px auto;
            box-shadow: 0 4px 16px rgba(99,102,241,0.13);
            border: 4px solid #fff;
            position: absolute;
            left: 50%;
            top: 0;
            transform: translate(-50%, -50%);
        }
        .profile-icon svg {
            width: 44px;
            height: 44px;
            fill: #fff;
        }
        .dashboard h1 {
            margin-top: 38px;
            margin-bottom: 8px;
            color: var(--text-main);
            font-size: 1.7rem;
            font-weight: 800;
            letter-spacing: 0.01em;
            text-align: center;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard .welcome-msg {
            margin: 0 0 18px 0;
            font-size: 1.08rem;
            color: var(--text-secondary);
            text-align: center;
            font-weight: 500;
        }
        .dashboard .user-info {
            margin: 0 0 18px 0;
            font-size: 1.13rem;
            color: var(--primary);
            text-align: center;
            font-weight: 600;
            word-break: break-all;
        }
        .dashboard .desc {
            margin: 0 0 24px 0;
            font-size: 1rem;
            color: var(--text-secondary);
            text-align: center;
            font-weight: 400;
        }
        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #111;
            color: #fff;
            font-weight: 700;
            padding: 16px 0;
            border-radius: 14px;
            text-decoration: none;
            transition: 
                background 0.2s,
                transform 0.18s,
                box-shadow 0.18s;
            font-size: 1.13rem;
            user-select: none;
            width: 100%;
            box-shadow: 0 4px 16px rgba(0,0,0,0.13);
            border: none;
            outline: none;
            letter-spacing: 0.03em;
            margin-top: 18px;
            cursor: pointer;
            position: relative;
            min-height: 48px; /* ensures good vertical centering */
        }
        .btn-logout:hover, .btn-logout:focus {
            background: #000;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        }
        .btn-logout:focus-visible {
            outline: 3px solid var(--primary);
            outline-offset: 2px;
        }
        @media (max-width: 600px) {
            .dashboard {
                padding: 22px 8px 18px 8px;
                border-radius: 14px;
            }
            .profile-icon {
                width: 64px;
                height: 64px;
                margin-top: -40px;
            }
            .profile-icon svg {
                width: 32px;
                height: 32px;
            }
            .dashboard h1 {
                font-size: 1.15rem;
                margin-top: 28px;
            }
            .btn-logout {
                font-size: 1rem;
                padding: 12px 0;
            }
        }
    </style>
</head>
<body>

<header>
    <?php include('include/header.php'); ?>
</header>

<main>
    <section class="dashboard" aria-label="Logged-in user area">
        <div class="profile-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 16-4 16 0" /></svg>
        </div>
        <h1>Welcome, <?php echo htmlspecialchars($userName); ?> ! 👋</h1>
        <div class="welcome-msg">You are logged in with:</div>
        <div class="user-info"><?php echo htmlspecialchars($userEmail); ?></div>
        <div class="desc">We're glad to see you back.</div>
        <a href="logout.php" class="btn-logout" role="button" aria-label="Log out">Log out</a>
    </section>
</main>

<footer>
    <?php include('include/footer.php'); ?>
</footer>

</body>
</html>
