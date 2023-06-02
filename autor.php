<?php
session_start();
if(isset($_SESSION['zgodanacookies'])==false)
{
    $_SESSION['zgodanacookies']=0;
}
?>

<?php
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autor</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
        <a class="pr-5 navbar-brand">Logo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <div class="navbar-nav mr-auto">
                    <a href="index.php" class="nav-link nav-item">Strona główna</a>
                    <a href="forum.php" class="nav-link nav-item">Forum</a>
                    <a href="<?php if(isset($_SESSION['ID'])){$id=$_SESSION['ID']; echo 'konto.php?ID=',$id;}else{ echo "zalogujsie.php";} ?>" class="nav-link nav-item"><?php if(isset($_SESSION['nazwa'])){echo $_SESSION['nazwa']; }else{ echo "Konto"; }?></a>
                    <a href="znajomi.php" class="nav-link nav-item">Znajomi</a>
                    <a href="autor.php" class="nav-link nav-item active">Autor</a>
                </div>
            <span class="navbar-text d-none d-md-block"><?php echo date('d/m'), "/20", date("y"); ?></span>
            <span class="pl-5 navbar-text d-none d-md-block"></span>
        </div>
    </div>
</nav>
<div class="jumbotron jumbotron-fluid text-black text-center">
        <div class="container">
            <h3 class="display-3">Autor</h3>
            <h4>Wiktor G. 2TP</h4>
        </div>
    </div>

<div class="container">
    <div class="row">
        <div class="text-center col-12 col-lg-8 offset-lg-2">
            <p style="font-size:24px;">Autor forum nie bierze odpowiedzialności za dane osobowe podane podczas rejestracji, 
            informacje podane w postach lub komentarzach lub za cokolwiek innego związanego z działaniem forum. 
            Jednocześnie rości sobie on prawo do wykorzystywania treści przekazywanych przez użytkowników, którzy publikując je
            zaświadczają że są ich autorem bądź mają wyraźne pozwolenie prawdziwego autora na ich publikacje. Ktoś to jeszcze czyta? 
            Autor forum nie bierze jakiejkolwiek odpowiedzialności za treści postów publikowane przez społeczność. Byłoby tego jeszcze
            z 5 stron, ale każdy miałby to gdzieś, więc jednym słowem: KORZYSTASZ NA WŁASNĄ ODPOWIEDZIALNOŚĆ!</p>
            <p style="font-size:7px;">Jeśli ktoś weźmie to na poważnie to trochę śmieszno XD</p>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>