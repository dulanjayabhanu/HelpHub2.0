<?php
require "connection.php";

if (isset($_POST["verificationCode"]) & isset($_POST["newPassword"]) & isset($_POST["username"])) {
    $username = $_POST["username"];
    $verificationCode = $_POST["verificationCode"];
    $newPassword = $_POST["newPassword"];

    if(empty($verificationCode)){
        echo("Enter verification code");
    }else if(strlen($verificationCode) != 6){
        echo("Verification code must have 6 letters");
    }else if (empty($newPassword)) {
        echo ("Enter password");
    } else if (strlen($newPassword) > 16 | strlen($newPassword) < 8) {
        echo ("Recomended password length is 8-16");
    } else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $newPassword)) {
        echo ("Password too weak, password must contain at least <br/>&nbsp;&nbsp;&nbsp; one number [0-9], <br/>&nbsp;&nbsp;&nbsp; one upper case letter [A-Z], <br/>&nbsp;&nbsp;&nbsp; one lower case letter [a-z] and <br/>&nbsp;&nbsp;&nbsp; one special character [@,#,&,...]");
    } else {
        $userResultset = Database::search("SELECT * FROM `user` WHERE `verification_code`='" . $verificationCode . "' AND `username`='" . $username . "'");
        $userRownumber  = $userResultset->num_rows;

        if ($userRownumber > 0) {
            Database::insertUpdateDelete("UPDATE `user` SET `password`='" . $newPassword . "',`verification_code`='' WHERE `username`='" . $username . "'");
            echo("success");
        } else {
            echo ("Invalied verification code");
        }
    }
} else {
    echo ("Something went wrong");
}
