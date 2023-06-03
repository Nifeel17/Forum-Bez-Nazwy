<?php //dodac system logownaia z cookies automatyczny
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konto</title>
</head>
<?php
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
        $wiersz=$rezultat->fetch_assoc();
        $nazwatego=$wiersz['nazwa'];
        $plectego=$wiersz['plec'];
        $idtego=$wiersz['ID'];
        $wiektego=$wiersz['wiek'];
        $rangatego=$wiersz['ranga'];
     }
?>
<?php 
$kolortla="Biały";
$numerbanneru=1;
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
                    <a href="<?php if(isset($_SESSION['nazwa'])){ $id=$_SESSION['ID']; echo 'konto.php?ID=',$id; } else{ echo 'zalogujsie.php';} ?>" class="nav-link nav-item <?php if($id==$idtego){ echo "active";} ?>"><?php if(isset($_SESSION['nazwa'])) {echo $_SESSION['nazwa'];}else{echo "Konto";} ?></a>
                    <a href="znajomi.php" class="nav-link nav-item <?php if($id!=$idtego){ echo "active";} ?>">Znajomi</a>
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

    <div class="container pb-5 <?php if($kolortla=="Czarny"){ echo "text-white"; } ?>">
        <div class="row pt-5">
            <div class="col-12 col-lg-5 border text-center pb-3">
                <p class="display-4 pt-3"><?php echo $nazwatego; ?></p>
                <p style="font-family:Helvetica; font-size:24px;">Płeć: <?php echo $plectego; ?></p>
                <p style="font-family:Helvetica; font-size:24px;">Wiek: <?php echo $wiektego; ?></p>
                <p style="font-family:Helvetica; font-size:24px;">Ranga: <?php echo $rangatego; ?></p>
                <a href="postyuzytkownika.php?ID=<?php echo $idtego; ?>"><button class="btn btn-lg mb-2 btn-primary">Posty użytkownika</button></a><br>
                <?php 
                $czyprzyciskwyswietlony=0;
                if(isset($_SESSION['nazwa']))
                {
                    if($nazwatego==$_SESSION['nazwa'])
                    {
                        echo "<a href='edytujprofil.php'><button class='btn btn-lg btn-info'>Edytuj swój profil</button></a>";
                        echo "<br><a href='wylogujsie.php'><button class='btn btn-lg btn-danger mt-3'>Wyloguj sie</button></a>";
                    }
                    else{
                        $sql="SELECT * FROM zaproszenia";
                        if(isset($_SESSION['ID']))
                        {
                            if($rezultaty=@$polaczenie->query($sql))
                            {
                                while($wiersze=mysqli_fetch_assoc($rezultaty))
                                {
                                    $zapraszajacyID=$wiersze['IDzapraszajacego'];
                                    $zaproszonyID=$wiersze['IDzaproszonego'];
                                    if($zaproszonyID==$_SESSION['ID']&&$zapraszajacyID==$idtego)
                                    {
                                        echo"<a href='zaakceptujzapro.php?IDzapro=$idtego'><button class='mb-2 btn btn-primary btn-lg'>Zaakceptuj zaproszenie</button></a>";
                                        $czyprzyciskwyswietlony=1;
                                    }
                                    else if($zapraszajacyID==$_SESSION['ID']&&$zaproszonyID==$idtego)
                                    {
                                        echo "<button class='btn btn-outline-primary btn-lg mb-2' disabled>Wysłano zaproszenie</button><br>";
                                        echo "<a href='anulujzaproszenie.php?IDanulowanego=$idtego'><button class='btn btn-danger btn-lg mb-2'>Anuluj zaproszenie</button></a>";
                                        $czyprzyciskwyswietlony=1;
                                    }
                                }
                            }
                            $sql="SELECT * FROM znajomi";
                            if($czyprzyciskwyswietlony==0)
                            {
                                if($rezultaty2=@$polaczenie->query($sql))
                                {
                                    while($wiersze2=mysqli_fetch_assoc($rezultaty2))
                                    {
                                        $ID1=$wiersze2['ID1'];
                                        $ID2=$wiersze2['ID2'];
                                        if( ($ID1==$idtego && $ID2==$_SESSION['ID']) || ($ID1==$_SESSION['ID'] && $idtego==$ID2))
                                        {
                                            if($czyprzyciskwyswietlony==0)
                                            {
                                                echo "<a href='usunznajomego.php?IDznajdousuniecia=$idtego'><button class='btn btn-danger btn-lg mb-2'>Usuń znajomego</button></a>";
                                            }
                                            $czyprzyciskwyswietlony=1;
                                        }
                                    }
                                }
                            }
                            $twojekurdeid=$_SESSION['ID'];
                            if($czyprzyciskwyswietlony==0 && $idtego!=$twojekurdeid)
                            {
                                echo "<a href='dodajznajomego.php?IDznajdododania=$idtego'><button class='btn btn-primary btn-lg mb-2'>Dodaj do znajomych</button></a>";
                                        $czyprzyciskwyswietlony=1;
                            }
                        }
                    }
                }
                ?>

                
            </div>




            <div class="col-12 mt-4 col-lg-7 mt-lg-0 border">
                <div class='pt-5 display-4 pt-md-1 text-center'>Znajomi użytkownika <?php echo $nazwatego; ?></div>
                        <?php
                        $sql="SELECT * FROM znajomi WHERE ID1='$idtego' OR ID2='$idtego'";
                        if($rezultataki=@$polaczenie->query($sql))
                    {
                        $liczbauzytkowanikow=$rezultataki->num_rows;
                        if($liczbauzytkowanikow!=0)
                        {
                            echo "<table class='my-5 offset-2 offset-md-0 offset-xl-2 table table-striped table-hover table-responsive'><tr><th>Nazwa</th><th>Znajomy od</th><th>O znajomym</th></tr>";
                            while($rowki=mysqli_fetch_assoc($rezultataki))
                            {
                                $nazwaznaj=$rowki['nazwa1'];
                                $idznaj=$rowki['ID1'];
                                if($nazwaznaj==$nazwatego)
                                {
                                    $nazwaznaj=$rowki['nazwa2'];
                                    $idznaj=$rowki['ID2'];
                                }
                                $data_dodania_znaj=$rowki['data_dodania'];
                                echo "<tr><th>$nazwaznaj</th><td>$data_dodania_znaj</td><td><a href='konto.php?ID=$idznaj'><button class='btn btn-primary'>Zobacz</button></a><td></tr>";
                            }  
                            echo "</table>";
                        }
                        else{
                            echo "<div class='pt-5 offset-1 text-center col-10' style='font-size:24px;'>Użytkownik nie posiada żadnych znajomych. Możesz zostać tym pierwszym!</div>";
                       } 
                    }
                              
                        ?>
                </div>
            </div> 
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>