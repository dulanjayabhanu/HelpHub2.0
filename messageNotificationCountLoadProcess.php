<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"]["email"]) & !empty($_SESSION["user"]["email"])){
    $notificationResultset = Database::search("SELECT COUNT(`chat`.`id`) FROM `chat` INNER JOIN `chat_status` ON 
    `chat`.`chat_status_id`=`chat_status`.`id` WHERE `to_user`='" . $_SESSION["user"]["email"] . "' AND `chat_status`.`c_type`='unseen'");
    $notificationData = $notificationResultset->fetch_assoc();

    if($notificationData["COUNT(`chat`.`id`)"] > 99){
        echo("99+");
    }else if($notificationData["COUNT(`chat`.`id`)"] < 10){
        echo("0" . $notificationData["COUNT(`chat`.`id`)"]);
    }else{
        echo($notificationData["COUNT(`chat`.`id`)"]);
    }
}else{
    echo("user rejected");
}
?>