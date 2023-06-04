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
require_once "connect.php";
$polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
$IDposta=$_GET['IDposta'];
$sql="SELECT * FROM posty WHERE ID='$IDposta'";
if($rezultat=@$polaczenie->query($sql))
 {
    $wiersz=$rezultat->fetch_assoc();
    $nazwaposta=$wiersz['nazwaposta'];
    $nazwaautora=$wiersz['Nazwaautora'];
    $IDautora=$wiersz['IDautora'];
    $datadodania=$wiersz['data_dodania'];
    $zawartosc=$wiersz['zawartosc'];
 }
 $dodallike=0;
 $ilelike=0;
 require_once "connect.php";
 $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
 if(isset($_SESSION['nazwa'])){
    $sql="SELECT * FROM lajki WHERE ID_posta='$IDposta'";
    if($rezultat=@$polaczenie->query($sql))
    {
        while($row=mysqli_fetch_assoc($rezultat))
        {
            $ilelike++;
            if($row['ID_osoby']==$_SESSION['ID']){
                $dodallike++;
            }
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title><?php echo "$nazwaposta" ?></title>
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
                    <a href="<?php if(isset($_SESSION['ID'])){$id=$_SESSION['ID']; echo 'konto.php?ID=',$id;}else{ echo "zalogujsie.php";} ?>" class="nav-link nav-item"><?php if(isset($_SESSION['nazwa'])){echo $_SESSION['nazwa']; }else{ echo "Konto"; }?></a>
                    <a href="znajomi.php" class="nav-link nav-item">Znajomi</a>
                    <a href="autor.php" class="nav-link nav-item">Autor</a>
                </div>
            <span class="navbar-text d-none d-md-block"><?php echo date('d/m'), "/20", date("y"); ?></span>
            <span class="pl-5 navbar-text d-none d-md-block"></span>
        </div>
    </div>
</nav>

<div class="container border-bottom pb-4">
    <div class="row mt-5">
        <div class="col-12 offset-0 text-center col-lg-10 offset-lg-1">
            <div class="display-2"><?php echo $nazwaposta; ?></div>
            <div class="display-4"><a style="text-decoration: none; color:black;" href="<?php echo "konto.php?ID=$IDautora"; ?>"><?php echo $nazwaautora; ?></a></div>
            <div class="mt-5" style="font-size:24px;"><?php echo $zawartosc; ?></div>
            <div class="col-10 offset-1 mt-3 text-center"><?php echo $datadodania; echo "<br>Liczba polubień: "; echo $ilelike; ?></div>
            <div class="col-10 offset-1 mt-3 text-center"><a  href="<?php if($dodallike==1){ echo "usunlike.php?IDposta=$IDposta"; }else if(isset($_SESSION['nazwa'])){ echo "dodajlike.php?IDposta=$IDposta"; }else{ echo "zalogujsie.php";} ?>"><button class="btn btn-primary"><?php if($dodallike==1){ echo "Usuń like"; }else{ echo "Lubię to!"; } ?></button></a></div>
            <div class="col-10 offset-1 mt-3 text-center"><a href="forum.php"><button class="btn btn-primary">Powrót do forum</button></a></div>
        </div>
    </div>
</div>
<div class="container">
<?php
if(isset($_SESSION['zawartosckom']))
{
    echo "<div class='alert alert-info mt-5' role='alert'>Zawartość komentarza powinna zawierać minimum 10 znaków!<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span></button></div>";
    unset($_SESSION['zawartosckom']);
}
?>
    <div class="col-12 offset-0 col-lg-10 offset-1 pt-3 mt-3">
        <h4 class="offset-0 col-10 offset-lg-1">Dodaj komentarz</h4>
        <form method="POST" action="dodajkomentarz.php?ID=<?php echo $IDposta; ?>">
            <textarea id="komentarzzawartosc" name="komentarzzawartosc" class="offset-0 col-10 offset-lg-1"><?php if(isset($_SESSION['zawartosckom'])){ echo $_SESSION['zawartosckom']; } ?></textarea>
            <button onclick="submit"  class="btn btn-primary offset-0 col-10 offset-lg-1">Dodaj komentarz!</button>
        </form>
    </div>
</div>
<div class="container py-3">
    <?php
     require_once "connect.php";
     $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
        $sql="SELECT * FROM komentarze WHERE ID_posta='$IDposta' ORDER BY data_dodania DESC";
        if($rezultat=@$polaczenie->query($sql))
        {
            $ilekomentarzy=$rezultat->num_rows;
            echo "<div class='col-10 offset-1 display-4'>Komentarze($ilekomentarzy):</div>";
            while($row=mysqli_fetch_assoc($rezultat))
            {
                $zawartosckom=$row['zawartosc'];
                $autorkom=$row['nazwa_autora'];
                $idautorakom=$row['ID_autora'];
                $datadodaniakom=$row['data_dodania'];
                echo "<article class='p-3 mt-3 col-10 offset-1 border rounded'><a style='text-decoration: none; color: black' href='konto.php?ID=$idautorakom'>$autorkom</a> $datadodaniakom<br><p>$zawartosckom</p></article>";
            }
        }
    ?>
    
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>