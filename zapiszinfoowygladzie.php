<?php
session_start();
$nrbanneru=$_POST['banner'];
$kolortla=$_POST['tlo'];
$id=$_SESSION['ID'];
require_once "connect.php";
$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
if($polaczenie->query("UPDATE profil SET numerbanneru='$nrbanneru', tlo='$kolortla' WHERE IDposiadacza='$id'"))
    {
        header("Location: edytujprofil.php");
    }
?>