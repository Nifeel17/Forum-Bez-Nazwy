<?php
    session_start();
    if(isset($_SESSION['nazwa'])==false||isset($_SESSION['ID'])==false){
        header("Location: index.php");
    }
    else{
       $idzapraszajacego=$_GET['IDniezaak'];
    $twojeid=$_SESSION['ID'];
    require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $sql="DELETE FROM zaproszenia WHERE IDzapraszajacego='$idzapraszajacego' AND IDzaproszonego='$twojeid'";
    if($rezultat=@$polaczenie->query($sql))
     {
        header("Location: znajomi.php");
     } 
    }
    
?>