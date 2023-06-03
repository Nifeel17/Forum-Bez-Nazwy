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
$sortuj=1;
if(isset($_GET['sortowanie']))
{
    $sortuj=$_GET['sortowanie'];
    if($sortuj!=1 && $sortuj!=2)
    {
        $sortuj=1; 
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
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
            <p class="lead"><?php if(isset($_SESSION['nazwa'])==false){echo"Aby móc komentować lub polubić musisz się zalogować";}else{ echo "Baw się, śmiej i ciesz!";} ?></p>
            <a href="<?php if(isset($_SESSION['nazwa'])==false){ echo"zalogujsie.php";}else{ echo "dodajswojpost.php"; } ?>">
                <button class='btn btn-info btn-lg'><?php if(isset($_SESSION['nazwa'])==false){ echo"Zaloguj się!"; }else{ echo"Dodaj swój post!"; } ?></button>
            </a>
        </div>
    </div>


    <div class="container mb-3 t-5">
        <nav>
            <ul class="pagination pagination-lg">
                <li class="page-item" id="Odnajnowszych"><a class="page-link" href="forum.php?sortowanie=1">Od najnowszych</a></li>
                <li class="page-item" id="Odnajstarszych"><a class="page-link" href="forum.php?sortowanie=2">Od najstarszych</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <div class="row">
            <?php 
                require_once "connect.php";
                $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
                if($sortuj==2)
                {
                    $sql="SELECT * FROM posty ORDER BY data_dodania ASC";
                }
                else
                {
                    $sql="SELECT * FROM posty ORDER BY data_dodania DESC";
                }
                if($rezultat=@$polaczenie->query($sql))
                {
                    while($row=mysqli_fetch_assoc($rezultat))
                    {
                        $nazwaautora=$row['Nazwaautora'];
                        $idautora=$row['IDautora'];
                        $datadodania=$row['data_dodania'];
                        $zawartosc=$row['zawartosc'];
                        $nazwaposta=$row['nazwaposta'];
                        $IDposta=$row['ID'];
                        echo "<div class='col-12 col-lg-6'>";
                            echo "<div class='card mb-3'>";
                                if(isset($_SESSION['ID'])){
                                    $twojeidhihi=$_SESSION['ID'];
                                    $sql2="SELECT * FROM znajomi WHERE (ID1='$idautora' OR ID2='$idautora') AND (ID1='$twojeidhihi' OR ID2='$twojeidhihi')";
                                    if($rezultat2=@$polaczenie->query($sql2))
                                    {
                                        $liczbauzytkowanikow=$rezultat2->num_rows;
                                        if($liczbauzytkowanikow>0&&$nazwaautora!=$_SESSION['nazwa'])
                                        {
                                            echo "<div class='card-header bg-success'>Post znajomego</div>";
                                        }
                                    }
                                    if($nazwaautora==$_SESSION['nazwa'])
                                    {
                                        echo "<div class='card-header bg-warning'>Twój post</div>";
                                    }
                                }
                                echo "<div class='card-body'>";
                                    echo "<h3 class='card-title'>$nazwaposta</h3>";
                                    echo "<h4 class='card-subtitle'>$nazwaautora</h4>";
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
<?php
if($sortuj==2){
    echo "<script>document.getElementById('Odnajstarszych').classList.add('active');</script>";
}
else{
    echo "<script>document.getElementById('Odnajnowszych').classList.add('active');</script>";
}

?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>
