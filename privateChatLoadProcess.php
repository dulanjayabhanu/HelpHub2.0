<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
    if (isset($_POST["recvrMl"]) & !empty($_POST["recvrMl"])) {
        $chatResultset = Database::search("SELECT * FROM `chat` WHERE (`from_user`='" . $_POST["recvrMl"] . "' AND `to_user`='" . $_SESSION["user"]["email"] . "') OR (`from_user`='" . $_SESSION["user"]["email"] . "' AND `to_user`='" . $_POST["recvrMl"] . "') ORDER BY `send_date_time` ASC");
        $chatRownumber = $chatResultset->num_rows;

        if ($chatRownumber > 0) {
            for ($x = 0; $x < $chatRownumber; $x++) {
                $chatData = $chatResultset->fetch_assoc();

                if ($chatData["from_user"] == $_SESSION["user"]["email"] & $chatData["to_user"] == $_POST["recvrMl"]) {
?>
                    <!-- sender message card -->
                    <div class="col-12 mt-2 d-flex flex-row justify-content-end">
                        <div class="d-flex flex-row justify-content-end align-items-center pe-2">
                            <button class="def-dropdown-btn2" onclick="deletePrivateChat('<?php echo ($chatData['id']); ?>','<?php echo($_POST['recvrMl']); ?>');"><i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-title="Delete comment" data-bs-custom-class="custom-tooltip"></i></button>
                        </div>
                        <div class="def-chat-box def-chat-box-modify ps-3 pt-2 pb-2 pe-3">
                            <div class="row">
                                <div class="col-12 ps-3 pe-3 pt-2 pb-1">
                                    <span class="def-sender-message-box-color"><?php echo ($chatData["chat_content"]); ?></span>
                                </div>
                                <div class="col-12 d-flex flex-row justify-content-end">
                                    <span class="post-date-text def-sender-message-box-color"><?php echo (date("h:i a", strtotime($chatData["send_date_time"]))); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- sender message card -->
                <?php
                } else if ($chatData["from_user"] == $_POST["recvrMl"] & $chatData["to_user"] == $_SESSION["user"]["email"]) {
                ?>
                    <!-- receiver message card -->
                    <div class="col-12 mt-2">
                        <div class="def-chat-box ps-3 pt-2 pb-2 pe-3">
                            <div class="row">
                                <div class="col-12 ps-3 pe-3 pt-2 pb-1">
                                    <span><?php echo ($chatData["chat_content"]); ?></span>
                                </div>
                                <div class="col-12 d-flex flex-row justify-content-end">
                                    <span class="post-date-text"><?php echo (date("h:i a", strtotime($chatData["send_date_time"]))); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- receiver message card -->
<?php
                }

                Database::insertUpdateDelete("UPDATE `chat` SET `chat_status_id`='3' WHERE `to_user`='" . $_SESSION["user"]["email"] . "' AND `id`='" . $chatData["id"] . "'");
            }
        } else {
            echo ("Something went wrong");
        }
    } else {
        echo ("Something went wrong");
    }
} else {
    echo ("user rejected");
}
?>