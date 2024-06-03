<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"]) & !empty($_SESSION["user"])){
    if(isset($_GET["ntificn_id"]) & !empty($_GET["ntificn_id"])){

            Database::insertUpdateDelete("DELETE FROM `notification` WHERE `id`='" . $_GET["ntificn_id"] . "'");
    }else{
        echo("Something went wrong");
    }
}else{
    echo("user rejected");
}
?>