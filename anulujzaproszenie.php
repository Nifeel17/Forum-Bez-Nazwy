<?php
 session_start();
 if(isset($_SESSION['nazwa'])==false||isset($_SESSION['ID'])==false){
     header("Location: index.php");
 }
 else if(isset($_GET['IDanulowanego'])==false)
 {
     header("Location: index.php");
 }
 else{
    $idznajanulowanego=$_GET['IDanulowanego'];
 $twojeid=$_SESSION['ID'];
 require_once "connect.php";
 $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
 $sql="DELETE FROM zaproszenia WHERE IDzapraszajacego='$twojeid' AND IDzaproszonego='$idznajanulowanego'";
 if($rezultat=@$polaczenie->query($sql))
 {
     header("Location: konto.php?ID=$idznajanulowanego");
 }

 }
 


?>