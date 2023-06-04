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


if(isset($_GET['ID'])==false)
{
    header("Location: index.php");
}
$id=$_GET['ID'];
require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $sql="SELECT * FROM uzytkownicy WHERE ID='$id'";
    if($rezultat=@$polaczenie->query($sql))
     {
        $czyistnieje=$rezultat->num_rows;
        if($czyistnieje==0){
            header("Location: index.php");
        }
        else{
            $wiersz=$rezultat->fetch_assoc();
            $nazwatego=$wiersz['nazwa'];
            $plectego=$wiersz['plec'];
            $idtego=$wiersz['ID'];
            $wiektego=$wiersz['wiek'];
            $rangatego=$wiersz['ranga'];
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
    <title>Posty <?php echo $nazwatego; ?></title>
</head>
<?php
    $kolortla="Biały";
    $numerbanneru=1;
    require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
        $sql="SELECT * FROM profil WHERE IDposiadacza='$idtego'";
        if($rezultatwyglada=@$polaczenie->query($sql))
         {
            $liczbauzytkowanikow=$rezultatwyglada->num_rows;
            if($liczbauzytkowanikow>0)
            {
                $wierszki=mysqli_fetch_assoc($rezultatwyglada);
                $kolortla=$wierszki['tlo'];
                $numerbanneru=$wierszki['numerbanneru'];
                if($kolortla=="Czarny")
                {
                    echo "<style> body{background-color: #141414;}</style>";
                }
            }  
         }
    
    
?>
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
    <div class="jumbotron d-none d-lg-block jumbotron-fluid border text-black text-center" style="background-image: url('<?php if($numerbanneru==2){ echo "banner2.png"; } else if($numerbanneru==3){ echo "banner3.png"; } else{ echo "banner1.png";} ?>'); background-size: cover;">
        <div class="container">
            <h3 class="display-3"><?php echo $nazwatego; ?></h3>
            <p style="font-family:Helvetica; font-size:28px;">Ranga: <?php echo $rangatego;?></p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 my-4 text-center">
                <a href="konto.php?ID=<?php echo $idtego; ?>"><button class="btn btn-lg btn-primary">Powrót do strony użytkownika</button></a>
            </div>
            <?php
            require_once "connect.php";
            $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
                $sql="SELECT * FROM posty WHERE IDautora='$idtego' ORDER BY data_dodania DESC";
if($rezultat=@$polaczenie->query($sql))
{
    $ilepostow=$rezultat->num_rows;
    if($ilepostow==0)
    {
        echo "<div class='col-12 mt-3 text-center'><h3>Użytkownik nie posiada postów!<h3></div>";
    }
    while($row=mysqli_fetch_assoc($rezultat))
    {
        $datadodania=$row['data_dodania'];
        $zawartosc=$row['zawartosc'];
        $nazwaposta=$row['nazwaposta'];
        $IDposta=$row['ID'];
        echo "<div class='col-12 col-lg-6'>";
            echo "<div class='card mb-3'>";
                echo "<div class='card-body'>";
                    echo "<h3 class='card-title'>$nazwaposta</h3>";
                    echo "<p>$zawartosc</p>";
                    echo "<p>$datadodania</p>";
                    $sqldolike="SELECT * FROM lajki WHERE ID_posta='$IDposta'";
                    require_once "connect.php";
                    $polaczeniedolike=@new mysqli($host, $db_user, $db_password, $db_name);
                    if($rezultatlike=@$polaczeniedolike->query($sqldolike))
                    {
                        $ilosclajkow=$rezultatlike->num_rows;
                        echo "<p>Polubienia: $ilosclajkow</p>";
                    }
                    echo "<a href='post.php?IDposta=$IDposta' class='btn btn-primary card-link'>Sprawdz</a>";  
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
}

?>



        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>


