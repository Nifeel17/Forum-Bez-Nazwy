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
else{
    header("Location: zalogujsie.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Znajomi</title>
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
                    <a href="<?php if(isset($_SESSION['nazwa'])){ $id=$_SESSION['ID']; echo 'konto.php?ID=',$id; } else{ echo 'zalogujsie.php';} ?>" class="nav-link nav-item"><?php if(isset($_SESSION['nazwa'])) {echo $_SESSION['nazwa'];}else{echo "Konto";} ?></a>
                    <a href="znajomi.php" class="nav-link nav-item active">Znajomi</a>
                    <a href="autor.php" class="nav-link nav-item">Autor</a>
                </div>
                <span class="navbar-text d-none d-md-block"><?php echo date('d/m'), "/20", date("y"); ?></span>
                <span class="pl-5 navbar-text d-none d-md-block"></span>
            </div>
        </div>
    </nav>
    <div class="container">
    <div class="display-2 text-center pt-5 pb-2">Znajomi</div>
        <div class="row">
            <div class="col-12 text-center text-md-left col-md-5">
                    <?php
                    require_once "connect.php";
                    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
                    $id=$_SESSION['ID'];
                    $sql="SELECT * FROM znajomi WHERE ID1='$id' OR ID2='$id'";
                    if($rezultat=@$polaczenie->query($sql))
                    {
                        $liczbauzytkowanikow=$rezultat->num_rows;
                        echo "<div class='d-none display-4 pt-1 d-md-block text-center'>Twoi znajomi</div>";
                        if($liczbauzytkowanikow==0)
                        {
                            echo "<div class='d-none d-md-block py-5' style='font-size:24px;'>Nie masz znajomych, dodaj ich już teraz!</div>";
                        }
                        else{
                            echo "<table class='my-5 offset-2 offset-md-0 offset-xl-2 table table-striped table-hover table-responsive'><tr><th>Nazwa</th><th>Znajomy od</th><th>O znajomym</th></tr>";
                            while($row=mysqli_fetch_assoc($rezultat))
                            {
                                $nazwaznaj=$row['nazwa1'];
                                $idznaj=$row['ID1'];
                                if($nazwaznaj==$_SESSION['nazwa'])
                                {
                                    $nazwaznaj=$row['nazwa2'];
                                    $idznaj=$row['ID2'];
                                }
                                $data_dodania_znaj=$row['data_dodania'];
                                echo "<tr><th>$nazwaznaj</th><td>$data_dodania_znaj</td><td><a href='konto.php?ID=$idznaj'><button class='btn btn-primary'>Zobacz</button></a><td></tr>";
                            }  
                            echo "</table>";
                        }
                    }
                    ?>
                
                    <div class='my-5 display-4 pt-md-1 text-center'>Oczekujące prośby o przyjęcie do znajomych</div>
<!--tutaj pracuje-->
                    <div>
                        <?php
                            $sql="SELECT * FROM zaproszenia WHERE IDzaproszonego='$id'";
                            if($rezultataki=@$polaczenie->query($sql))
                            {
                                $liczbauzytkowanikow=$rezultataki->num_rows;
                                if($liczbauzytkowanikow!=0)
                                {
                                    echo "<table class='my-5 offset-1 offset-md-0 table table-striped table-hover table-responsive'><tr><th>Nazwa</th><th>Data prośby</th><th>O osobie</th><th>Opcja</th><th>Opcja2</th></tr>";
                                    while($rowki=mysqli_fetch_assoc($rezultataki))
                                    {
                                        $nazwaznaj=$rowki['nazwazapraszajacego'];
                                        $idznaj=$rowki['IDzapraszajacego'];
                                        $data_zapki=$rowki['data_zaproszenia'];
                                        echo "<tr><th>$nazwaznaj</th><td>$data_zapki</td><td><a href='konto.php?ID=$idznaj'><button class='btn btn-primary'>Przejdź</button></a></td><td><a href='zaakceptujzapro.php?IDzapro=$idznaj&ktorastronka=1'><button class='btn btn-primary'>Akceptuj</button></a></td><td><a href='nieakceptujzapro.php?IDniezaak=$idznaj'><button class='btn btn-danger'>Odrzuć</button></a></td></tr>";
                                    }  
                                    echo "</table>";
                                }
                                else{
                                    echo "<div class='pt-5 offset-1 text-center col-10' style='font-size:24px;'>Brak oczekujących próśb o dołączenie do znajomych</div>";
                                } 
                            }
                        ?>
                </div>
            </div> <!-- wyswietlenie znajomych-->



            
            <div class="col-12 text-center text-md-left col-md-7">
            <div class='pt-5 display-4 pt-md-1 text-center'>Wyszukaj znajomych</div><table class='my-5 table-striped offset-xl-1 table-hover table table-responsive'><tr><th>Nazwa</th><th>Płeć</th><th>Wiek</th><th>O użytkowniku</th></tr>
                    <?php
                       $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
                       $id=$_SESSION['ID'];
                       $sql="SELECT * FROM uzytkownicy WHERE ID!='$id'";
                       if($rezultat=@$polaczenie->query($sql))
                       {
                            $ilewysznaj=0;
                            while($row=mysqli_fetch_assoc($rezultat))
                            {
                                if($ilewysznaj<40)
                                {
                                    $nazwauzyt=$row['nazwa'];
                                    $plecuzyt=$row['plec'];
                                    $wiekuzyt=$row['wiek'];
                                    $iduzyt=$row['ID'];
                                    $ilewysznaj++;
                                    echo "<tr><th>$nazwauzyt</th><td>$plecuzyt</td><td>$wiekuzyt</td><td><a href='konto.php?ID=$iduzyt'><button class='btn btn-primary'>Zobacz</button></a></td></tr>";
                                }
                            }
                            echo "</table>";
                       }
                    ?>
            </div><!-- wyswietlenie wyszukiwania znajomych-->
        </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>