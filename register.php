<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = trim($_POST["username"]);
    $enteredPassword = trim($_POST["password"]);

    // TODO: Save the user data in a database or some other storage method
    $users = [];

    if (array_key_exists($enteredUsername, $users)) {
        $error = "Username already exists. Please choose a different username.";
    } else {
        $users[$enteredUsername] = [
            'username' => $enteredUsername,
            'password' => $enteredPassword, // TODO: hash this password
        ];

        // TODO: store the user data in a database here

        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="register.css">
    <title>Register</title>
</head>
<body>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <div class="logo"></div>
    <div class="register-block">
        <h1>Register</h1>
        <form action="register.php" method="post">
            <div class="input-fields">
                <input type="text" name="email" placeholder="email:" required id="email"><br><br>
                <input type="text" name="username" placeholder="Username:" required id="username"><br><br>
                <input type="password" name="password" placeholder="Password:" required id="password"><br><br>
                <input type="password" name="repeat-password" placeholder="Repeat password:" required id="repeat-password"><br><br>
            </div>
            <?php if (isset($error)) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>
            <input type="submit" value="Register" class="register-button">
        </form>
        <p class="already-have-account">Already have an account?<a href="login.php" class="login-button">Login</a></p>
    </div>
</body>
</html>
