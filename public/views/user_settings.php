<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../public/css/mainApplicationStyle.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/user_settings.css">
    <script src="../../public/scripts/leftBarToggle.js"></script>
    <title>User - Settings</title>
</head>
<body>
    <?php
    require_once 'src/repository/UserRepository.php';

    $userRepository = new UserRepository();
    $user = $userRepository->getLoggedInUser();

    $profilePicturePath = "./public/images/user_profiles/" . $user->getProfileImagePath();
    ?>

    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    
    <div class="left-bar-small">
        <button onclick="toggleLeftBarBig()" class="toggleLeftBarButton"></button>
        <a href="#" class="help"></a>

        <a href="user_settings" class="user" style="
            background: url('<?php echo $profilePicturePath; ?>') no-repeat 50% / cover;"
        ></a>
    </div>

    <div class="left-bar-big">
        <div class="logo">
            <span class="logo-e">E</span><span>ye</span><span class="logo-s">S</span><span>mart</span>
        </div>
        <div class="items">
            <ul class="top-list">
                <ul class="work-time-list">
                    <p class="work-time-text">Work time</p>
                    <li><div class="icon-text"><img src="./../public/images/clock.svg"/><a href="#"><span>Clock</span></a></div></li>
                    <li><div class="icon-text"><img src="./../public/images/heatmap.svg"/><a href="#"><span>Heatmap</span></a></div></li>
                    <li><div class="icon-text"><img src="./../public/images/notifications.svg"/><a href="#"><span>Notification</span></a></div></li>
                </ul>
                <ul class="forum-list">
                    <p class="forum-text">Forum</p>
                    <li><div class="icon-text"><img src="./../public/images/forum-general.svg"/><a href="forum"><span>General</span></a></div></li>
                    <li><div class="icon-text"><img src="./../public/images/experts.svg"/><a href="#"><span>Experts</span></a></div></li>
                    <li><div class="icon-text"><img src="./../public/images/friends.svg"/><a href="#"><span>Friends</span></a></div></li>
                    <li><div class="icon-text"><img src="./../public/images/add-new.svg"/><a href="#"><span>Add new</span></a></div></li>
                </ul>
                <ul class="services-list">
                    <p class="services-text">Services</p>
                    <li><div class="icon-text"><img src="./../public/images/shop.svg"/><a href="#"><span>Shop</span></a></div></li>
                    <li><div class="icon-text"><img src="./../public/images/rewards.svg"/><a href="#"><span>Rewards</span></a></div></li>
                    <li><div class="icon-text"><img src="./../public/images/statistics.svg"/><a href="#"><span>Statistics</span></a></div></li>
                    <li><div class="icon-text"><img src="./../public/images/education.svg"/><a href="#"><span>Education</span></a></div></li>
                </ul>
            </ul>
        </div>
    </div>

    <div class="right-pane">
        <div class="header">
            <p class="page-title">User - Settings</p>
        </div>

        <div class="content">
            <?php
            $username = $user->getName();
            $email = $user->getEmail();
            ?>

            <div class="profile-container">
                <div class="profile-header">
                    <img src="<?php echo $profilePicturePath; ?>" alt="Profile Picture" width="200">
                    <h1><?php echo $username; ?></h1>
                </div>

                <form action="change_user_settings" method="POST" ENCTYPE="multipart/form-data">
                    <div class="form-field">
                        <label for="file">Profile picture:</label>
                        <input type="file" name="file"/><br/>
                    </div>

                    <div class="form-field">
                        <label for="username">Username:</label>
                        <input type="text" class="username" name="username" placeholder="Username" value="<?php echo $username; ?>" required disabled>
                    </div>
                    
                    <div class="form-field">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required disabled>
                    </div>
                    
                    <div class="form-field">
                        <label for="password">New password:</label>
                        <input type="password" id="password" name="password">
                    </div>
                    
                    <div class="form-field">
                        <label for="confirm-password">Confirm password:</label>
                        <input type="password" id="confirm-password" name="confirm-password">
                        <span id="password-warning" style="color: red; display: none;">Passwords do not match!</span>
                    </div>

                    <input type="hidden" name="id_user" value="<?php echo $user->getIdUser() ?>">

                    <div class="form-field">
                        <input type="submit" value="Save" id="submit-button">
                    </div>

                    <script src="../../public/scripts/userSettingsFormSubmit.js"></script>
                </form>
                
                <form action="logout" method="post">
                    <input class="logout-button" type="submit" name="logout" value="Logout">
                </form>
            </div>
        </div>
    </div>
</body>
</html>