<?php
session_start();
if(isset($_COOKIE['nazwa']))
{
    setcookie("nazwa", "", time() - 3600);
}
session_destroy();

header("Location: index.php");
?>