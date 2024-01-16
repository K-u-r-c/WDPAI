<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../public/css/mainApplicationStyle.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/forum.css">
    <script src="../../public/scripts/leftBarToggle.js"></script>
    <script src="../../public/scripts/search.js" defer></script>
    <title>Forum</title>
</head>
<body>
    <?php
    require_once 'src/repository/UserRepository.php';

    $userRepository = new UserRepository();
    $user = $userRepository->getLoggedInUser();

    if ($user !== null) {
        $profilePicturePath = "./public/images/user_profiles/" . $user->getProfileImagePath();
    }
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
            <p class="page-title">Forum - General</p>
            <input type="text" id="searchField" placeholder="Search posts...">
        </div>

        <div class="content">
            <div class="headings">
                <span class="headings-status">Status</span>
                <span class="headings-topics">Topics</span>
                <span class="headings-replies">Replies</span>
                <span class="headings-views">Views</span>
                <span class="headings-users">Users</span>
                <span class="headings-date">Date</span>
            </div>

            <?php
            require_once 'src/repository/PostRepository.php';
            require_once 'src/repository/UserRepository.php';

            $userRepository = new UserRepository();
            $postRepository = new PostRepository();
            $posts = $postRepository->getAllPosts();

            usort($posts, function($a, $b) {
                $statusOrder = ['pinned', 'open', 'resolved'];
                $aStatus = $a->getStatus();
                $bStatus = $b->getStatus();
                $aIndex = array_search($aStatus, $statusOrder);
                $bIndex = array_search($bStatus, $statusOrder);
                return $aIndex - $bIndex;
            });
            ?>

            <ul class="forum-elements">
            <?php foreach ($posts as $post) : ?>
                <?php 
                $status = $post->getStatus();
                $statusImagePath = "";
                $statusColor = "";
                switch ($status) {
                    case 'pinned':
                        $statusImagePath = "../../public/images/status_images/status1.svg";
                        $statusColor = "#FF833E";
                        break;
                    case 'resolved':
                        $statusImagePath = "../../public/images/status_images/status2.svg";
                        $statusColor = "#6EBE45";
                        break;
                    case 'open':
                        $statusImagePath = "../../public/images/status_images/status3.svg";
                        $statusColor = "#C0C0C0";
                        break;
                }

                $profilePicturePath = "./public/images/user_profiles/" . $post->getUserImage();
                ?>

                <li>
                    <a href="#" class="status-element" style="
                        background: url('<?php echo $statusImagePath; ?>') no-repeat 50% / cover;
                        background-color: <?php echo $statusColor; ?>;"
                    ></a>
                    <a href="forum_post?post_id=<?php echo $post->getId(); ?>" class="forum-text"><?php echo $post->getTitle(); ?></a>
                    <span class="forum-replies"> <?php echo $post->getReplies(); ?></span>
                    <span class="forum-views"> <?php echo $post->getViews(); ?></span>
                    <a href="#" class="posted-by-element" style="
                        background: lightgray url('<?php echo $profilePicturePath; ?>') no-repeat 50% / cover;"
                    ></a>
                    
                    <span class="forum-date"> <?php echo date('Y-m-d', strtotime($post->getCreatedAt())); ?></span>
                    <?php 
                    $bIsCurrentUserAdmin = $userRepository->getLoggedInUser()->getIsAdmin();
                    if ($bIsCurrentUserAdmin) :
                    ?>
                    <form class="delete-post-form" action="forum" method="POST">
                        <input type="hidden" name="post_id" value="<?php echo $post->getId(); ?>">
                        <input class="delete-post" type="submit" name="delete_post" value="">
                    </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>

    </div>    
    <a href="#" class="add-post-button" onclick="openForm()"></a>

    <div id="floating-window" class="floating-window">
        <form class="post-form" action="forum" onsubmit="return validateForm()" method="POST">
            <input type="text" name="title" id="title" placeholder="Title" oninput="validateForm()">
            <textarea name="content" id="content" placeholder="Content" oninput="validateForm()"></textarea>

            <?php 
            require_once 'src/repository/UserRepository.php';

            $userRepository = new UserRepository();
            $user = $userRepository->getLoggedInUser();
            ?>

            <input type="hidden" name="user_id" value="<?php echo $user->getIdUser() ?>">
            <input type="submit" id="submit-button" value="Submit" disabled>
            <button class="close-button" onclick="closeForm(event)">Close</button>
        </form>
    </div>

    <script src="../../public/scripts/addPost.js"></script>
</body>
</html>

<template id="post-template">
<li>
    <a href="#" class="status-element" style="
        background: url('') no-repeat 50% / cover;
        background-color:"
    ></a>
    <a href="forum_post?post_id=" class="forum-text"></a>
    <span class="forum-replies"></span>
    <span class="forum-views"></span>
    <a href="#" class="posted-by-element" style="
        background: lightgray url('') no-repeat 50% / cover;"
    ></a>
    
    <span class="forum-date"></span>

    <form class="delete-post-form" action="forum" method="POST">
        <input type="hidden" name="post_id" value="">
        <input class="delete-post" type="submit" name="delete_post" value="">
    </form>
</li>
</template>