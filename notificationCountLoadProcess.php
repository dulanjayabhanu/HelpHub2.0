<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"]["email"]) & !empty($_SESSION["user"]["email"])){
    $notificationResultset = Database::search("SELECT COUNT(`id`) FROM `notification` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
    $notificationData = $notificationResultset->fetch_assoc();

    if($notificationData["COUNT(`id`)"] > 99){
        echo("99+");
    }else if($notificationData["COUNT(`id`)"] < 10){
        echo("0" . $notificationData["COUNT(`id`)"]);
    }else{
        echo($notificationData["COUNT(`id`)"]);
    }
}else{
    echo("user rejected");
}
?>