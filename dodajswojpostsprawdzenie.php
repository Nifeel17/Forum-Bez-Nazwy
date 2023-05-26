<?php
session_start();
if(isset($_SESSION['nazwa'])==false){
header("Location: index.php");
}
if(isset($_SESSION['bladnazwyposta']))
{
    unset($_SESSION['bladnazwyposta']);
}
if(isset($_SESSION['bladzawartosciposta']))
{
    unset($_SESSION['bladzawartosciposta']);
}
if(isset($_SESSION['zawartoscpostazPOST']))
{
    unset($_SESSION['zawartoscpostazPOST']);
}
if(isset($_SESSION['nazwapostazPOST']))
{
    unset($_SESSION['nazwapostazPOST']);
}
$nazwaposta=$_POST['nazwaposta'];
$zawartosc=$_POST['zawartoscposta'];
require_once "connect.php";
$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
$sql="SELECT * FROM posty WHERE nazwaposta='$nazwaposta'";
if($rezultat=@$polaczenie->query($sql))
{
    $liczbapostow=$rezultat->num_rows;
    if(strlen($zawartosc)<20 || strlen($zawartosc)>500 )
    {
        $_SESSION['bladzawartosciposta']=1;
    }
    if($liczbapostow!=0)
    {
        $_SESSION['bladnazwyposta']=1;
    }
    if(isset($_SESSION['bladnazwyposta'])||isset($_SESSION['bladzawartosciposta']))
    {
        $_SESSION['zawartoscpostazPOST']=$zawartosc;
        $_SESSION['nazwapostazPOST']=$nazwaposta;
        header("Location: dodajswojpost.php");
    }
    else{
        $IDautora=$_SESSION['ID'];
        $nazwaautora=$_SESSION['nazwa'];
        $data=date("y-m-d");
        $sql="INSERT INTO posty VALUES(default,'$nazwaposta','nazwaautora','$IDautora','$data','$zawartosc')";
        if($polaczenie->query($sql))
        {
            header("Location: forum.php");
        }

    }



}


?>