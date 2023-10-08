<?php
session_start();

$validUsername = "123";
$validPassword = "123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    if ($enteredUsername == $validUsername && $enteredPassword == $validPassword) {
        $_SESSION["username"] = $enteredUsername;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="login.css">
    <title>Login</title>
</head>
<body>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <div class="logo"></div>
    <div class="login-block">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="input-fields">
                <input type="text" name="username" placeholder="Username:" required id="username"><br><br>
                <input type="password" name="password" placeholder="Password:" required id="password"><br><br>
            </div>
            <?php if (isset($error)) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>
            <input type="submit" value="Submit" class="login-button">
        </form>
        <p class="new-user">New User?<a href="register.php" class="register-button">Register</a></p>
    </div>
</body>
</html>
