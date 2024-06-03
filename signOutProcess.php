<?php
session_start();

if(isset($_SESSION["user"]) & !empty($_SESSION["user"])){
    $_SESSION["user"] = "";
    session_destroy();
    echo("success");
}else{
    echo("user rejected");
}

?>