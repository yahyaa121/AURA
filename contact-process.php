<?php
include "database.php"; // Include database connection
include "include/init.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $terms   = isset($_POST['terms']);  // Check if terms checkbox is checked

    // Validate required fields
    if (!$name || !$email || !$phone || !$subject || !$message || !$terms) {
        header("Location: contact.php?error=missing_fields");
        exit;
    }
    // Validate phone number format (basic validation)
    if (!preg_match('/^\+?[0-9\s\-()]+$/', $phone)) {
        header("Location: contact.php?error=invalid_phone");
        exit;
    }
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?error=invalid_email");
        exit;
    }
    //validation
    if ($name && $email && $phone && $subject && $message && $terms) {
        // Prepare and execute insert
        $stmt = $mysqli->prepare("INSERT INTO contact (name, email, phone, subject, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
        $stmt->execute();
        // Redirect or show success
        header("Location: contact.php?success=1");
        exit;
    } else {
        // Redirect or show error
        header("Location: contact.php?error=1");
        exit;
    }
} else {
    header("Location: contact.php");
    exit;
}