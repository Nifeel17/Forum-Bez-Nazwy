<?php
session_start();
if(isset($_SESSION['nazwa'])==false||isset($_SESSION['ID'])==false){
    header("Location: index.php");
}
else{
   $iddodawanego=$_GET['IDznajdododania'];
$iddodajacego=$_SESSION['ID'];
require_once "connect.php";
$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
$sql="SELECT * FROM uzytkownicy WHERE ID='$iddodawanego'";
if($rezultat=@$polaczenie->query($sql))
{
    $wiersz=$rezultat->fetch_assoc();
    $nazwadodawanego=$wiersz['nazwa'];
    $nazwadodajacego=$_SESSION['nazwa'];
    $data=date("y-m-d");
    $sql="INSERT INTO zaproszenia VALUES(default, '$iddodajacego','$iddodawanego','$nazwadodajacego','$nazwadodawanego', '$data')";
    if($rezultat=@$polaczenie->query($sql))
    {
        header("Location: konto.php?ID=$iddodawanego");
    }
} 
}




?>