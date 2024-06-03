<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
    if (isset($_POST["recvrMl"]) & !empty($_POST["recvrMl"])) {
        if ($_SESSION["user"]["email"] != $_POST["recvrMl"]) {
            $chatResultset = Database::search("SELECT * FROM `chat` WHERE 
        (`from_user`='" . $_SESSION["user"]["email"] . "' AND `to_user`='" . $_POST["recvrMl"] . "') OR 
        (`from_user`='" . $_POST["recvrMl"] . "' AND `to_user`='" . $_SESSION["user"]["email"] . "')");
            $chatRownumber = $chatResultset->num_rows;

            if ($chatRownumber < 1) {
                $dateTime = new DateTime();
                $timeZone = new DateTimeZone("Asia/colombo");
                $dateTime->setTimezone($timeZone);
                $newDateTimeString = $dateTime->format("Y-m-d H:i:s");

                Database::insertUpdateDelete("INSERT INTO `chat` (`from_user`,`to_user`,`chat_content`,`chat_status_id`,`send_date_time`) VALUES 
            ('" . $_SESSION["user"]["email"] . "','" . $_POST["recvrMl"] . "','Hello there!!','4','" . $newDateTimeString . "')");
                echo ("success");
            } else {
                echo ("The chat is already available");
            }
        } else {
            echo ("Can not chat with yourself");
        }
    } else {
        echo ("Something went wrong");
    }
} else {
    echo ("user rejected");
}
