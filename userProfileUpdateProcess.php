<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {

    if (isset($_FILES["image"])) {
        $image = $_FILES["image"];

        $allowedImageExtentions = array("image/jpg", "image/jpeg", "image/png");
        $imageFileExtention = $image["type"];

        if (in_array($imageFileExtention, $allowedImageExtentions)) {
            move_uploaded_file($image["tmp_name"], "resources/images/profile_images/" . explode("@",$_SESSION["user"]["email"])[0] . ".jpeg");
        }
    }

    if (isset($_POST["firstName"]) & isset($_POST["lastName"]) & isset($_POST["bio"]) & isset($_POST["username"]) & isset($_POST["mobile"]) & isset($_POST["password"])) {
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $bio = $_POST["bio"];
        $username = $_POST["username"];
        $mobile = $_POST["mobile"];
        $password = $_POST["password"];

        $userResultset = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["user"]["email"] . "'");
        $userRownumber = $userResultset->num_rows;

        if ($userRownumber > 0) {
            $userData = $userResultset->fetch_assoc();

            $newFirstName;
            $newLastName;
            $newBio;
            $newUsername;
            $newMobile;
            $newPassword;

            $isFirstNameValiedOperation = false;
            $isLastNameValiedOperation = false;
            $isBioValiedOperation = false;
            $isUsernameValiedOperation = false;
            $isMobileValiedOperation = false;
            $isPasswordValiedOperation = false;

            if (!empty($firstName)) {
                if (strlen($firstName) > 20) {
                    $isFirstNameValiedOperation = false;
                    echo ("First name too long ");
                } else if (is_numeric($firstName)) {
                    $isFirstNameValiedOperation = false;
                    echo ("Invalied first name");
                } else if (strlen($firstName) <= 3) {
                    $isFirstNameValiedOperation = false;
                    echo ("First name too short");
                } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $firstName)) {
                    $isFirstNameValiedOperation = false;
                    echo ("You can't use specail characters ([@_!#$%^&*()<>?/|}{~:]) for first name");
                } else {
                    $isFirstNameValiedOperation = true;
                    $newFirstName = $firstName;
                }
            } else {
                $isFirstNameValiedOperation = true;
                $newFirstName = $userData["first_name"];
            }

            if ($isFirstNameValiedOperation) {
                if (!empty($lastName)) {
                    if (strlen($lastName) > 20) {
                        $isLastNameValiedOperation = false;
                        echo ("Last name too long ");
                    } else if (is_numeric($lastName)) {
                        $isLastNameValiedOperation = false;
                        echo ("Invalied last name");
                    } else if (strlen($lastName) <= 3) {
                        $isLastNameValiedOperation = false;
                        echo ("Last name too short");
                    } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $lastName)) {
                        $isLastNameValiedOperation = false;
                        echo ("You can't use specail characters ([@_!#$%^&*()<>?/|}{~:]) for last name");
                    } else {
                        $isLastNameValiedOperation = true;
                        $newLastName = $lastName;
                    }
                } else {
                    $isLastNameValiedOperation = true;
                    $newLastName = $userData["last_name"];
                }
            }

            if ($isLastNameValiedOperation) {
                if (!empty($bio)) {
                    if (strlen($bio) > 160) {
                        $isBioValiedOperation = false;
                        echo ("Bio too long ");
                    } else if (is_numeric($bio)) {
                        $isBioValiedOperation = false;
                        echo ("Invalied bio");
                    } else if (strlen($bio) <= 3) {
                        $isBioValiedOperation = false;
                        echo ("Bio too short");
                    } else if (preg_match('/[\'^£$%*()}{~?><>,=¬]/', $bio)) {
                        $isBioValiedOperation = false;
                        echo ("You can't use specail characters ([$%^*()<>?/}{~:]) for bio");
                    } else {
                        $isBioValiedOperation = true;
                        $newBio = $bio;
                    }
                } else {
                    $isBioValiedOperation = true;
                    $newBio = $userData["bio"];
                }
            }

            if ($isBioValiedOperation) {
                if (!empty($username)) {
                    if (strlen($username) > 15) {
                        $isUsernameValiedOperation = false;
                        echo ("Username too long");
                    } else if (strlen($username) <= 4) {
                        $isUsernameValiedOperation = false;
                        echo ("Username too short");
                    } else if (is_numeric($username)) {
                        $isUsernameValiedOperation = false;
                        echo ("Invalied username");
                    } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) {
                        $isUsernameValiedOperation = false;
                        echo ("You can't use specail characters ([@_!#$%^&*()<>?/|}{~:]) for username");
                    } else {
                        $usernameResultset = Database::search("SELECT * FROM `user` WHERE `email`<>'" . $_SESSION["user"]["email"] . "' AND `username`='" . $username . "'");
                        $usernameRownumber = $usernameResultset->num_rows;

                        if ($usernameRownumber > 0) {
                            $isUsernameValiedOperation = false;
                            echo ("This username already taken");
                        } else {
                            $isUsernameValiedOperation = true;
                            $newUsername = $username;
                        }
                    }
                } else {
                    $isUsernameValiedOperation = true;
                    $newUsername = $userData["username"];
                }
            }

            if ($isUsernameValiedOperation) {
                if (!empty($mobile)) {
                    if (strlen($mobile) != 10) {
                        $isMobileValiedOperation = false;
                        echo ("Mobile must have 10 numbers");
                    } else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
                        $isMobileValiedOperation = false;
                        echo ("Invalied mobile");
                    } else {
                        $mobileResultset = Database::search("SELECT * FROM `user` WHERE `email`<>'" . $_SESSION["user"]["email"] . "' AND `mobile`='" . $mobile . "'");
                        $mobileRownumber = $mobileResultset->num_rows;

                        if ($mobileRownumber > 0) {
                            $isMobileValiedOperation = false;
                            echo ("This mobile already used");
                        } else {
                            $isMobileValiedOperation = true;
                            $newMobile = $mobile;
                        }
                    }
                } else {
                    $isMobileValiedOperation = true;
                    $newMobile = $userData["mobile"];
                }
            }

            if ($isMobileValiedOperation) {
                if (!empty($password)) {
                    if (empty($password)) {
                        $isPasswordValiedOperation = false;
                        echo ("Enter password");
                    } else if (strlen($password) > 16 | strlen($password) < 8) {
                        $isPasswordValiedOperation = false;
                        echo ("Recomended password length is 8-16");
                    } else if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)) {
                        $isPasswordValiedOperation = false;
                        echo ("Password too weak, password must contain at least <br/>&nbsp;&nbsp;&nbsp; one number [0-9], <br/>&nbsp;&nbsp;&nbsp; one upper case letter [A-Z], <br/>&nbsp;&nbsp;&nbsp; one lower case letter [a-z] and <br/>&nbsp;&nbsp;&nbsp; one special character [@,#,&,...]");
                    } else {
                        $isPasswordValiedOperation = true;
                        $newPassword = $password;
                    }
                } else {
                    $isPasswordValiedOperation = true;
                    $newPassword = $userData["password"];
                }
            }

            if ($isFirstNameValiedOperation & $isLastNameValiedOperation & $isBioValiedOperation & $isUsernameValiedOperation & $isMobileValiedOperation & $isPasswordValiedOperation) {
                Database::insertUpdateDelete("UPDATE `user` SET `first_name`='" . $newFirstName . "',`last_name`='" . $newLastName . "',`bio`='" . $newBio . "',`username`='" . $newUsername . "',`mobile`='" . $newMobile . "',`password`='" . $newPassword . "' WHERE `email`='" . $_SESSION["user"]["email"] . "'");
                
                $_SESSION["user"]["first_name"] = $newFirstName;
                $_SESSION["user"]["last_name"] = $newLastName;
                $_SESSION["user"]["bio"] = $newBio;
                $_SESSION["user"]["username"] = $newUsername;
                $_SESSION["user"]["mobile"] = $newMobile;
                $_SESSION["user"]["password"] = $newPassword;
                
                echo ("success");
            }
        } else {
            echo ("user rejected");
        }
    } else {
        echo ("Something went wrong");
    }
} else {
    echo ("user rejected");
}
