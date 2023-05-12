<?php
    session_start();
    if(isset($_SESSION['nazwa'])==false||isset($_SESSION['ID'])==false){
        header("Location: index.php");
    }
    else if(isset($_GET['IDznajdousuniecia'])==false)
    {
        header("Location: index.php");
    }
    else{
       $idznajdousuniecia=$_GET['IDznajdousuniecia'];
    $twojeid=$_SESSION['ID'];
    require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $sql="DELETE FROM znajomi WHERE (ID1='$idznajdousuniecia' AND ID2='$twojeid') OR (ID1='$twojeid' AND ID2='$idznajdousuniecia')";
    if($rezultat=@$polaczenie->query($sql))
    {
        header("Location: konto.php?ID=$idznajdousuniecia");
    } 
    }
    
?>