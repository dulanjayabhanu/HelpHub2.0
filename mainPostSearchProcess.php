<?php
session_start();
require "connection.php";

$query = "SELECT * FROM `posts`";
$userRelatedPostIdArray = array();
$otherPostIdArray = array();

if (isset($_SESSION["user"]) & !empty($_SESSION["user"]) & (!isset($_GET["srch_ky"]) & empty($_GET["srch_ky"]))) {
    $userRelatedCategoriesResultset = Database::search("SELECT * FROM `user_has_category` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
    $userRelatedCategoriesRownumber = $userRelatedCategoriesResultset->num_rows;

    if ($userRelatedCategoriesRownumber > 0) {
        for ($x = 0; $x < $userRelatedCategoriesRownumber; $x++) {
            $userRelatedCategoriesData = $userRelatedCategoriesResultset->fetch_assoc();
            if ($x == 0) {
                $query .= " WHERE";
            }

            if ($x == ($userRelatedCategoriesRownumber - 1)) {
                $query .= " `category_id`='" . $userRelatedCategoriesData["category_id"] . "'";
            } else {
                $query .= " `category_id`='" . $userRelatedCategoriesData["category_id"] . "' OR";
            }
        }
    }
}

if (isset($_GET["srch_ky"]) & !empty($_GET["srch_ky"])) {
    if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
        $query .= " WHERE (`title` LIKE '%" . $_GET["srch_ky"] . "%')";
    } else {
        $query .= " WHERE `title` LIKE '%" . $_GET["srch_ky"] . "%'";
    }
}

if (isset($_GET["ctgry_ky"]) & !empty($_GET["ctgry_ky"])) {
    $query = "";
    $query .= "SELECT * FROM `posts` WHERE `category_id` = '" . $_GET["ctgry_ky"] . "'";
}

if (isset($_GET["tg_ky"]) & !empty($_GET["tg_ky"])) {
    $query = "";
    $query .= "SELECT * FROM `posts` INNER JOIN `posts_has_tage` ON 
    `posts`.`id`=`posts_has_tage`.`posts_id` WHERE `posts_has_tage`.`tage_id` = '" . $_GET["tg_ky"] . "'";
}

$postIdResultset = Database::search($query);
$postIdRownumber = $postIdResultset->num_rows;

if ($postIdRownumber > 0) {
    for ($y = 0; $y < $postIdRownumber; $y++) {
        $postIdData = $postIdResultset->fetch_assoc();
        array_push($userRelatedPostIdArray, $postIdData["id"]);
    }

    $postResultset = Database::search("SELECT * FROM `posts`");
    $postRownumber = $postResultset->num_rows;

    if ($postRownumber > 0) {
        for ($z = 0; $z < $postRownumber; $z++) {
            $postData = $postResultset->fetch_assoc();

            if (!in_array($postData["id"], $userRelatedPostIdArray)) {
                array_push($otherPostIdArray, $postData["id"]);
            }
        }

        // Searched post renderer

        $postDataQuery = "SELECT * FROM `posts` INNER JOIN `user` ON 
        `posts`.`user_email`=`user`.`email`";

        for ($a = 0; $a < sizeof($userRelatedPostIdArray); $a++) {
            if ($a == 0) {
                $postDataQuery .= " WHERE";
            }

            if ($a == (sizeof($userRelatedPostIdArray) - 1)) {
                $postDataQuery .= " `id`='" . $userRelatedPostIdArray[$a] . "'";
            } else {
                $postDataQuery .= " `id`='" . $userRelatedPostIdArray[$a] . "' OR";
            }
        }

        $postDataResultset = Database::search($postDataQuery);
        $postDataRownumber = $postDataResultset->num_rows;

        for ($p = 0; $p < $postDataRownumber; $p++) {
            $allPostData = $postDataResultset->fetch_assoc();
            $commentCountResultset = Database::search("SELECT COUNT(`id`) FROM `comments` WHERE `posts_id`='" . $allPostData["id"] . "'");
            $commentData = $commentCountResultset->fetch_assoc();
            $voteCountResultset = Database::search("SELECT COUNT(`id`) FROM `vote` WHERE `posts_id`='" . $allPostData["id"] . "'");
            $voteData = $voteCountResultset->fetch_assoc();
?>
            <!-- main post card -->
            <div class="col-12 main-post-card ps-3 pt-3 pe-3 pb-3 mt-2" onclick="window.location='postView.php?pst_id=<?php echo ($allPostData['id']); ?>';">
                <div class="row">
                    <div class="col-12 d-flex flex-row justify-content-between">
                        <div class="d-flex flex-row">
                            <div class="p-2 d-flex flex-row justify-content-start align-items-start my-auto">
                                <?php
                                $isUserProfileImageSet;
                                $allProfileImageNameArray = scandir("resources/images/profile_images/");
                                $targetProfileImageName = explode("@", $allPostData["user_email"])[0] . ".jpeg";

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
                                    <img src="resources/images/profile_images/<?php echo ($targetProfileImageName); ?>" class="img-fluid post-profile-img" alt="post-profile-image" />
                                <?php
                                } else {
                                ?>
                                    <img src="resources/images/profile_images/def-profile.svg" class="img-fluid post-profile-img" alt="post-profile-image" />
                                <?php
                                }
                                ?>
                            </div>
                            <div class="text-start my-auto">
                                <span><?php echo ($allPostData["first_name"] . " " . $allPostData["last_name"]); ?></span>
                            </div>
                            <div class="text-start my-auto ps-2">
                                <span class="post-date-text"><?php
                                                                echo (date("h:i a . d M y", strtotime($allPostData["date_time"])));
                                                                ?></span>
                            </div>
                        </div>
                        <div class="my-auto">
                            <div class="dropdown">
                                <button class="def-dropdown-btn2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></button>
                                <ul class="dropdown-menu def-dropdown-menu p-1 mt-2 shadow">
                                    <li class="my-auto"><a class="dropdown-item" href="#"><i class="bi bi-flag fs-5"></i>&nbsp;&nbsp;Report</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ps-3 pe-3 pt-2">
                        <h3 class="post-header"><?php echo ($allPostData["title"]); ?></h3>
                    </div>
                    <?php
                    $postImageResultset = Database::search("SELECT * FROM `posts_has_post_images` INNER JOIN `post_images` ON 
                        `posts_has_post_images`.`post_images_id`=`post_images`.`id` WHERE `posts_id`='" . $allPostData["id"] . "' LIMIT 1");
                    $postImagesRownumber = $postImageResultset->num_rows;

                    if ($postImagesRownumber > 0) {
                        $postImageData = $postImageResultset->fetch_assoc();
                    ?>
                        <div class="col-12 pt-1 pb-1">
                            <img src="resources/images/post_images/<?php echo ($postImageData["path"]); ?>" class="main-post-image border" alt="post-image" />
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-12 ps-3 pe-3 pt-2">
                            <p><?php echo ($allPostData["content"]); ?></p>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="col-12 pt-2 d-flex flex-row align-items-center gap-2">
                        <div class="vot-btn d-flex flex-row align-items-center rounded-5 p-2">
                            <?php
                            if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
                                $voteResultset = Database::search("SELECT * FROM `vote` WHERE `posts_id`='" . $allPostData["id"] . "' AND `user_email`='" . $_SESSION["user"]["email"] . "'");
                                $voteRownumber = $voteResultset->num_rows;

                                if ($voteRownumber > 0) {
                            ?>
                                    <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Upvote" data-bs-custom-class="custom-tooltip" id="upvote-btn<?php echo ($allPostData['id']); ?>" onclick="updateVote('<?php echo ($allPostData['id']); ?>');"><i class="bi bi-caret-up-fill fs-5"></i></button>
                                <?php
                                } else {
                                ?>
                                    <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Upvote" data-bs-custom-class="custom-tooltip" id="upvote-btn<?php echo ($allPostData['id']); ?>" onclick="updateVote('<?php echo ($allPostData['id']); ?>');"><i class="bi bi-caret-up fs-5"></i></button>
                                <?php
                                }
                            } else {
                                ?>
                                <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Upvote" data-bs-custom-class="custom-tooltip" onclick="showModal('modal1');"><i class="bi bi-caret-up fs-5"></i></button>
                            <?php
                            }
                            ?>
                            <span class="ps-1 pe-1" id="vote-count-text<?php echo ($allPostData["id"]); ?>"><?php
                                                                                                            if ($voteData["COUNT(`id`)"] < 10) {
                                                                                                                echo ("0" . $voteData["COUNT(`id`)"]);
                                                                                                            } else {
                                                                                                                echo ($voteData["COUNT(`id`)"]);
                                                                                                            }
                                                                                                            ?></span>
                            <?php
                            if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
                            ?>
                                <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Downvote" data-bs-custom-class="custom-tooltip" id="downvote-btn<?php echo ($allPostData['id']); ?>" onclick="updateVote('<?php echo ($allPostData['id']); ?>');"><i class="bi bi-caret-down fs-5"></i></button>
                            <?php
                            } else {
                            ?>
                                <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Downvote" data-bs-custom-class="custom-tooltip" onclick="showModal('modal1');"><i class="bi bi-caret-down fs-5"></i></button>
                            <?php
                            }
                            ?>
                        </div>
                        <button class="comment-btn d-flex flex-row justify-content-center align-items-center rounded-5 ps-4 pe-4 pt-2 pb-2"><i class="bi bi-chat-left fs-5"></i>&nbsp;&nbsp;<?php
                                                                                                                                                                                            if ($commentData["COUNT(`id`)"] < 10) {
                                                                                                                                                                                                echo ("0" . $commentData["COUNT(`id`)"]);
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo ($commentData["COUNT(`id`)"]);
                                                                                                                                                                                            }                                                                                                                                                                                            ?></button>
                    </div>
                </div>
            </div>
            <!-- main post card -->
            <?php
        }

        // Other post renderer

        if (sizeof($otherPostIdArray) > 0) {
            $postDataQuery2 = "SELECT * FROM `posts` INNER JOIN `user` ON 
        `posts`.`user_email`=`user`.`email`";

            for ($b = 0; $b < sizeof($otherPostIdArray); $b++) {
                if ($b == 0) {
                    $postDataQuery2 .= " WHERE";
                }

                if ($b == (sizeof($otherPostIdArray) - 1)) {
                    $postDataQuery2 .= " `id`='" . $otherPostIdArray[$b] . "'";
                } else {
                    $postDataQuery2 .= " `id`='" . $otherPostIdArray[$b] . "' OR";
                }
            }

            $postDataResultset2 = Database::search($postDataQuery2);
            $postDataRownumber2 = $postDataResultset2->num_rows;

            for ($q = 0; $q < $postDataRownumber2; $q++) {
                $allPostData2 = $postDataResultset2->fetch_assoc();
                $commentCountResultset2 = Database::search("SELECT COUNT(`id`) FROM `comments` WHERE `posts_id`='" . $allPostData2["id"] . "'");
                $commentData2 = $commentCountResultset2->fetch_assoc();
                $voteCountResultset2 = Database::search("SELECT COUNT(`id`) FROM `vote` WHERE `posts_id`='" . $allPostData2["id"] . "'");
                $voteData2 = $voteCountResultset2->fetch_assoc();
            ?>
                <!-- main post card -->
                <div class="col-12 main-post-card ps-3 pt-3 pe-3 pb-3 mt-2" onclick="window.location='postView.php?pst_id=<?php echo ($allPostData2['id']); ?>';">
                    <div class="row">
                        <div class="col-12 d-flex flex-row justify-content-between">
                            <div class="d-flex flex-row">
                                <div class="p-2 d-flex flex-row justify-content-start align-items-start my-auto">
                                    <?php
                                    $isUserProfileImageSet;
                                    $allProfileImageNameArray = scandir("resources/images/profile_images/");
                                    $targetProfileImageName = explode("@", $allPostData2["user_email"])[0] . ".jpeg";

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
                                        <img src="resources/images/profile_images/<?php echo ($targetProfileImageName); ?>" class="img-fluid post-profile-img" alt="post-profile-image" />
                                    <?php
                                    } else {
                                    ?>
                                        <img src="resources/images/profile_images/def-profile.svg" class="img-fluid post-profile-img" alt="post-profile-image" />
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="text-start my-auto">
                                    <span><?php echo ($allPostData2["first_name"] . " " . $allPostData2["last_name"]); ?></span>
                                </div>
                                <div class="text-start my-auto ps-2">
                                    <span class="post-date-text"><?php
                                                                    echo (date("h:i a . d M y", strtotime($allPostData2["date_time"])));
                                                                    ?></span>
                                </div>
                            </div>
                            <div class="my-auto">
                                <div class="dropdown">
                                    <button class="def-dropdown-btn2" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i></button>
                                    <ul class="dropdown-menu def-dropdown-menu p-1 mt-2 shadow">
                                        <li class="my-auto"><a class="dropdown-item" href="#"><i class="bi bi-flag fs-5"></i>&nbsp;&nbsp;Report</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 ps-3 pe-3 pt-2">
                            <h3 class="post-header"><?php echo ($allPostData2["title"]); ?></h3>
                        </div>
                        <?php
                        $postImageResultset = Database::search("SELECT * FROM `posts_has_post_images` INNER JOIN `post_images` ON 
                        `posts_has_post_images`.`post_images_id`=`post_images`.`id` WHERE `posts_id`='" . $allPostData2["id"] . "' LIMIT 1");
                        $postImagesRownumber = $postImageResultset->num_rows;

                        if ($postImagesRownumber > 0) {
                            $postImageData = $postImageResultset->fetch_assoc();
                        ?>
                            <div class="col-12 pt-1 pb-1">
                                <img src="resources/images/post_images/<?php echo ($postImageData["path"]); ?>" class="main-post-image border" alt="post-image" />
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-12 ps-3 pe-3 pt-2">
                                <p><?php echo ($allPostData2["content"]); ?></p>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="col-12 pt-2 d-flex flex-row align-items-center gap-2">
                            <div class="vot-btn d-flex flex-row align-items-center rounded-5 p-2">
                                <?php
                                if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
                                    $voteResultset2 = Database::search("SELECT * FROM `vote` WHERE `posts_id`='" . $allPostData2["id"] . "' AND `user_email`='" . $_SESSION["user"]["email"] . "'");
                                    $voteRownumber2 = $voteResultset2->num_rows;

                                    if ($voteRownumber2 > 0) {
                                ?>
                                        <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Upvote" data-bs-custom-class="custom-tooltip" id="upvote-btn<?php echo ($allPostData2['id']); ?>" onclick="updateVote('<?php echo ($allPostData2['id']); ?>');"><i class="bi bi-caret-up-fill fs-5"></i></button>
                                    <?php
                                    } else {
                                    ?>
                                        <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Upvote" data-bs-custom-class="custom-tooltip" id="upvote-btn<?php echo ($allPostData2['id']); ?>" onclick="updateVote('<?php echo ($allPostData2['id']); ?>');"><i class="bi bi-caret-up fs-5"></i></button>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Upvote" data-bs-custom-class="custom-tooltip" onclick="showModal('modal1');"><i class="bi bi-caret-up fs-5"></i></button>
                                <?php
                                }
                                ?>
                                <span class="ps-1 pe-1" id="vote-count-text<?php echo ($allPostData2["id"]); ?>"><?php
                                                                                                                    if ($voteData2["COUNT(`id`)"] < 10) {
                                                                                                                        echo ("0" . $voteData2["COUNT(`id`)"]);
                                                                                                                    } else {
                                                                                                                        echo ($voteData2["COUNT(`id`)"]);
                                                                                                                    }
                                                                                                                    ?></span>
                                <?php
                                if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
                                ?>
                                    <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Downvote" data-bs-custom-class="custom-tooltip" id="downvote-btn<?php echo ($allPostData2['id']); ?>" onclick="updateVote('<?php echo ($allPostData2['id']); ?>');"><i class="bi bi-caret-down fs-5"></i></button>
                                <?php
                                } else {
                                ?>
                                    <button class="vot-sub-btn d-flex flex-row justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-title="Downvote" data-bs-custom-class="custom-tooltip" onclick="showModal('modal1');"><i class="bi bi-caret-down fs-5"></i></button>
                                <?php
                                }
                                ?>
                            </div>
                            <button class="comment-btn d-flex flex-row justify-content-center align-items-center rounded-5 ps-4 pe-4 pt-2 pb-2"><i class="bi bi-chat-left fs-5"></i>&nbsp;&nbsp;<?php
                                                                                                                                                                                                if ($commentData2["COUNT(`id`)"] < 10) {
                                                                                                                                                                                                    echo ("0" . $commentData2["COUNT(`id`)"]);
                                                                                                                                                                                                } else {
                                                                                                                                                                                                    echo ($commentData2["COUNT(`id`)"]);
                                                                                                                                                                                                }
                                                                                                                                                                                                ?></button>
                        </div>
                    </div>
                </div>
                <!-- main post card -->
    <?php
            }
        }
    }
} else {
    ?>
    <div class="col-12 main-post-card ps-3 pt-3 pe-3 pb-3 mt-2 d-flex flex-column justify-content-center align-items-center">
        <span>No posts &#58;&#40;</span>
    </div>
<?php
}

?>