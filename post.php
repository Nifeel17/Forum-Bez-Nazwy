<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION['zgodanacookies'])==false)
{
    $_SESSION['zgodanacookies']=0;
}

if(isset($_COOKIE['nazwa'])&&isset($_SESSION['nazwa'])==false){
    $_SESSION['nazwa']=$_COOKIE['nazwa'];
    require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $nazwa=$_SESSION['nazwa'];
    $sql="SELECT * FROM uzytkownicy WHERE nazwa='$nazwa'";
    if($rezultat=@$polaczenie->query($sql))
     {
        $wiersz=$rezultat->fetch_assoc();
        $_SESSION['ID']=$wiersz['ID'];
        $_SESSION['haslo']=$wiersz['haslo'];
        $_SESSION['plec']=$wiersz['plec'];
        $_SESSION['mail']=$wiersz['mail'];
        $_SESSION['wiek']=$wiersz['wiek'];
        $_SESSION['data-dolaczenia']=$wiersz['data_dolaczenia'];
    }
}
if(isset($_SESSION['nazwa']))
{
    require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $nazwa=$_SESSION['nazwa'];
    $sql="SELECT * FROM uzytkownicy WHERE nazwa='$nazwa'";
    if($rezultat=@$polaczenie->query($sql))
     {
        $wiersz=$rezultat->fetch_assoc();
        $_SESSION['ID']=$wiersz['ID'];
        $_SESSION['haslo']=$wiersz['haslo'];
        $_SESSION['plec']=$wiersz['plec'];
        $_SESSION['mail']=$wiersz['mail'];
        $_SESSION['wiek']=$wiersz['wiek'];
        $_SESSION['data-dolaczenia']=$wiersz['data_dolaczenia'];
    }
    if(isset($_COOKIE['nazwa'])&&$_COOKIE['nazwa']!=$_SESSION['nazwa']&&$_SESSION['zgodanacookies']==1)
    {
        $nazwa=$_SESSION['nazwa'];
        setcookie("nazwa","$nazwa",time() + (86400 * 30) );
    }
}
?>

<?php
$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
$IDposta=$_GET['IDposta'];
$sql="SELECT * FROM posty WHERE IDposta='$IDposta'";
if($rezultat=@$polaczenie->query($sql))
 {
    $wiersz=$rezultat->fetch_assoc();
 }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title><?php echo "" ?></title>
</head>
<body>
    



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>