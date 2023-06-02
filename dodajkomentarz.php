<?php
session_start();
if(isset($_SESSION['nazwa'])==false){
    header("Location: index.php");
}
else if(isset($_GET['ID'])==false){
 header("Location: index.php");
}
else{
    if(isset($_SESSION['zawartosckom']))
    {
        unset($_SESSION['zawartosckom']);
    }
    $IDposta=$_GET['ID'];
    $zawartosc=$_POST['komentarzzawartosc'];
    $IDautora=$_SESSION['ID'];
    $nazwaautora=$_SESSION['nazwa'];
    $data=date("y-m-d");
    if(strlen($zawartosc)>10){
        require_once "connect.php";
        $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
        $sql="INSERT INTO komentarze VALUES('default','$IDposta','$IDautora','$nazwaautora','$data','$zawartosc')";
        if($polaczenie->query($sql))
        {
             header("Location: post.php?IDposta=$IDposta");  
        }
    }
    else{
        $_SESSION['zawartosckom']=$zawartosc;
        header("Location: post.php?IDposta=$IDposta");  
    }

}
?>