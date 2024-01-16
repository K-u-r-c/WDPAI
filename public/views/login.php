<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../../public/css/login.css">
    <title>Login</title>
</head>
<body>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <div class="left-box">
        <div class="login-box">
            <div class="logo"></div>
            <h1 class="motivation-text">Let's log in to your EyeSmart account</h1>
            <h1 class="motivation-text">
                <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                ?>
            </h1>
            <div class="login-block">
                <form action="login" method="POST">
                    <div class="input-fields">
                        <input type="text" name="email" placeholder="E-mail:" required id="email"><br><br>
                        <input type="password" name="password" placeholder="Password:" required id="password"><br><br>
                    </div>
                    <input type="submit" value="Sign In" class="login-button">
                </form>
            </div>
            <a href="#" class="forgot-password">Forgot password ?</a>
            <div class="text-line">OR</div>
            <a href="#" class="login-google">
                <img src="../../public/images/google-icon.svg" class="login-google-icon"/>
                <div class="login-google-text">Sign in with Google</div>
            </a>
            <div class="register-block">
                <p class="register-text">Don't have an account?</p>
                <a href="register" class="register-button">Sign Up</a>
            </div>
        </div>
    </div>
    <div class="right-box"></div>
</body>
</html>
