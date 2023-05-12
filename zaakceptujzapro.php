<?php
    session_start();
    if(isset($_SESSION['nazwa'])==false||isset($_SESSION['ID'])==false){
        header("Location: index.php");
    }
    else{
        if(isset($_GET['ktorastronka']))
        {
           $ktorastronka=$_GET['ktorastronka']; 
        }
        else{
            $ktorastronka=0;
        }
       $idzapraszajacego=$_GET['IDzapro'];
    $twojeid=$_SESSION['ID'];
    require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $sql="DELETE FROM zaproszenia WHERE IDzapraszajacego='$idzapraszajacego' AND IDzaproszonego='$twojeid'";
    if($rezultat=@$polaczenie->query($sql))
     {
        $data=date("y-m-d");
        $twojanazwa=$_SESSION['nazwa'];
        $sql="SELECT * FROM uzytkownicy WHERE ID='$idzapraszajacego'";
        if($rezultat=@$polaczenie->query($sql))
        {
            $wierszyk=$rezultat->fetch_assoc();
            $nazwadrugiego=$wierszyk['nazwa'];
            $sql="INSERT INTO znajomi VALUES(default,'$idzapraszajacego', '$twojeid','$data','$nazwadrugiego','$twojanazwa')";
            if($rezultat=@$polaczenie->query($sql))
            {
                if($ktorastronka==1)
                {
                    header("Location: znajomi.php");
                }
                else{
                    header("Location: konto.php?ID=$idzapraszajacego");
                }
                
            }
        }
     } 
    }
    
?>