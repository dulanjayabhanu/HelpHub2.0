<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"]) & !empty($_SESSION["user"])) {
    if (isset($_GET["cmnt_id"]) & !empty($_GET["cmnt_id"])) {

        $commentResultset = Database::search("SELECT * FROM `comments` WHERE `id`='" . $_GET["cmnt_id"] . "' AND `user_email`='" . $_SESSION["user"]["email"] . "'");
        $commentRownumber = $commentResultset->num_rows;

        if ($commentRownumber > 0) {
            Database::insertUpdateDelete("DELETE FROM `comments` WHERE `id`='" . $_GET["cmnt_id"] . "'");
            echo ("success");
        } else {
            echo ("Something went wrong1");
        }
    } else {
        echo ("Something went wrong2");
    }
} else {
    echo ("user rejected");
}
