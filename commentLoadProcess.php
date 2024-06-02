<?php
session_start();
require "connection.php";

if (isset($_GET["pst_id"]) & !empty($_GET["pst_id"])) {
    $commentResultset = Database::search("SELECT * FROM `comments` INNER JOIN `user` ON 
    `comments`.`user_email`=`user`.`email` WHERE `posts_id`='" . $_GET["pst_id"] . "' ORDER BY `id` DESC");
    $commentRownumber = $commentResultset->num_rows;
    if ($commentRownumber > 0) {
        for ($c = 0; $c < $commentRownumber; $c++) {
            $commentData = $commentResultset->fetch_assoc();
?>
            <!-- comment card -->
            <div class="col-12 def-comment-card p-2">
                <div class="row">
                    <div class="col-12">
                        <div class="col-12 d-flex flex-row my-auto gap-2">
                            <div class="my-auto">
                                <?php
                                $isUserCommentProfileImageSet;
                                $allCommentProfileImageNameArray = scandir("resources/images/profile_images/");
                                $targetCommentProfileImageName = explode("@", $commentData["user_email"])[0] . ".jpeg";

                                foreach ($allCommentProfileImageNameArray as $imageFileName) {
                                    if ($imageFileName == $targetCommentProfileImageName) {
                                        $isUserCommentProfileImageSet = true;
                                        break;
                                    } else {
                                        $isUserCommentProfileImageSet = false;
                                    }
                                }

                                if ($isUserCommentProfileImageSet) {
                                ?>
                                    <img src="resources/images/profile_images/<?php echo ($targetCommentProfileImageName); ?>" class="def-comment-profile-image" alt="comment-profile-image" />
                                <?php
                                } else {
                                ?>
                                    <img src="resources/images/profile_images/def-profile.svg" class="def-comment-profile-image" alt="comment-profile-image" />
                                <?php
                                }
                                ?>
                            </div>
                            <div class="my-auto d-flex flex-row">
                                <span class="post-header"><?php echo ($commentData["first_name"] . " " . $commentData["last_name"]); ?></span>
                            </div>
                            <div class="my-auto">
                                <span class="def-link">@<?php echo ($commentData["username"]); ?></span>
                            </div>
                            <?php
                            if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
                                if ($commentData["user_email"] == $_SESSION["user"]["email"]) {
                            ?>
                                    <div class="my-auto">
                                        <button class="def-dropdown-btn2" onclick="deleteComment('<?php echo($commentData['id']); ?>','<?php echo($_GET['pst_id']); ?>');"><i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-title="Delete comment" data-bs-custom-class="custom-tooltip"></i></button>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-12 ps-5">
                        <span class="def-popular-post"><?php echo ($commentData["comment"]); ?></span>
                    </div>
                </div>
            </div>
            <!-- comment card -->
        <?php
        }
    } else {
        ?>
        <!-- comment card -->
        <div class="col-12 def-comment-card p-2 d-flex flex-row justify-content-center align-items-center">
            <span>No comments yet</span>
        </div>
        <!-- comment card -->
    <?php
    }
} else {
    ?>
    <!-- comment card -->
    <div class="col-12 def-comment-card p-2 d-flex flex-row justify-content-center align-items-center">
        <span>Something went wrong</span>
    </div>
    <!-- comment card -->
<?php
}
?>