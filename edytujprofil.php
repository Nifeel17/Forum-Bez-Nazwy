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
if(isset($_SESSION['nazwa'])==false && isset($_SESSION['ID'])==false)
{
    header("Location: zalogujsie.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja profilu <?php echo $_SESSION['nazwa']; ?></title>
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
                    <a href="<?php echo 'konto.php?ID=',$_SESSION['ID']; ?>" class="nav-link nav-item active"><?php echo $_SESSION['nazwa']; ?></a>
                    <a href="znajomi.php" class="nav-link nav-item <?php if($id!=$idtego){ echo "active";} ?>">Znajomi</a>
                    <a href="autor.php" class="nav-link nav-item">Autor</a>
                </div>
                <span class="navbar-text d-none d-md-block"><?php echo date('d/m'), "/20", date("y"); ?></span>
                <span class="pl-5 navbar-text d-none d-md-block"></span>
            </div>
        </div>
    </nav>
<?php
require_once "connect.php";
$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
$id=$_SESSION['ID'];
$sql="SELECT * FROM profil WHERE IDposiadacza='$id'";
if($rezultat=@$polaczenie->query($sql))
{
    $wiersz=mysqli_fetch_assoc($rezultat);
    $wybranybanner=$wiersz['numerbanneru'];
    $kolortla=$wiersz['tlo'];
}
?>
<div class="container pt-5 text-center">
<h3 class="display-3 text-center pb-4"><?php echo $_SESSION['nazwa']; ?></h3>
    <div class="row">
        <div class="col-12 col-lg-6 border">
            <p class="display-4 pt-3">Wygląd profilu</p>
            <form action="zapiszinfoowygladzie.php" method="POST">
                <div class="pt-3">
                    <label for="banner">Banner</label>
                    <select name="banner" id="banner"> 
                        <option <?php if($wybranybanner==1){ echo "selected='selected'"; } ?> value="1">Szlaczki</option>
                        <option <?php if($wybranybanner==2){ echo "selected='selected'"; } ?> value="2">Krajobraz</option>
                        <option <?php if($wybranybanner==3){ echo "selected='selected'"; } ?> value="3">Ogień</option>
                    </select>
                </div>
                <div class="pt-3">
                    <label for="tlo">Kolor tła</label>
                    <select name="tlo" id="tlo"> 
                        <option <?php if($kolortla=="Biały"){ echo "selected='selected'"; } ?> value="Biały">Biały</option>
                        <option <?php if($kolortla=="Czarny"){ echo "selected='selected'"; } ?> value="Czarny">Czarny</option>
                    </select>
                </div>
                <button type="submit" class="btn my-4 btn-lg btn-primary">Zapisz wygląd profilu</button>
            </form>
        </div>
        <div class="col-12 col-lg-6 border">
            <p class="display-4 pt-3">Informacje o koncie</p>
            <form action="zapiszinfookoncie.php" method="POST">
            
        
        
        
            </form>
        </div>
    </div>
</div>





<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>      
</body>
</html>