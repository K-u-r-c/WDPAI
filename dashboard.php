<?php
  session_start(); // Start the session
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to the Dashboard, <?php echo $_SESSION["username"]; ?> </h2>
    
    <p>This is a protected area. You are logged in.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
