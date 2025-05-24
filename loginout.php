<?php
session_start();

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
        /* Reset simple */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header, footer {
            background: white;
            padding: 15px 0;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
        }
        main {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }
        .dashboard {
            background: white;
            max-width: 500px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgb(0 0 0 / 0.1);
            padding: 30px;
            text-align: center;
        }
        .dashboard h1 {
            margin-bottom: 10px;
            color: #222;
        }
        .dashboard p {
            margin: 10px 0 25px;
            font-size: 1rem;
            color: #555;
        }
        .btn-logout {
            display: inline-block;
            background-color: #000;
            color: white;
            font-weight: 600;
            padding: 14px 40px;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-size: 1rem;
            user-select: none;
        }
        .btn-logout:hover {
            background-color: #444;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        /* Responsive */
        @media (max-width: 600px) {
            .dashboard {
                padding: 20px;
            }
            .btn-logout {
                width: 100%;
                padding: 14px 0;
            }
        }
    </style>
</head>
<body>

<header>
    <?php include('include/header.php'); ?>
</header>

<main>
    <section class="dashboard" aria-label="Espace utilisateur connecté">
        <h1>Bienvenue, <?php echo htmlspecialchars($userName); ?> ! 👋</h1>
        <p>Vous êtes connecté avec l'adresse : <strong><?php echo htmlspecialchars($userEmail); ?></strong></p>
        <p>Nous sommes ravis de vous revoir.</p>

        <a href="logout.php" class="btn-logout" role="button" aria-label="Se déconnecter">Déconnexion</a>
    </section>
</main>

<footer>
    <?php include('include/footer.php'); ?>
</footer>

</body>
</html>
