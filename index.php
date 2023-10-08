<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit;
} else {
    header("Location: dashboard.php"); // Redirect to the dashboard page if logged in
    exit;
}
