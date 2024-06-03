<?php
require "connection.php";

if(isset($_POST["firstName"])&isset($_POST["lastName"])&isset($_POST["username"])&isset($_POST["mobile"])&isset($_POST["email"])&isset($_POST["password"])&isset($_POST["gender"])){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $username = $_POST["username"];
    $mobile = $_POST["mobile"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $gender = $_POST["gender"];

    if(empty($firstName)){
        echo("Enter first name");
    }else if(strlen($firstName) > 20){
        echo("First name too long ");
    }else if(is_numeric($firstName)){
        echo("Invalied first name");
    }else if(strlen($firstName) <= 3){
        echo("First name too short");
    }else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $firstName)) { 
        echo("You can't use specail characters ([@_!#$%^&*()<>?/|}{~:]) for first name");
    }else if(empty($lastName)){
        echo("Please enter last name");
    }else if(strlen($lastName) > 20){
        echo("Last name too long ");
    }else if(is_numeric($lastName)){
        echo("Invalied last name");
    }else if(strlen($lastName) <= 3){
        echo("Last name too short");
    }else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $lastName)) { 
        echo("You can't use specail characters ([@_!#$%^&*()<>?/|}{~:]) for last name");
    }else if(empty($username)){
        echo("Enter username");
    }else if(strlen($username) > 15){
        echo("Username too long");
    }else if(strlen($username) <= 4){
        echo("Username too short");
    }else if(is_numeric($username)){
        echo("Invalied username");
    }else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) { 
        echo("You can't use specail characters ([@_!#$%^&*()<>?/|}{~:]) for username");
    }else if(empty($mobile)){
        echo("Enter mobile");
    }else if(strlen($mobile) != 10){
        echo("Mobile must have 10 numbers");
    }else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)){
        echo("Invalied mobile");
    }else if(empty($email)){
        echo("Enter email");
    }else if(strlen($email) > 50){
        echo("Email too long");
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo("Invalied email");
    }else if(empty($password)){
        echo("Enter password");
    }else if(strlen($password) > 16 | strlen($password) < 8){
        echo("Recomended password length is 8-16");
    }else if(!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#",$password)){
        echo("Password too weak, password must contain at least <br/>&nbsp;&nbsp;&nbsp; one number [0-9], <br/>&nbsp;&nbsp;&nbsp; one upper case letter [A-Z], <br/>&nbsp;&nbsp;&nbsp; one lower case letter [a-z] and <br/>&nbsp;&nbsp;&nbsp; one special character [@,#,&,...]");
    }else if(empty($gender)){
        echo("Select a gender");
    }else if($gender == "0"){
        echo("Select a gender");
    }else {
        $usernameResultset = Database::search("SELECT * FROM `user` WHERE `username`='" . $username . "'");
        $usernameRownumber = $usernameResultset->num_rows;

        if($usernameRownumber > 0){
            echo("Username already taken");
        }else{
            $userResultset = Database::search("SELECT * FROM `user` WHERE `mobile`='" . $mobile . "' OR `email`='" . $email . "'");
            $userRownumber = $userResultset->num_rows;

            if($userRownumber > 0){
                echo("This mobile or email is already used. Try another email or mobile");
            }else{
                Database::insertUpdateDelete("INSERT INTO `user` (`email`,`first_name`,`last_name`,`mobile`,`username`,`password`,`gender_id`) VALUES 
                ('" . $email . "','" . $firstName . "','" . $lastName . "','" . $mobile . "','" . $username . "','" . $password . "','" . $gender . "')");
                
                echo("success");
            }
        }
    }
}else{
    echo("Something went wrong");
}
?>