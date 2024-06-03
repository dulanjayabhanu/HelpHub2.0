<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"]) & !empty($_SESSION["user"])){
    if(isset($_POST["pstId"]) & !empty($_POST["pstId"]) & isset($_POST["atorMl"]) & !empty($_POST["atorMl"]) ){
        $commentText = $_POST["commentText"];

        if (empty($commentText)) {
            echo ("Empty comment");
        } else if (strlen($commentText) > 800) {
            echo ("Comment too long");
        } else if (strlen($commentText) < 1) {
            echo ("Comment too short");
        } else if (is_numeric($commentText)) {
            echo ("Invalied Comment content");
        } else if (preg_match('/[\'^£$*}{~><>|=_¬]/', $commentText)) {
            echo ("You can't use specail characters ([_!$^*<>?|}{~:]) for comment content");
        }else{
            $commentResultset = Database::search("SELECT * FROM `comments` WHERE `id`='" . $_POST["pstId"] . "' AND `user_email`='" . $_SESSION["user"]["email"] . "' AND `comment`='" . $commentText . "'");
            $commentRownumber = $commentResultset->num_rows;

            if($commentRownumber > 0){
                echo("Dublicate comment content");
            }else{
                Database::insertUpdateDelete("INSERT INTO `comments` (`posts_id`,`user_email`,`comment`) VALUES 
                ('" . $_POST["pstId"] . "','" . $_SESSION["user"]["email"] . "','" . $commentText . "')");
                echo("success");
                Database::insertUpdateDelete("INSERT INTO `notification` (`user_email`,`notification_status_id`) VALUES 
                ('" . $_POST["atorMl"] . "','5')");
            }
        }
    }else{
        echo("Something went wrong");
    }
}else{
    echo("user rejected");
}
?>