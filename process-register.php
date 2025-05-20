<?php

if (empty($_POST["name"])) {
    die("Name is required");
}
if (empty($_POST["adresse"])) {
    die("Adresse is required");
}
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}
if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}
if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}
if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}
if ($_POST["password"] !== $_POST["confirm_password"]) {
    die("Passwords must match");
}

require __DIR__ . "/database.php";

$passwordHash = password_hash($_POST["password"], PASSWORD_BCRYPT);
$now = date("Y-m-d H:i:s");

$sql = "INSERT INTO users (username, email, adresse , password, subscriptionDate)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sssss", $_POST["name"], $_POST["email"], $_POST["adresse"], $passwordHash, $now);

if ($stmt->execute()) {
    header("Location: accueil.php");
    exit;
} else {
    if ($mysqli->errno === 1062) {
        if (str_contains($mysqli->error, "username")) {
            die("Username already taken");
        } elseif (str_contains($mysqli->error, "email")) {
            die("Email already taken");
        }
    }
    die("Database error: " . $mysqli->error);
}
