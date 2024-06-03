<?php
session_start();
require "connection.php";

if (isset($_POST["username"]) & isset($_POST["password"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username)) {
        echo ("Enter username");
    } else if (strlen($username) > 15) {
        echo ("Username too long");
    } else if (strlen($username) <= 4) {
        echo ("Username too short");
    } else if (is_numeric($username)) {
        echo ("Invalied username");
    } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) {
        echo ("You can't use specail characters ([@_!#$%^&*()<>?/|}{~:]) for username");
    } else if (empty($password)) {
        echo ("Enter password");
    } else if (strlen($password) > 16 | strlen($password) < 8) {
        echo ("Recomended password length is 8-16");
    } else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)) {
        echo ("Password too weak, password must contain at least <br/>&nbsp;&nbsp;&nbsp; one number [0-9], <br/>&nbsp;&nbsp;&nbsp; one upper case letter [A-Z], <br/>&nbsp;&nbsp;&nbsp; one lower case letter [a-z] and <br/>&nbsp;&nbsp;&nbsp; one special character [@,#,&,...]");
    } else {

        $userResultset = Database::search("SELECT * FROM `user` WHERE `username`='" . $username . "' AND `password`='" . $password . "'");
        $userRownumber = $userResultset->num_rows;

        if ($userRownumber > 0) {
            $userData = $userResultset->fetch_assoc();
            $_SESSION["user"] = $userData;
            echo ("success");
        } else {
            echo ("Invalied username or password");
        }
    }
} else {
    echo ("Something went wrong");
}
