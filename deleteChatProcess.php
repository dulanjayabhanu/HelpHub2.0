<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"]) & !empty($_SESSION["user"])){
    if(isset($_GET["msgId"]) & !empty($_GET["msgId"])){

            Database::insertUpdateDelete("DELETE FROM `chat` WHERE `id`='" . $_GET["msgId"] . "'");
    }else{
        echo("Something went wrong");
    }
}else{
    echo("user rejected");
}
?>