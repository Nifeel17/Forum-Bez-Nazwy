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
else{
    header("Location: zalogujsie.php");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> 
    <title>Dodaj swoj post</title>
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
                    <a href="forum.php" class="nav-link nav-item active">Forum</a>
                    <a href="<?php $id=$_SESSION['ID']; echo 'konto.php?ID=',$id; ?>" class="nav-link nav-item"><?php echo $_SESSION['nazwa']; ?></a>
                    <a href="znajomi.php" class="nav-link nav-item">Znajomi</a>
                    <a href="autor.php" class="nav-link nav-item">Autor</a>
                </div>
            <span class="navbar-text d-none d-md-block"><?php echo date('d/m'), "/20", date("y"); ?></span>
            <span class="pl-5 navbar-text d-none d-md-block"></span>
        </div>
    </div>
</nav>

<div class="container">
<div class="display-2 my-2 my-md-5 text-center">Dodaj swój post!</div>
    <div class="row">
        <div class="mt-5 col-12">
        <form method="POST" class="text-center" action="dodajswojpostsprawdzenie.php">
                <div class="form-row">
                    <div class="form-group col-10 offset-1 col-md-8 offset-md-2 pb-3">
                        <label for="nazwaposta">Tytuł</label>
                        <input type="text" name="nazwaposta" id="nazwaposta" placeholder="Tytuł twojego posta" class="form-control" value="<?php if(isset($_SESSION['nazwapostazPOST'])){ echo $_SESSION['nazwapostazPOST'];} ?>">
                        <div id="nazwapostazajeta" class="col-12 text-danger d-none">Nazwa posta jest juz zajęta!</div>
                    </div>
                    <div class="form-group col-10 offset-1 col-md-8 offset-md-2 pb-3">
                        <label for="zawartoscposta">Zawartość posta</label>
                        <textarea name="zawartoscposta" style="min-height:100px;" id="zawartoscposta" placeholder="Zawartość twojego posta" class="form-control"><?php if(isset($_SESSION['zawartoscpostazPOST'])){ echo $_SESSION['zawartoscpostazPOST']; } ?></textarea>
                        <div id="zladlugoscposta" class="col-12 text-danger d-none">Nieopdowiednia długość posta (od 20 do 500 znaków)</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-lg btn-primary">Opublikuj!</button>
            </form>
        </div>
    </div>
</div>

<script>
    if(<?php if(isset($_SESSION['bladnazwyposta'])){ echo "1"; } else { echo "0"; }  ?>==1)
    {
        document.getElementById('nazwapostazajeta').classList.remove('d-none');
        document.getElementById('nazwaposta').classList.add('is-invalid');
    }
    else if(<?php if(isset($_SESSION['nazwapostazPOST'])){ echo "1"; } ?> ==1){
        document.getElementById('nazwaposta').classList.add('is-valid');
    }
    if(<?php if(isset($_SESSION['bladzawartosciposta'])){ echo "1"; } else { echo "0"; }  ?>==1)
    {
        document.getElementById('zladlugoscposta').classList.remove('d-none');
        document.getElementById('zawartoscposta').classList.add('is-invalid');
    }
    else if(<?php if(isset($_SESSION['zawartoscpostazPOST'])){ echo "1"; } ?> ==1){
        document.getElementById('zawartoscposta').classList.add('is-valid');
    }
</script>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>