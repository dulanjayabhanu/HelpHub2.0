<?php
require "connection.php";
require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST["username"])){
    $username = $_POST["username"];

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
    }else{
        $usernameResultSet = Database::search("SELECT * FROM `user` WHERE `username`='" . $username . "' OR `email`='" . $username . "'");
        $usernameRownumber = $usernameResultSet->num_rows;
    
        if($usernameRownumber > 0){
            $userData = $usernameResultSet->fetch_assoc();
            $email = $userData["email"];

            function generateUniqId($startNum, $idLenght)
            {
                $uniqId = uniqid();
                $newUniqId = substr($uniqId, intval($startNum), intval($idLenght));
                return $newUniqId;
            }
            $verificationCode = generateUniqId(5, 6);

            Database::insertUpdateDelete("UPDATE `user` SET `verification_code`='" . $verificationCode . "' WHERE `username`='". $username ."'");
            
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kerenlkrew@gmail.com';
            $mail->Password = 'wvbadwmvtljdwuyb';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('kerenlkrew@gmail.com', 'Help Hub');
            $mail->addReplyTo('kerenlkrew@gmail.com', 'Help Hub');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Help Hub Signin Verification Code';
            $bodyContent = '<div style="width: auto;height: auto;border-radius: 20px;background-image: linear-gradient(24deg, #dd6d18, #ef7820);padding-left: 20px;padding-right: 20px;padding-bottom: 20px;">
            <div style="text-align: center;font-size: 13px;font-weight:bold;padding-top:13px;">
                <span style="color: #fff;font-size:18px;">Verification Code</span>
                </div>
            <div style="margin-top: 30px;">
                <div style="padding-left:5px;padding-top:5px;padding-bottom:5px;padding-right:5px;border-radius: 20px;background-color: #e9e9e9;box-shadow: 0px 3px 5px 1px rgba(17, 14, 68, 0.1);text-align:center;">
                <h3 style="font-size: 14px;color: #3d1c02;">' . $verificationCode . '</h3>
                </div>
                </div>
                </div>';
            $mail->Body = $bodyContent;

            if (!$mail->send()) {
                Database::insertUpdateDelete("UPDATE `user` SET `verification_code`='' WHERE `username`='". $username ."'");
                echo ("Verification code sending failed");
            } else {
                echo ("success");
            }
        }else{
            echo("Invalied username");
        }
    }
}else{
    echo("Something went wrong");
}
?>