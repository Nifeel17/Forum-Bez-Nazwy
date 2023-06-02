<?php
session_start();
if(isset($_SESSION['nazwa'])==false)
{
    header("Location: index.php");
}
else if(isset($_GET['IDposta'])==false){
    header("Location: index.php");
}
else{
    $IDposta=$_GET['IDposta'];
    $IDosoby=$_SESSION['ID'];
    require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $sql="DELETE FROM lajki WHERE ID_osoby='$IDosoby' AND ID_posta='$IDposta'";
    if($polaczenie->query($sql))
        {
            header("Location: post.php?IDposta=$IDposta");
        }
}
?>