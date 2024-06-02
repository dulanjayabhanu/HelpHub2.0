<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"]) & !empty($_SESSION["user"])){
    if(isset($_GET["ctgId"]) & !empty($_GET)){
        $categoryId = $_GET["ctgId"];

        $userHasCategoryResultset = Database::search("SELECT * FROM `user_has_category` WHERE `category_id`='" . $categoryId . "' AND `user_email`='" . $_SESSION["user"]["email"] . "'");
        $userHasCategoryRownumber = $userHasCategoryResultset->num_rows;
        $userHasCategoryData = $userHasCategoryResultset->fetch_assoc();

        if($userHasCategoryRownumber > 0){
            Database::insertUpdateDelete("DELETE FROM `user_has_category` WHERE `id`='" . $userHasCategoryData["id"] . "'");
            echo("category removed");
        }else{
            Database::insertUpdateDelete("INSERT INTO `user_has_category` (`user_email`,`category_id`) VALUES 
            ('" . $_SESSION["user"]["email"] . "','" . $categoryId . "')");
            echo("category added");
        }
    }else{
        echo("Something went wrong");
    }
}else{
    echo("user rejected");
}
?>