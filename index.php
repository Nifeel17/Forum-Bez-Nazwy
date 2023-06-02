<!DOCTYPE html>
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

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona główna</title>
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
                    <a class="nav-link nav-item active">Strona główna</a>
                    <a href="forum.php" class="nav-link nav-item">Forum</a>
                    <a href="<?php if(isset($_SESSION['nazwa'])){ $id=$_SESSION['ID']; echo 'konto.php?ID=',$id; } else{ echo 'zalogujsie.php';} ?>" class="nav-link nav-item"><?php if(isset($_SESSION['nazwa'])) {echo $_SESSION['nazwa'];}else{echo "Konto";} ?></a>
                    <a href="znajomi.php" class="nav-link nav-item">Znajomi</a>
                    <a href="autor.php" class="nav-link nav-item">Autor</a>
                </div>
                <span class="navbar-text d-none d-md-block"><?php echo date('d/m'), "/20", date("y"); ?></span>
                <span class="pl-5 navbar-text d-none d-md-block"></span>
            </div>
        </div>
    </nav>
    <div class="jumbotron jumbotron-fluid text-black text-center">
        <div class="container"><h3 class="display-3">Forum</h3>
            <p class="lead"><?php if(isset($_SESSION['nazwa'])==false){echo"Najlepsze forum które nawet nie ma tematu!";}else{ echo "Świetnie że jesteś!";} ?></p>
            <a href="<?php if(isset($_SESSION['nazwa'])==false){ echo"rejestracja.php";}else{echo "forum.php"; } ?>">
                <button class="btn btn-info btn-lg"><?php if(isset($_SESSION['nazwa'])==false){ echo"Załóż konto już teraz!"; }else{echo "Przeglądaj forum!";} ?></button>
            </a>
        </div>
    </div>

    <div class="container pb-5 mb-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger">
                       Nowość!
                    </div>
                    <img src="zdjecie.png" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Znajomi</h3>
                        <h4 class="card-subtitle pb-1">Dodawaj swoich znajomych!</h4>
                        <p>Na stronę zawitał system znajomych! Od teraz możesz dodać swoich przyjaciół i przeglądać ich aktywność na forum!</p>
                        <a href="<?php if(isset($_SESSION['ID'])){ echo "znajomi.php"; }else{ echo "zalogujsie.php"; }  ?>" class="btn btn-primary card-link">Dodaj znajomych!</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pt-5">
                <div class="card">
                    <img src="zdjecie.png" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Forum</h3>
                        <h4 class="card-subtitle pb-1">Dodawaj i przeglądaj posty!</h4>
                        <p>Przeglądaj posty innych użytkowników! Dziel się wrażeniami dodając własny post, lub komentuj posty innych!</p>
                        <a href="forum.php" class="btn btn-primary card-link">Przeglądaj!</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 pt-5">
                <div class="card">
                    <img src="zdjecie.png" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Logowanie</h4>
                        <h4 class="card-subtitle pb-1">System zapamiętywania hasła</h3>
                        <p>Ciebie też irytują niekończące się ekrany logowania? Jeśli tak, to dobrze trafiłeś! Gdy zalogujesz się raz, masz spokój na następny miesiąc!</p>
                        <a href="zalogujsie.php" class="btn btn-primary card-link">Zaloguj się!</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pt-5">
                <div class="card">
                    <img src="zdjecie.png" class="card-img-top">
                    <div class="card-body">
                        <h3 class="card-title">Profil</h3>
                        <h4 class="card-subtitle">Personalizowanie swojej strony</h4>
                        <p>Każdy z nas lubi pokazać się od jak najlepszej strony. Teraz jest to możliwe, dzięki personalizowanym stronom profilu! Na co czekasz, personalizuj!</p>
                        <a href="<?php if(isset($_SESSION['ID'])){ echo "edytujprofil.php"; }else{ echo "zalogujsie.php"; }  ?>" class="btn btn-primary card-link">Personalizuj!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>