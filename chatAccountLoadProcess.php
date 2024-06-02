<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {

    $chatAccountResultset = Database::search("SELECT * FROM `chat` INNER JOIN `chat_status` ON 
                                                `chat`.`chat_status_id`=`chat_status`.`id` WHERE `from_user`='" . $_SESSION["user"]["email"] . "' OR `to_user`='" . $_SESSION["user"]["email"] . "' ORDER BY `send_date_time` DESC");
    $chatAccountRownumber = $chatAccountResultset->num_rows;
    $chatAccountArray = array();

    $isFromUserAvailable;

    if ($chatAccountRownumber > 0) {
        for ($c = 0; $c < $chatAccountRownumber; $c++) {
            $chatAccountData = $chatAccountResultset->fetch_assoc();

            if ($chatAccountData["from_user"] != $_SESSION["user"]["email"]) {
                $isFromUserAvailable = true;
            } else if ($chatAccountData["to_user"] != $_SESSION["user"]["email"]) {
                $isFromUserAvailable = false;
            }

            if ($isFromUserAvailable) {
                if (!in_array($chatAccountData["from_user"], $chatAccountArray)) {
                    array_push($chatAccountArray, $chatAccountData["from_user"]);
                    $chatUserResultset = Database::search("SELECT * FROM `user` WHERE `email`='" . $chatAccountData["from_user"] . "'");
                    $chatUserData = $chatUserResultset->fetch_assoc();
?>
                    <!-- message card -->
                    <button class="def-popular-post rounded-5 border-0 text-decoration-none w-100" onclick="privateChatContentLoad('<?php echo ($chatUserData['email']); ?>');">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3 p-2 d-flex flex-row justify-content-end align-items-start my-auto">
                                    <?php
                                    $isUserProfileImageSet;
                                    $allProfileImageNameArray = scandir("resources/images/profile_images/");
                                    $targetProfileImageName = explode("@", $chatUserData['email'])[0] . ".jpeg";

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
                                        <img src="resources/images/profile_images/<?php echo ($targetProfileImageName); ?>" class="img-fluid popular-post-img" alt="chat-profile-image" />
                                    <?php
                                    } else {
                                    ?>
                                        <img src="resources/images/profile_images/def-profile.svg" class="img-fluid popular-post-img" alt="chat-profile-image" />
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-9 my-auto">
                                    <div class="row">
                                        <div class="col-12 d-flex flex-row justify-content-start">
                                            <span class="popular-post-header text-capitalize"><?php echo ($chatUserData["first_name"] . " " . $chatUserData["last_name"]);
                                                                                                if ($chatAccountData["c_type"] == "unseen") {
                                                                                                ?>
                                                    <i class="bi bi-circle-fill required-symbol" data-bs-toggle="tooltip" data-bs-title="New Message" data-bs-custom-class="custom-tooltip"></i>
                                                <?php
                                                                                                } ?></span>
                                        </div>
                                        <div class="col-12 d-flex flex-row justify-content-between my-auto pe-4">
                                            <span class="my-auto"><?php echo ($chatAccountData["chat_content"]); ?></span>
                                            <span class="post-date-text my-auto"><?php echo (date("h:i a", strtotime($chatAccountData["send_date_time"]))); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                    <!-- message card -->
                <?php
                }
            } else {
                if (!in_array($chatAccountData["to_user"], $chatAccountArray)) {
                    array_push($chatAccountArray, $chatAccountData["to_user"]);
                    $chatUserResultset2 = Database::search("SELECT * FROM `user` WHERE `email`='" . $chatAccountData["to_user"] . "'");
                    $chatUserData2 = $chatUserResultset2->fetch_assoc();
                ?>
                    <!-- message card -->
                    <button class="def-popular-post rounded-5 border-0 text-decoration-none w-100" onclick="privateChatContentLoad('<?php echo ($chatUserData2['email']); ?>');">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3 p-2 d-flex flex-row justify-content-end align-items-start my-auto">
                                    <?php
                                    $isUserProfileImageSet2;
                                    $allProfileImageNameArray2 = scandir("resources/images/profile_images");
                                    $targetProfileImageName2 = explode("@", $chatUserData2['email'])[0] . ".jpeg";

                                    foreach ($allProfileImageNameArray2 as $imageFileName2) {

                                        if ($imageFileName2 == $targetProfileImageName2) {
                                            $isUserProfileImageSet2 = true;
                                            break;
                                        } else {
                                            $isUserProfileImageSet2 = false;
                                        }
                                    }

                                    if ($isUserProfileImageSet2) {
                                    ?>
                                        <img src="resources/images/profile_images/<?php echo ($targetProfileImageName2); ?>" class="img-fluid popular-post-img" alt="chat-profile-image" />
                                    <?php
                                    } else {
                                    ?>
                                        <img src="resources/images/profile_images/def-profile.svg" class="img-fluid popular-post-img" alt="chat-profile-image" />
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-9 my-auto">
                                    <div class="row">
                                        <div class="col-12 d-flex flex-row justify-content-start">
                                            <span class="popular-post-header text-capitalize"><?php echo ($chatUserData2["first_name"] . " " . $chatUserData2["last_name"]);
                                                                                                if ($chatAccountData["c_type"] == "unseen") {
                                                                                                ?>
                                                    <i class="bi bi-circle-fill required-symbol" data-bs-toggle="tooltip" data-bs-title="New Message" data-bs-custom-class="custom-tooltip"></i>
                                                <?php
                                                                                                } ?>
                                            </span>
                                        </div>
                                        <div class="col-12 d-flex flex-row justify-content-between my-auto pe-4">
                                            <span class="my-auto"><?php echo ($chatAccountData["chat_content"]); ?></span>
                                            <span class="post-date-text my-auto"><?php echo (date("h:i a", strtotime($chatAccountData["send_date_time"]))); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                    <!-- message card -->
<?php
                }
            }
        }
    }
} else {
    echo ("user rejected");
}
?>