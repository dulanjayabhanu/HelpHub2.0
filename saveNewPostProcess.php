<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
    if (isset($_POST["postHeader"]) & isset($_POST["postContent"]) & isset($_POST["postCategory"]) & isset($_POST["selectedTagsArray"])) {
        $postHeader = $_POST["postHeader"];
        $postContent = $_POST["postContent"];
        $postCategory = $_POST["postCategory"];
        $selectedTagsArray = json_decode($_POST["selectedTagsArray"]);

        if (empty($postHeader)) {
            echo ("Empty post header");
        } else if (strlen($postHeader) > 100) {
            echo ("Post header too long");
        } else if (strlen($postHeader) < 4) {
            echo ("Post header too short");
        } else if (is_numeric($postHeader)) {
            echo ("Invalied post header");
        } else if (preg_match('/[\'^£$*()}{~><>,|=_¬]/', $postHeader)) {
            echo ("You can't use specail characters ([_!$^*()<>?/|}{~:]) for post header");
        } else if (empty($postContent)) {
            echo ("Empty post content");
        } else if (strlen($postContent) > 1500) {
            echo ("Post content too long");
        } else if (strlen($postContent) < 1) {
            echo ("Post content too short");
        } else if (is_numeric($postContent)) {
            echo ("Invalied post content");
        } else if (preg_match('/[\'^£$*}{~><>|=_¬]/', $postContent)) {
            echo ("You can't use specail characters ([_!$^*<>?|}{~:]) for post content");
        } else if ($postCategory == "0" | empty($postCategory)) {
            echo ("Select a category");
        } else {
            $postResultset = Database::search("SELECT * FROM `posts` WHERE `user_email`='" . $_SESSION["user"]["email"] . "' AND 
            `title`='" . $postHeader . "' AND 
            `content`='" . $postContent . "'");
            $postRownumber = $postResultset->num_rows;

            if ($postRownumber > 0) {
                echo ("Post already published");
            } else {
                $dateTime = new DateTime();
                $timeZone = new DateTimeZone("Asia/colombo");
                $dateTime->setTimezone($timeZone);
                $newDateTimeString = $dateTime->format("Y-m-d H:i:s");

                Database::insertUpdateDelete("INSERT INTO `posts` (`user_email`,`title`,`content`,`category_id`,`date_time`) 
            VALUES ('" . $_SESSION["user"]["email"] . "','" . $postHeader . "','" . $postContent . "','" . $postCategory . "','" . $newDateTimeString . "')");

                $postResultset2 = Database::search("SELECT * FROM `posts` WHERE `user_email`='" . $_SESSION["user"]["email"] . "' AND 
            `title`='" . $postHeader . "' AND 
            `content`='" . $postContent . "' AND 
            `category_id`='" . $postCategory . "' AND 
            `date_time`='" . $newDateTimeString . "'");
                $postData = $postResultset2->fetch_assoc();

                if (sizeof($selectedTagsArray) > 0) {
                    for ($y = 0; $y < sizeof($selectedTagsArray); $y++) {
                        Database::insertUpdateDelete("INSERT INTO `posts_has_tage` (`posts_id`,`tage_id`) VALUES 
                    ('" . $postData["id"] . "','" . $selectedTagsArray[$y] . "')");
                    }
                }

                if (sizeof($_FILES) > 4 & sizeof($_FILES) > 0) {
                    echo ("Maximum image count is 04");
                } else if (sizeof($_FILES) <= 4 & sizeof($_FILES) > 0) {
                    $allowedIMageFileExtentions = array("image/jpg", "image/jpeg", "image/png");

                    for ($x = 0; $x < sizeof($_FILES); $x++) {
                        if (isset($_FILES["image" . $x])) {
                            $file = $_FILES["image" . $x];
                            if (in_array($file["type"], $allowedIMageFileExtentions)) {
                                $fileName = uniqid() . ".jpeg";
                                move_uploaded_file($file["tmp_name"], "resources/images/post_images/" . $fileName);

                                Database::search("INSERT INTO `post_images` (`path`) VALUES ('" . $fileName . "')");

                                $postImageResultset = Database::search("SELECT * FROM `post_images` WHERE `path`='" . $fileName . "'");
                                $postImageData = $postImageResultset->fetch_assoc();
                                Database::search("INSERT INTO `posts_has_post_images` (`posts_id`,`post_images_id`) VALUES ('" . $postData["id"] . "','" . $postImageData["id"] . "')");
                            }
                        }
                    }
                }

                echo ("success");
            }
        }
    } else {
        echo ("Something went wrong");
    }
} else {
    echo ("user rejected");
}
