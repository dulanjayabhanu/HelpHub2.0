<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"]) & !empty($_SESSION["user"])){
    if(isset($_POST["pstId"]) & !empty($_POST["pstId"]) & isset($_POST["atorMl"]) & !empty($_POST["atorMl"])){
        $postId = $_POST["pstId"];

        $voteResultset = Database::search("SELECT * FROM `vote` WHERE `posts_id`='" . $postId . "' AND `user_email`='" . $_SESSION["user"]["email"] . "'");
        $voteRownumber = $voteResultset->num_rows;

        if($voteRownumber > 0){
            $voteData = $voteResultset->fetch_assoc();
            Database::insertUpdateDelete("DELETE FROM `vote` WHERE `id`='" . $voteData["id"] . "'");
            echo("down vote");
        }else{
            Database::insertUpdateDelete("INSERT INTO `vote` (`posts_id`,`user_email`) VALUES ('" . $postId . "','" . $_SESSION["user"]["email"] . "')");
            echo("up vote");
            Database::insertUpdateDelete("INSERT INTO `notification` (`user_email`,`notification_status_id`) VALUES 
                ('" . $_POST["atorMl"] . "','3')");
        }
    }else{
        echo("Something went wrong");
    }
}else{
    echo("User rejected");
}
?>