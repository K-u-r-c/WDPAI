<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../public/css/mainApplicationStyle.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/forum_post.css">
    <script src="../../public/scripts/leftBarToggle.js"></script>
    <title>Forum</title>
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
        <div class="left-bar-big-content">
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
    </div>

    <div class="right-pane">
        <div class="header">
            <?php
            require_once 'src/repository/PostRepository.php';
            require_once 'src/repository/PostReplyRepository.php';

            $postId = $_GET['post_id'];

            $postRepository = new PostRepository();
            $post = $postRepository->getPost($postId);
            $post_title = $post['title'];
            ?>
            <p class="page-title"><?php echo $post_title; ?></p>
        </div>

        <div class="content">
            <?php
            $post_text = $post['content'];
            $postReplyRepository = new PostReplyRepository();
            $comments = $postReplyRepository->getAllRepliesForPost($postId);
            ?>

            <div class="post-text">
                <p><?php echo $post_text; ?></p>
            </div>

            <div class="comments-section">
                <div class="comments-header">
                    <h2>Comments:</h2>
                    <a href="#" class="add-comment-button" onclick="openForm()"></a>
                </div>
                <?php foreach ($comments as $comment): ?>
                    <?php
                    $comment_user_id = $comment->getUserId();
                    $comment_Date = $comment->getDate();
                    $comment_user = $userRepository->getUserById($comment_user_id);
                    $comment_user_name = $comment_user->getName();
                    $comment_user_profile_picture_path = "./public/images/user_profiles/" . $comment_user->getProfileImagePath();
                    ?>

                    <div class="comment">
                        <div class="comment-header">
                            <img src="<?php echo $comment_user_profile_picture_path; ?>" alt="Profile Picture">
                            <h3 class="comment-user-name"><?php echo $comment_user_name ?>:</h3>
                            <p class="comment-date"><?php echo date('Y-m-d H:i', strtotime($comment_Date)); ?></p>
                        </div>
                        <p><?php echo $comment->getContent(); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="floating-window" class="floating-window">
        <form class="comment-form" action="forum_post" onsubmit="return validateForm()" method="POST">
            <textarea name="content" id="content" placeholder="Content" oninput="validateForm()"></textarea>

            <?php 
            require_once 'src/repository/UserRepository.php';

            $userRepository = new UserRepository();
            $user = $userRepository->getLoggedInUser();
            ?>

            <input type="hidden" name="post_id" value="<?php echo $postId ?>">
            <input type="hidden" name="user_id" value="<?php echo $user->getIdUser() ?>">
            <input type="submit" id="submit-button" value="Submit" disabled>
            <button class="close-button" onclick="closeForm(event)">Close</button>
        </form>
    </div>

    <script src="../../public/scripts/addComment.js"></script>
</body>
</html>
