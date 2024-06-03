<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"]["email"]) & !empty($_SESSION["user"]["email"])) {
    $notificationResultset = Database::search("SELECT * FROM `notification` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
    $notificationRownumber = $notificationResultset->num_rows;

    if ($notificationRownumber > 0) {
        for ($x = 0; $x < $notificationRownumber; $x++) {
            $notificationData = $notificationResultset->fetch_assoc();

            $notificationStatusResultset = Database::search("SELECT * FROM `notification_status` WHERE `id`='" . $notificationData["notification_status_id"] . "'");
            $notificationStatusData = $notificationStatusResultset->fetch_assoc();
?>
            <!-- notification card -->
            <button class="def-popular-post rounded-5 border-0 text-decoration-none w-100">
                <div class="col-12">
                    <div class="row">
                        <div class="col-2 p-2 d-flex flex-row justify-content-end align-items-center my-auto">
                            <span class="def-dropdown-btn2 ps-3 my-auto"><i class="bi bi-<?php
                                                                                    if ($notificationStatusData["n_type"] == "vote up") {
                                                                                    ?>
                                bi-hand-thumbs-up-fill
                                <?php
                                                                                    } else if ($notificationStatusData["n_type"] == "new user message") {
                                ?>
                                bi-person-plus-fill
                                <?php
                                                                                    } else if ($notificationStatusData["n_type"] == "new comment") {
                                ?>
                                bi-chat-square-fill
                                <?php
                                                                                    }
                                ?>chat-square-heart-fill fs-4 required-symbol"></i></span>
                        </div>
                        <div class="col-10 my-auto">
                            <div class="row">
                                <div class="col-12 d-flex flex-row justify-content-between my-auto pe-4">
                                    <span class="my-auto"><?php
                                                            if ($notificationStatusData["n_type"] == "vote up") {
                                                            ?>
                                            Someone voted your post
                                        <?php
                                                            } else if ($notificationStatusData["n_type"] == "new user message") {
                                        ?>
                                            New user messaged to you
                                        <?php
                                                            } else if ($notificationStatusData["n_type"] == "new comment") {
                                        ?>
                                            Someone commented your post
                                        <?php
                                                            }
                                        ?></span>
                                    <span class="def-dropdown-btn2 mt-3 "><i class="bi bi-eye" data-bs-toggle="tooltip" data-bs-title="Mark as read" data-bs-custom-class="custom-tooltip" onclick="deleteNotification('<?php echo ($notificationData['id']); ?>');"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </button>
            <!-- notification card -->
        <?php
        }
    } else {
        ?>
        <!-- empty notification card -->
        <div class="w-100" onclick="notificationLoadStop();">
            <div class="col-12 d-flex flex-row justify-content-center pt-5 pb-5">
                <span>No notifications</span>
            </div>
        </div>
        <!-- empty notification card -->
<?php
    }
} else {
    echo ("user rejected");
}
?>