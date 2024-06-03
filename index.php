<?php
session_start();
require "connection.php";

$isUserValied;

if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
    $isUserValied = true;
} else {
    $isUserValied = false;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Help Hub - Helping You Help Others</title>
    <link rel="stylesheet" href="bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="resources/images/source_images/icon.ico" />
</head>

<body onload="mainPostPreLoader();<?php if ($isUserValied) {
                                        echo ('messageNotificationCountLoadStarter(); notificationCountLoadStarter();');
                                    } ?>">
    <div class="container-fluid">
        <div class="row">
            <!-- main header -->
            <div class="col-12 pb-3 d-flex flex-row justify-content-between border-bottom">
                <div class="d-flex flex-row justify-content-start align-items-center">
                    <!-- left side offcanvas -->
                    <button class="def-dropdown-btn ps-3 pe-3 d-flex flex-row justify-content-center align-items-center mt-3 d-block d-md-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><i class="bi bi-list" data-bs-toggle="tooltip" data-bs-title="Open navigation" data-bs-custom-class="custom-tooltip"></i></button></button>

                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header d-flex flex-row justify-content-end">
                            <button type="button" class="btn-close def-dropdown-btn rounded-5" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body side-bar-wrapper">
                            <div class="col-12">
                                <div class="list-group">
                                    <div class="col-12">
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0 def-list-item-active"><i class="bi bi-house-door-fill fs-5"></i>&nbsp;&nbsp;Home</button>
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-fire fs-5"></i>&nbsp;&nbsp;Popular</button>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12">
                                        <button class="list-group-item list-group-item-action def-list-item rounded-5 border-0 fs-6 d-flex flex-row justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#offcanvas-collapseExample1" id="offcanvas-collapse-parent-btn1" onclick="collapseIconTogglerStart('offcanvas-collapse-parent-btn1','Categories');">Categories&nbsp;&nbsp;<i class="bi bi-chevron-up"></i></button>
                                        <div class="collapse" id="offcanvas-collapseExample1">
                                            <div class="card card-body ps-0 pe-0 m-0 border-0">
                                                <?php
                                                $categoryResultset = Database::search("SELECT * FROM `category`");
                                                $categoryRownumber = $categoryResultset->num_rows;

                                                if ($categoryRownumber > 0) {
                                                    for ($x = 0; $x < $categoryRownumber; $x++) {
                                                        $categoryData = $categoryResultset->fetch_assoc();
                                                ?>
                                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0" onclick="mainPostPreLoader(null,'<?php echo ($categoryData['id']); ?>',null);"><i class="bi bi-bookmark fs-6"></i>&nbsp;&nbsp;<?php echo ($categoryData["c_name"]); ?></button>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12">
                                        <button class="list-group-item list-group-item-action def-list-item rounded-5 border-0 fs-6 d-flex flex-row justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#offcanvas-collapseExample2" id="offcanvas-collapse-parent-btn2" onclick="collapseIconTogglerStart('offcanvas-collapse-parent-btn2','Tags');">Tags&nbsp;&nbsp;<i class="bi bi-chevron-up"></i></button>
                                        <div class="collapse" id="offcanvas-collapseExample2">
                                            <div class="card card-body ps-0 pe-0 m-0 border-0">
                                                <?php
                                                $tagResultset = Database::search("SELECT * FROM `tags`");
                                                $tagRownumber = $tagResultset->num_rows;

                                                if ($tagRownumber > 0) {
                                                    for ($y = 0; $y < $tagRownumber; $y++) {
                                                        $tagData = $tagResultset->fetch_assoc();
                                                ?>
                                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0" onclick="mainPostPreLoader(null,null,'<?php echo ($tagData['id']); ?>');"><i class="bi bi-tag fs-6"></i>&nbsp;&nbsp;<?php echo ($tagData["t_name"]); ?></button>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12">
                                        <button class="list-group-item list-group-item-action def-list-item rounded-5 border-0 fs-6 d-flex flex-row justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#offcanvas-collapseExample3" id="offcanvas-collapse-parent-btn3" onclick="collapseIconTogglerStart('offcanvas-collapse-parent-btn3','Resources');">Resources&nbsp;&nbsp;<i class="bi bi-chevron-up"></i></button>
                                        <div class="collapse" id="offcanvas-collapseExample3">
                                            <div class="card card-body ps-0 pe-0 m-0 border-0">
                                                <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-crosshair fs-5"></i>&nbsp;&nbsp;About Help Hub</button>
                                                <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-info-circle fs-5"></i>&nbsp;&nbsp;Help</button>
                                                <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-book fs-5"></i>&nbsp;&nbsp;Blog</button>
                                                <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-wrench-adjustable fs-5"></i>&nbsp;&nbsp;Careers</button>
                                            </div>
                                        </div>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-vector-pen fs-5"></i>&nbsp;&nbsp;Content Policy</button>
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-shield-exclamation fs-5"></i>&nbsp;&nbsp;Privacy Policy</button>
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-file-text fs-5"></i>&nbsp;&nbsp;User Agreement</button>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12 pt-4 pb-5">
                                        <a class="def-link" href="#">Help Hub, org. &copy; <?php echo (date("Y")); ?>. All rights reserved.</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- left side offcanvas -->
                    <div>
                        <button class="border-0 bg-transparent pt-3 pt-md-3 pt-lg-0 " onclick="window.location='index.php';">
                            <img class="img-fluid main-logo" src="resources/images/source_images/logo.png" alt="main-logo" />
                        </button>
                    </div>
                </div>
                <!-- search bar -->
                <div class="w-100 d-flex flex-row justify-content-center align-items-center pt-3 ps-3 pe-3 d-none d-md-none d-lg-block">
                    <div class="d-flex flex-row search-component p-2 my-auto">
                        <button class="bg-transparent border-0" onclick="searchPost();"><i class="bi bi-search ps-2 pe-2" data-bs-toggle="tooltip" data-bs-title="Search posts" data-bs-custom-class="custom-tooltip"></i></button>
                        <input type="text" class="search-input flex-grow-1" placeholder="Search Help Hub" id="main-search-text" onkeyup="serachBarsValueBalancer(false);" />
                        <button class="bg-transparent border-0" onclick="clearSearchText();">
                            <i class="bi bi-x-circle" data-bs-toggle="tooltip" data-bs-title="Clear serach text" data-bs-custom-class="custom-tooltip"></i>
                        </button>
                    </div>
                </div>
                <!-- search bar -->
                <!-- dropdown content -->
                <div class="pt-3 my-auto d-flex flex-row gap-3">
                    <?php
                    if ($isUserValied) {
                    ?>
                        <!-- profile feacture section -->
                        <div class="d-flex flex-row gap-3">
                            <div>
                                <div class="dropdown">
                                    <button class="def-dropdown-btn d-flex flex-row justify-content-center align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="shortMessageLoadStarter();">
                                        <i class="bi bi-chat-square-dots-fill fs-5" data-bs-toggle="tooltip" data-bs-title="Private Messages" data-bs-custom-class="custom-tooltip"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle rounded-pill badge-modify ps-1 pe-1" id="message-notification-count-loader">
                                            <div class="spinner-border def-modal-spinner def-sender-message-box-color" role="status"></div>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu def-dropdown-menu mt-2 p-2 shadow">
                                        <li class="ps-4 pt-3 pb-3"><span class="def-list-item">MESSAGES</span></li>
                                        <!-- short message loading area -->
                                        <li class="my-auto modal-content-wrapper emoji-content-wrapper def-message-menu p-1" id="short-message-loading-area">
                                            <!-- chat per-loading card -->
                                            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                                                <div class="spinner-border def-modal-spinner mt-5" role="status"></div>
                                                <span class="mb-5">Users loading...</span>
                                            </div>
                                            <!-- chat per-loading card -->
                                        </li>
                                        <!-- short message loading area -->
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <button class="def-dropdown-btn d-flex flex-row justify-content-center align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="notificationLoadStarter();">
                                        <i class="bi bi-bell-fill fs-5" data-bs-toggle="tooltip" data-bs-title="Notifications" data-bs-custom-class="custom-tooltip"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle rounded-pill badge-modify ps-1 pe-1" id="notification-count-loader">
                                            <div class="spinner-border def-modal-spinner def-sender-message-box-color" role="status"></div>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu def-dropdown-menu mt-2 p-2 shadow">
                                        <li class="ps-4 pt-3 pb-3"><span class="def-list-item">NOTIFICATIONS</span></li>
                                        <!-- notification loading area -->
                                        <li class="my-auto modal-content-wrapper emoji-content-wrapper def-notification-menu p-1" id="notification-loading-area">
                                            <!-- notification per-loading card -->
                                            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                                                <div class="spinner-border def-modal-spinner mt-5" role="status"></div>
                                                <span class="mb-5">Notifcations loading...</span>
                                            </div>
                                            <!-- notification per-loading card -->
                                        </li>
                                        <!-- notification loading area -->
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex flex-row">
                                <button class="bg-transparent border-0" data-bs-toggle="tooltip" data-bs-title="Update profile" data-bs-custom-class="custom-tooltip" onclick="userProfileContentLoad();">
                                    <?php
                                    $isUserProfileImageSet;
                                    $allProfileImageNameArray = scandir("resources/images/profile_images/");
                                    $targetProfileImageName = explode("@", $_SESSION["user"]["email"])[0] . ".jpeg";

                                    foreach ($allProfileImageNameArray as $imageFileName) {
                                        if ($imageFileName == $targetProfileImageName) {
                                            $isUserProfileImageSet = true;
                                            break;
                                        } else {
                                            $isUserProfileImageSet = false;
                                        }
                                    }

                                    if ($isUserProfileImageSet) {
                                    ?>
                                        <img src="resources/images/profile_images/<?php echo (explode("@", $_SESSION["user"]["email"])[0] . ".jpeg"); ?>" class="header-profile-image border" alt="profile_image" />
                                    <?php
                                    } else {
                                    ?>
                                        <img src="resources/images/profile_images/def-profile.svg" class="header-profile-image border" alt="profile_image" />
                                    <?php
                                    }
                                    ?>
                                </button>
                                <div class="d-flex flex-column profile-name-wrapper">
                                    <span class="post-header"><?php echo ($_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"]); ?></span>
                                    <span class="profile-username">@<?php echo ($_SESSION["user"]["username"]); ?></span>
                                </div>
                            </div>
                        </div>
                        <!-- profile feacture section -->
                    <?php
                    } else {
                    ?>
                        <button class="def-btn1" onclick="showModal('modal1');" data-bs-toggle="tooltip" data-bs-title="Log in to Help Hub" data-bs-custom-class="custom-tooltip">Log In</button>
                    <?php
                    }
                    ?>
                    <div class="dropdown">
                        <button class="def-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots" data-bs-toggle="tooltip" data-bs-title="Open settings menu" data-bs-custom-class="custom-tooltip"></i></button>
                        <ul class="dropdown-menu def-dropdown-menu p-1 mt-2 shadow">
                            <?php
                            if ($isUserValied) {
                            ?>
                                <li class="my-auto"><a class="dropdown-item" href="#" onclick="allLoadStarterStop();signOut();"><i class="bi bi-power fs-5"></i>&nbsp;&nbsp;Log In / Sign Up</a></li>
                            <?php
                            }
                            ?>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-info-circle fs-5"></i>&nbsp;&nbsp;Cordinate Help</a></li>
                        </ul>
                    </div>
                </div>
                <!-- dropdown content -->
            </div>
            <!-- main header -->
            <!-- main content section -->
            <div class="col-12">
                <div class="row">
                    <!-- left side panel -->
                    <div class="col-12 col-md-12 col-lg-2 position-fixed d-none d-md-none d-lg-block">
                        <div class="row side-bar-wrapper ps-2 pt-3 pb-2">
                            <div class="col-12">
                                <div class="list-group">
                                    <div class="col-12">
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0 def-list-item-active" onclick="window.location='index.php';"><i class="bi bi-house-door-fill fs-5"></i>&nbsp;&nbsp;Home</button>
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-fire fs-5"></i>&nbsp;&nbsp;Popular</button>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12">
                                        <button class="list-group-item list-group-item-action def-list-item rounded-5 border-0 fs-6 d-flex flex-row justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" id="collapse-parent-btn1" onclick="collapseIconTogglerStart('collapse-parent-btn1','Categories');">Categories&nbsp;&nbsp;<i class="bi bi-chevron-up"></i></button>
                                        <div class="collapse" id="collapseExample1">
                                            <div class="card card-body ps-0 pe-0 m-0 border-0">
                                                <?php
                                                $categoryResultset2 = Database::search("SELECT * FROM `category`");
                                                $categoryRownumber2 = $categoryResultset2->num_rows;

                                                if ($categoryRownumber2 > 0) {
                                                    for ($y = 0; $y < $categoryRownumber2; $y++) {
                                                        $categoryData2 = $categoryResultset2->fetch_assoc();
                                                ?>
                                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0" onclick="mainPostPreLoader(null,'<?php echo ($categoryData2['id']); ?>',null);"><i class="bi bi-bookmark fs-6"></i>&nbsp;&nbsp;<?php echo ($categoryData2["c_name"]); ?></button>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12">
                                        <button class="list-group-item list-group-item-action def-list-item rounded-5 border-0 fs-6 d-flex flex-row justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" id="collapse-parent-btn2" onclick="collapseIconTogglerStart('collapse-parent-btn2','Tags');">Tags&nbsp;&nbsp;<i class="bi bi-chevron-up"></i></button>
                                        <div class="collapse" id="collapseExample2">
                                            <div class="card card-body ps-0 pe-0 m-0 border-0">
                                                <?php
                                                $tagResultset2 = Database::search("SELECT * FROM `tags`");
                                                $tagRownumber2 = $tagResultset2->num_rows;

                                                if ($tagRownumber2 > 0) {
                                                    for ($y = 0; $y < $tagRownumber2; $y++) {
                                                        $tagData2 = $tagResultset2->fetch_assoc();
                                                ?>
                                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0" onclick="mainPostPreLoader(null,null,'<?php echo ($tagData2['id']); ?>');"><i class="bi bi-tag fs-6"></i>&nbsp;&nbsp;<?php echo ($tagData2["t_name"]); ?></button>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12">
                                        <button class="list-group-item list-group-item-action def-list-item rounded-5 border-0 fs-6 d-flex flex-row justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample3" id="collapse-parent-btn3" onclick="collapseIconTogglerStart('collapse-parent-btn3','Resources');">Resources&nbsp;&nbsp;<i class="bi bi-chevron-up"></i></button>
                                        <div class="collapse" id="collapseExample3">
                                            <div class="card card-body ps-0 pe-0 m-0 border-0">
                                                <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-crosshair fs-5"></i>&nbsp;&nbsp;About Help Hub</button>
                                                <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-info-circle fs-5"></i>&nbsp;&nbsp;Help</button>
                                                <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-book fs-5"></i>&nbsp;&nbsp;Blog</button>
                                                <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-wrench-adjustable fs-5"></i>&nbsp;&nbsp;Careers</button>
                                            </div>
                                        </div>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-vector-pen fs-5"></i>&nbsp;&nbsp;Content Policy</button>
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-shield-exclamation fs-5"></i>&nbsp;&nbsp;Privacy Policy</button>
                                        <button type="button" class="list-group-item list-group-item-action def-list-item rounded-5 border-0"><i class="bi bi-file-text fs-5"></i>&nbsp;&nbsp;User Agreement</button>
                                        <hr class="def-hr" />
                                    </div>
                                    <div class="col-12 pt-4 pb-5">
                                        <a class="def-link" href="#">Help Hub, org. &copy; <?php echo (date("Y")); ?>. All rights reserved.</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- left side panel -->
                    <!-- main post area -->
                    <div class="col-12 col-md-12 col-lg-7 offset-0 offset-md-0 offset-lg-2 ps-3 ps-md-3 ps-lg-4 pt-3">
                        <div class="row">
                            <!-- new post send area -->
                            <div class="col-12 d-flex flex-row justify-content-between">
                                <button class="def-btn2 ps-3 pt-2 pb-2 pe-3" <?php
                                                                                if ($isUserValied) {
                                                                                ?> onclick="showModal('modal3');" <?php
                                                                                                                } else {
                                                                                                                    ?> onclick="showModal('modal1');" <?php
                                                                                                                                                    }
                                                                                                                                                        ?>>Create post</button>
                                <!-- mini serachbar -->
                                <div class="d-block d-md-block d-lg-none d-flex flex-row flex-grow-1 ps-3 pe-3">
                                    <div class="d-flex flex-row search-component p-2 my-auto">
                                        <button class="bg-transparent border-0" onclick="searchPost();"><i class="bi bi-search ps-2 pe-2" data-bs-toggle="tooltip" data-bs-title="Search posts" data-bs-custom-class="custom-tooltip"></i></button>
                                        <input type="text" class="search-input flex-grow-1" placeholder="Search Help Hub" id="main-search-text2" onkeyup="serachBarsValueBalancer(true);" />
                                        <button class="bg-transparent border-0" onclick="clearSearchText();">
                                            <i class="bi bi-x-circle" data-bs-toggle="tooltip" data-bs-title="Clear serach text" data-bs-custom-class="custom-tooltip"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- mini serachbar -->
                                <div class="dropdown">
                                    <button class="def-dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-grid" data-bs-toggle="tooltip" data-bs-title="Change post view" data-bs-custom-class="custom-tooltip"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-start def-dropdown-menu p-1 mt-2 shadow">
                                        <li class="my-auto"><a class="dropdown-item" href="#"><i class="bi bi-view-stacked fs-5"></i>&nbsp;&nbsp;Card</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-view-list fs-5"></i>&nbsp;&nbsp;Classic</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- new post send area -->
                            <!-- post loading area -->
                            <div class="col-12 pt-3">
                                <div class="row main-post-wrapper pe-1 pb-3" id="main-posts-load-area"></div>
                            </div>
                            <!-- post loading area -->
                        </div>
                    </div>
                    <!-- main post area -->
                    <!-- right side panel -->
                    <div class="col-12 col-md-12 col-lg-3 d-none d-md-none d-lg-block ps-2 pt-3 pb-2">
                        <div class="row ps-3 pe-3">
                            <!-- category section -->
                            <div class="col-12 def-card p-3">
                                <div class="row ps-2 pe-2">
                                    <div class="col-12 pb-2">
                                        <span class="def-list-item">FOLLOWING CATEGORIES</span>
                                    </div>
                                    <div class="col-12">
                                        <div class="row gap-2">
                                            <?php
                                            if ($isUserValied) {
                                                $categoryResultset3 = Database::search("SELECT * FROM `category`");
                                                $categoryRownumber3 = $categoryResultset3->num_rows;

                                                if ($categoryRownumber3 > 0) {
                                                    for ($a = 0; $a < $categoryRownumber3; $a++) {
                                                        $categoryData3 = $categoryResultset3->fetch_assoc();
                                                        $isCategoryFound = false;

                                                        $userHasCategoryResultset = Database::search("SELECT * FROM `user_has_category` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
                                                        $userHasCategoryRownumber = $userHasCategoryResultset->num_rows;

                                                        for ($b = 0; $b < $userHasCategoryRownumber; $b++) {
                                                            $userHasCategoryData = $userHasCategoryResultset->fetch_assoc();

                                                            if ($categoryData3["id"] == $userHasCategoryData["category_id"]) {
                                                                $isCategoryFound = true;
                                                                break;
                                                            } else {
                                                                $isCategoryFound = false;
                                                            }
                                                        }

                                                        if ($isCategoryFound) {
                                            ?>
                                                            <button class="def-btn2 comment-btn-mod rounded-5 ps-3 pe-3 pt-1 pb-1" id="following-category-btn<?php echo ($a); ?>" onclick="updateFollowingCategory('<?php echo ($categoryData3['id']); ?>','<?php echo ($a); ?>');"><?php echo ($categoryData3["c_name"]); ?></button>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <button class="comment-btn comment-btn-mod rounded-5 ps-3 pe-3 pt-1 pb-1" id="following-category-btn<?php echo ($a); ?>" onclick="updateFollowingCategory('<?php echo ($categoryData3['id']); ?>','<?php echo ($a); ?>');"><?php echo ($categoryData3["c_name"]); ?></button>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else {
                                                $categoryResultset4 = Database::search("SELECT * FROM `category`");
                                                $categoryRownumber4 = $categoryResultset4->num_rows;

                                                if ($categoryRownumber4 > 0) {
                                                    for ($z = 0; $z < $categoryRownumber4; $z++) {
                                                        $categoryData4 = $categoryResultset4->fetch_assoc();
                                                        ?>
                                                        <button class="comment-btn comment-btn-mod rounded-5 ps-3 pe-3 pt-1 pb-1" onclick="showModal('modal1');"><?php echo ($categoryData4["c_name"]); ?></button>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- category section -->
                            <!-- popular post section -->
                            <div class="col-12 def-card p-3 mt-3">
                                <div class="row ps-2 pe-2">
                                    <div class="col-12 pb-2">
                                        <span class="def-list-item">POPULAR POSTS</span>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <?php
                                            $popularPostResultset = Database::search("SELECT * FROM `posts` WHERE `id` IN 
                                                (SELECT posts_id FROM vote GROUP BY posts_id
                                                HAVING COUNT(posts_id) > 0 ORDER BY COUNT(`posts_id`) DESC) LIMIT 4");
                                            $popularPostRownumber = $popularPostResultset->num_rows;

                                            if ($popularPostRownumber > 0) {
                                                for ($p = 0; $p < $popularPostRownumber; $p++) {
                                                    $popularPostData = $popularPostResultset->fetch_assoc();
                                            ?>
                                                    <!-- popular post -->
                                                    <a href="#" class="def-popular-post rounded-5 border-0 text-decoration-none" onclick="window.location='postView.php?pst_id=<?php echo ($popularPostData['id']); ?>';">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-3 p-2 d-flex flex-row justify-content-end align-items-start my-auto">
                                                                    <?php
                                                                    $popularPostImageResultset = Database::search("SELECT * FROM `posts_has_post_images` INNER JOIN `post_images` ON 
                                                                        `posts_has_post_images`.`post_images_id`=`post_images`.`id` WHERE `posts_id`='" . $popularPostData["id"] . "' LIMIT 1");
                                                                    $popularPostImageRownumber = $popularPostImageResultset->num_rows;

                                                                    if ($popularPostImageRownumber > 0) {
                                                                        $popularPostImageData = $popularPostImageResultset->fetch_assoc();
                                                                    ?>
                                                                        <img src="resources/images/post_images/<?php echo ($popularPostImageData["path"]); ?>" class="img-fluid popular-post-img" alt="popular-post-image" />
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <img src="resources/images/source_images/post.svg" class="img-fluid popular-post-img" alt="popular-post-image" />
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="col-9 my-auto">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <span class="popular-post-header def-text-wrapper"><?php echo ($popularPostData["title"]); ?></span>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <span class="def-text-wrapper popular-post-content-wrapper"><?php echo ($popularPostData["content"]); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <!-- popular post -->
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <!-- empty popular post -->
                                                <div class="col-12 pt-5 pb-5 d-flex flex-row justify-content-center">
                                                    <span>No popular posts</span>
                                                </div>
                                                <!-- empty popular post -->
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- popular post section -->
                        </div>
                    </div>
                    <!-- right side panel -->
                </div>
            </div>
            <!-- main content section -->
            <!-- user signin/signup modal -->
            <div class="modal fade" id="modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content def-modal p-3">
                        <div class="modal-header border-0">
                            <button type="button" class="def-dropdown-btn rounded-5 btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="modalReset();"></button>
                        </div>
                        <div class="modal-body modal-content-wrapper">
                            <div class="row">
                                <!-- signin section -->
                                <div class="col-12" id="signin-section">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="post-header">Sign In</h4>
                                            <span class="modal-small-text">By continuing, you agree to our <a href="#" class="def-modal-link">User Agreement</a> and acknowledge that you understand the <a href="#" class="def-modal-link">Privacy Policy</a>.</span>
                                        </div>
                                        <div class="col-12 pt-3">
                                            <div class="row">
                                                <div class="col-12 def-input rounded-5 p-2">
                                                    <div class="row ps-3 pe-3 pt-2 pb-2">
                                                        <div class="col-12">
                                                            <span class="def-input-text">Username<span class="required-symbol"> *</span></span>
                                                        </div>
                                                        <div class="col-12 pt-1">
                                                            <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="text" id="username2" onchange="errorReset('sign-up-error-loader','signin-btn');" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 def-input rounded-5 p-2 mt-3">
                                                    <div class="row ps-3 pe-3 pt-2 pb-2">
                                                        <div class="col-12">
                                                            <span class="def-input-text">Password<span class="required-symbol"> *</span></span>
                                                        </div>
                                                        <div class="col-12 pt-1 d-flex flex-row">
                                                            <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="password" id="password2" onchange="errorReset('sign-up-error-loader','signin-btn');" />
                                                            <button class="bg-transparent border-0" id="password-status-change-btn2" onclick="passwordFieldHideStatusShift('password2','password-status-change-btn2');"><i class="bi bi-eye-slash def-input-text fs-5"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-4">
                                                    <div class="row gap-3">
                                                        <div class="col-12">
                                                            <span class="modal-small-text">New to Help Hub? <a class="def-modal-link" href="#" onclick="sectionShift();">Sign Up</a></span>
                                                        </div>
                                                        <div class="col-12 d-flex flex-row">
                                                            <span class="modal-small-text">Forgot your <a class="def-modal-link" href="#" onclick="sendVerificationCode();forgotPasswordSendingLoaderShift();">password</a>?</span>
                                                            <div class="ms-2 d-none" id="forgot-password-sending-loader">
                                                                <div class="spinner-border def-modal-spinner" role="status"></div>
                                                                <span><i class="def-modal-link">Sending verification code</i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- signin section -->
                                <!-- password reset section -->
                                <div class="col-12 d-none" id="password-reset-section">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="post-header">Reset your password</h4>
                                            <span class="modal-small-text">Will send you an email with a verification code to reset your password.</span>
                                        </div>
                                        <div class="col-12 pt-3">
                                            <div class="row">
                                                <div class="col-12 def-input rounded-5 p-2">
                                                    <div class="row ps-3 pe-3 pt-2 pb-2">
                                                        <div class="col-12">
                                                            <span class="def-input-text">Verification Code<span class="required-symbol"> *</span></span>
                                                        </div>
                                                        <div class="col-12 pt-1">
                                                            <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="text" id="verification-code" onchange="errorReset('sign-up-error-loader','password-reset-btn');" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 def-input rounded-5 p-2 mt-3">
                                                    <div class="row ps-3 pe-3 pt-2 pb-2">
                                                        <div class="col-12">
                                                            <span class="def-input-text">New Password<span class="required-symbol"> *</span></span>
                                                        </div>
                                                        <div class="col-12 pt-1 d-flex flex-row">
                                                            <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="password" id="new-password" onchange="errorReset('sign-up-error-loader','password-reset-btn');" />
                                                            <button class="bg-transparent border-0" id="password-status-change-btn3" onclick="passwordFieldHideStatusShift('new-password','password-status-change-btn3');"><i class="bi bi-eye-slash def-input-text fs-5"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-4">
                                                    <div class="row gap-3">
                                                        <div class="col-12 my-auto">
                                                            <a class="def-modal-link" href="#" onclick="forgotPasswordSectionShift('true');">Sign Up</a>
                                                            <span class="my-auto"><i class="bi bi-dot"></i></span>
                                                            <a class="def-modal-link" href="#" onclick="forgotPasswordSectionShift('false');">Sign In</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- password reset section -->
                                <!-- signup section -->
                                <div class="col-12 d-none" id="signup-section">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="post-header">Sign Up</h4>
                                            <span class="modal-small-text">By continuing, you agree to our <a href="#" class="def-modal-link">User Agreement</a> and acknowledge that you understand the <a href="#" class="def-modal-link">Privacy Policy</a>.</span>
                                        </div>
                                        <div class="col-12 pt-3">
                                            <div class="row">
                                                <div class="col-6 pe-1 p-0 m-0">
                                                    <div class="col-12 def-input rounded-5 p-2">
                                                        <div class="row ps-3 pe-3 pt-2 pb-2">
                                                            <div class="col-12">
                                                                <span class="def-input-text">First Name<span class="required-symbol"> *</span></span>
                                                            </div>
                                                            <div class="col-12 pt-1">
                                                                <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="text" onchange="errorReset('sign-up-error-loader','signup-btn');" id="first-name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 ps-1 p-0 m-0">
                                                    <div class="col-12 def-input rounded-5 p-2">
                                                        <div class="row ps-3 pe-3 pt-2 pb-2">
                                                            <div class="col-12">
                                                                <span class="def-input-text">Last Name<span class="required-symbol"> *</span></span>
                                                            </div>
                                                            <div class="col-12 pt-1">
                                                                <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="text" onchange="errorReset('sign-up-error-loader','signup-btn');" id="last-name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 def-input rounded-5 p-2 mt-3">
                                                    <div class="row ps-3 pe-3 pt-2 pb-2">
                                                        <div class="col-12">
                                                            <span class="def-input-text">Username<span class="required-symbol"> *</span></span>
                                                        </div>
                                                        <div class="col-12 pt-1">
                                                            <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="text" onchange="errorReset('sign-up-error-loader','signup-btn');" id="username" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 def-input rounded-5 p-2 mt-3">
                                                    <div class="row ps-3 pe-3 pt-2 pb-2">
                                                        <div class="col-12">
                                                            <span class="def-input-text">Mobile<span class="required-symbol"> *</span></span>
                                                        </div>
                                                        <div class="col-12 pt-1">
                                                            <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="text" onchange="errorReset('sign-up-error-loader','signup-btn');" id="mobile" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 def-input rounded-5 p-2 mt-3">
                                                    <div class="row ps-3 pe-3 pt-2 pb-2">
                                                        <div class="col-12">
                                                            <span class="def-input-text">Email<span class="required-symbol"> *</span></span>
                                                        </div>
                                                        <div class="col-12 pt-1">
                                                            <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="email" onchange="errorReset('sign-up-error-loader','signup-btn');" id="email" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 def-input rounded-5 p-2 mt-3">
                                                    <div class="row ps-3 pe-3 pt-2 pb-2">
                                                        <div class="col-12">
                                                            <span class="def-input-text">Password<span class="required-symbol"> *</span></span>
                                                        </div>
                                                        <div class="col-12 pt-1 d-flex flex-row">
                                                            <input class="def-input-modify pt-1 pb-1 pe-2" placeholder="Type here..." type="password" onchange="errorReset('sign-up-error-loader','signup-btn');" id="password" />
                                                            <button class="bg-transparent border-0" id="password-status-change-btn1" onclick="passwordFieldHideStatusShift('password','password-status-change-btn1');"><i class="bi bi-eye-slash def-input-text fs-5"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 def-input rounded-5 p-2 mt-3">
                                                    <div class="row ps-3 pe-3 pt-2 pb-2">
                                                        <div class="col-12">
                                                            <span class="def-input-text">Gender<span class="required-symbol"> *</span></span>
                                                        </div>
                                                        <div class="col-12 pt-1">
                                                            <select id="gender" class="def-input-modify border-0" onchange="errorReset('sign-up-error-loader','signup-btn');">
                                                                <option value="0">Select</option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-4">
                                                    <span class="modal-small-text">Already a Help Hub user? <a class="def-modal-link" href="#" onclick="sectionShift();">Sign In</a></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- signup section -->
                            </div>
                        </div>
                        <div class="modal-footer border-0 d-flex flex-row justify-content-center">
                            <div class="col-12 my-auto" id="sign-up-error-loader">
                            </div>
                            <div class="col-12 col-md-10 col-lg-6">
                                <button type="button" id="signin-btn" class="def-btn1 ps-3 pe-3 pt-2 pb-2 w-100 disabled-btn" disabled onclick="signIn();">Sign In</button>
                                <button type="button" id="signup-btn" class="def-btn1 ps-3 pe-3 pt-2 pb-2 w-100 d-none disabled-btn" disabled onclick="signUp();">Sign Up</button>
                                <button type="button" id="password-reset-btn" class="def-btn1 ps-3 pe-3 pt-2 pb-2 w-100 d-none disabled-btn" disabled onclick="updatePassword();">Reset password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- user signin/signup modal -->
            <?php
            if ($isUserValied) {
            ?>
                <!-- user profile modal -->
                <div class="modal fade" id="modal2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content def-modal p-3" id="profile-detail-components-loader"></div>
                    </div>
                </div>
                <!-- user profile modal -->
                <!-- create post modal -->
                <div class="modal fade" id="modal3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content def-modal p-3">
                            <div class="modal-header border-0 d-flex flex-column">
                                <div class="col-12 d-flex flex-row justify-content-end">
                                    <button type="button" class="def-dropdown-btn rounded-5 btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="createPostModalReset();"></button>
                                </div>
                                <div class="col-12">
                                    <h4 class="post-header">Create a post</h4>
                                    <span class="modal-small-text"><i class="bi bi-globe-central-south-asia modal-small-text"></i>&nbsp;Public</span>
                                </div>
                            </div>
                            <div class="modal-body modal-content-wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <!-- post content type area -->
                                            <div class="col-12 p-2">
                                                <div class="row pb-2">
                                                    <div class="col-12">
                                                        <input class="def-input-modify popular-post-header post-content-modify pt-1 pb-1 pe-2" placeholder="Post header" type="text" onchange="errorReset('create-post-error-loader','create-post-btn');" id="post-header" />
                                                        <textarea class="def-input-modify post-content-modify pt-2 pb-1 pe-2" cols="10" placeholder="content" type="text" onkeyup="textLimitIndicate('post-content','1500');" oninput="postContentfieldIncrease();" onchange="errorReset('create-post-error-loader','create-post-btn');" id="post-content"></textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <span class="def-input-text" id="post-content-text"></span>
                                                    </div>
                                                    <div class="col-12 d-flex flex-row mt-2">
                                                        <div>
                                                            <select id="create-post-category" class="comment-btn comment-btn-mod rounded-5 ps-3 pe-3 pt-1 pb-1 create-post-category-btn-modify">
                                                                <option value="0">Select Category</option>
                                                                <?php
                                                                $categoryResultset5 = Database::search("SELECT * FROM `category`");
                                                                $categoryRownumber5 = $categoryResultset5->num_rows;

                                                                if ($categoryRownumber5 > 0) {
                                                                    for ($e = 0; $e < $categoryRownumber5; $e++) {
                                                                        $categoryData5 = $categoryResultset5->fetch_assoc();
                                                                ?>
                                                                        <option value="<?php echo ($categoryData5["id"]); ?>"><?php echo ($categoryData5["c_name"]); ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="ps-2">
                                                            <div class="dropdown">
                                                                <button class="comment-btn comment-btn-mod rounded-5 ps-3 pe-3 pt-1 pb-1 d-flex flex-row justify-content-center align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">Tags</button>
                                                                <ul class="dropdown-menu def-dropdown-menu def-dropdown-menu-modify p-2 mt-2 shadow">
                                                                    <li class="my-auto">
                                                                        <div class="col-12 p-2">
                                                                            <div class="row modal-content-wrapper emoji-content-wrapper">
                                                                                <?php
                                                                                $tagResultset3 = Database::search("SELECT * FROM `tags`");
                                                                                $tagRownumber3 = $tagResultset3->num_rows;

                                                                                if ($tagRownumber3 > 0) {
                                                                                    for ($f = 0; $f < $tagRownumber3; $f++) {
                                                                                        $tagData3 = $tagResultset3->fetch_assoc();
                                                                                ?>
                                                                                        <div class="my-auto"><input type="checkbox" id="create-post-tag<?php echo ($f); ?>" value="<?php echo ($tagData3["id"]); ?>">&nbsp;<?php echo ($tagData3["t_name"]); ?></div>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- post content type area -->
                                            <!-- post image preview area -->
                                            <div class="col-12">
                                                <div class="col-12 d-flex flex-row justify-content-end">
                                                    <button class="def-dropdown-btn border-0 rounded-5 ps-1 pe-1 d-none" id="create-post-image-reset-btn" onclick="createPostImageRemove();"><i class="bi bi-arrow-repeat fs-5" data-bs-toggle="tooltip" data-bs-title="Reset" data-bs-custom-class="custom-tooltip"></i></button>
                                                </div>
                                                <div class="row g-2" id="post-image-generate-area"></div>
                                            </div>
                                            <!-- post image preview area -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 d-flex flex-row justify-content-center">
                                <div class="col-12 d-flex flex-row justify-content-end gap-3">
                                    <div>
                                        <div class="dropdown dropup">
                                            <button class="def-dropdown-btn d-flex flex-row justify-content-center align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-emoji-smile fs-5" data-bs-toggle="tooltip" data-bs-title="Emoji" data-bs-custom-class="custom-tooltip"></i>
                                                <span class="position-absolute top-0 start-100 translate-middle rounded-pill badge-modify ps-1 pe-1">New</span>
                                            </button>
                                            <ul class="dropdown-menu def-dropdown-menu p-2 mt-2 shadow">
                                                <li class="my-auto">
                                                    <div class="col-12 p-2">
                                                        <div class="row modal-content-wrapper d-flex flex-row justify-content-center emoji-content-wrapper">
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128512;');textLimitIndicate('post-content','1500');">&#128512;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128513;');textLimitIndicate('post-content','1500');">&#128513;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128514;');textLimitIndicate('post-content','1500');">&#128514;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128515;');textLimitIndicate('post-content','1500');">&#128515;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128516;');textLimitIndicate('post-content','1500');">&#128516;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128517;');textLimitIndicate('post-content','1500');">&#128517;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128518;');textLimitIndicate('post-content','1500');">&#128518;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128519;');textLimitIndicate('post-content','1500');">&#128519;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128522;');textLimitIndicate('post-content','1500');">&#128522;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128523;');textLimitIndicate('post-content','1500');">&#128523;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128524;');textLimitIndicate('post-content','1500');">&#128524;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128525;');textLimitIndicate('post-content','1500');">&#128525;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128526;');textLimitIndicate('post-content','1500');">&#128526;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128528;');textLimitIndicate('post-content','1500');">&#128528;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128529;');textLimitIndicate('post-content','1500');">&#128529;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128532;');textLimitIndicate('post-content','1500');">&#128532;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128534;');textLimitIndicate('post-content','1500');">&#128534;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128536;');textLimitIndicate('post-content','1500');">&#128536;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128546;');textLimitIndicate('post-content','1500');">&#128546;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128557;');textLimitIndicate('post-content','1500');">&#128557;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128561;');textLimitIndicate('post-content','1500');">&#128561;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128564;');textLimitIndicate('post-content','1500');">&#128564;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128566;');textLimitIndicate('post-content','1500');">&#128566;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128567;');textLimitIndicate('post-content','1500');">&#128567;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128578;');textLimitIndicate('post-content','1500');">&#128578;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#128512;');textLimitIndicate('post-content','1500');">&#128512;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#129300;');textLimitIndicate('post-content','1500');">&#129300;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#129321;');textLimitIndicate('post-content','1500');">&#129321;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#129395;');textLimitIndicate('post-content','1500');">&#129395;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#129398;');textLimitIndicate('post-content','1500');">&#129398;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#129402;');textLimitIndicate('post-content','1500');">&#129402;</button>
                                                            <button class="def-dropdown-btn2 d-flex flex-row justify-content-center align-items-center" type="button" onclick="emojiAdder('post-content','&#129488;');textLimitIndicate('post-content','1500');">&#129488;</button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="create-post-image-upload" class="def-dropdown-btn d-flex flex-row justify-content-center align-items-center" type="button" onclick="createPostImageInclude();">
                                            <i class="bi bi-image-alt fs-5" data-bs-toggle="tooltip" data-bs-title="Photo" data-bs-custom-class="custom-tooltip"></i>
                                        </label>
                                        <input type="file" id="create-post-image-upload" class="d-none" multiple accept=".png, .jpg, .jpeg" />
                                    </div>
                                </div>
                                <div class="col-12 my-auto" id="create-post-error-loader">
                                </div>
                                <div class="col-12 col-md-10 col-lg-6">
                                    <button type="button" id="create-post-btn" class="def-btn1 ps-3 pe-3 pt-2 pb-2 w-100 disabled-btn" disabled onclick="saveNewPost('<?php echo ($tagRownumber3); ?>');">Post</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- create post modal -->
                <!-- private message modal -->
                <div class="modal fade" id="modal4" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content def-modal p-3" id="private-chat-content-loader"></div>
                    </div>
                </div>
                <!-- private message modal -->
            <?php
            }
            ?>
            <!-- message toast -->
            <div class="toast toast-modify position-fixed bottom-0 end-0 me-3 mb-3 pe-2 ps-3 border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" id="toast1">
                <div class="toast-body d-flex flex-row justify-content-between my-auto pt-3 pb-3">
                    <div class="my-auto">
                        <span class="my-auto toast-message-text text-capitalize" id="toast-messag"></span>
                    </div>
                    <div class="my-auto">
                        <button type="button" class="btn-close def-dropdown-btn rounded-5" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <!-- message toast -->
        </div>
    </div>
    <script src="bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>