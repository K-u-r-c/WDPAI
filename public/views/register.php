<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../public/css/register.css">
    <title>Register</title>
</head>
<body>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <div class="right-box">
        <div class="register-box">
            <div class="logo"></div>
            <h1 class="motivation-text">Are you ready to start your journey?</h1>
            <div class="register-block">
                <form action="register" method="POST">
                    <div class="messages">
                        <?php
                            if(isset($messages)){
                                foreach($messages as $message) {
                                    echo $message;
                                }
                            }
                        ?>
                    </div>
                    <div class="input-fields">
                        <input type="email" name="email" placeholder="email:" required id="email"><br><br>
                        <input type="text" name="username" placeholder="Username:" required id="username"><br><br>
                        <input type="password" name="password" placeholder="Password:" required id="password"><br><br>
                        <input type="password" name="repeat-password" placeholder="Repeat password:" required id="repeat-password"><br><br>
                    </div>
                    <input type="submit" value="Sign Up" class="register-button">
                </form>
            </div>
            <div class="privacy-policy">
                <p class="privacy-policy-text">By proceeding with the registration procedure, you declare that you have read the <a href="#" class="privacy-policy-link">privacy policy.</a></p>
            </div>
            <div class="text-line">OR</div>
            <a href="#" class="register-google">
                <img src="../../public/images/google-icon.svg" class="register-google-icon"/>
                <div class="register-google-text">Sign up with Google</div>
            </a>
            <div class="login-block">
                <p class="login-text">Already have an account? </p>
                <a href="login" class="login-button">Sign In</a>
            </div>
        </div>
    </div>
    <div class="left-box"></div>
</body>
</html>