<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"]) & !empty($_SESSION["user"])){
    if(isset($_POST["recvrMl"]) & !empty($_POST["recvrMl"]) & isset($_POST["privateChatText"])){

        $privateChatText = $_POST["privateChatText"];

        if (empty($privateChatText)) {
            echo ("Empty message");
        } else if (strlen($privateChatText) > 800) {
            echo ("Message too long");
        } else if (strlen($privateChatText) < 1) {
            echo ("Message too short");
        } else if (preg_match('/[\'^£$*}{~><>|=_¬]/', $privateChatText)) {
            echo ("You can't use specail characters ([_!$^*<>?|}{~:]) for message content");
        }else{

            $dateTime = new DateTime();
            $timeZone = new DateTimeZone("Asia/colombo");
            $dateTime->setTimezone($timeZone);
            $newDateTimeString = $dateTime->format("Y-m-d H:i:s");

            Database::insertUpdateDelete("INSERT INTO `chat` (`from_user`,`to_user`,`chat_content`,`chat_status_id`,`send_date_time`) VALUES 
            ('" . $_SESSION["user"]["email"] . "','" . $_POST["recvrMl"] . "','" . $privateChatText . "','4','" . $newDateTimeString . "')");
            echo("success");
        }
    }else{
        echo("Something went wrong");
    }
}else{
    echo("user rejected");
}
?>