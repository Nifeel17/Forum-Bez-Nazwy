<?php
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
$id=$_GET['ID'];
require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $sql="SELECT * FROM uzytkownicy WHERE ID='$id'";
    if($rezultat=@$polaczenie->query($sql))
     {
        $wiersz=$rezultat->fetch_assoc();
        $nazwatego=$wiersz['nazwa'];
        $plectego=$wiersz['plec'];
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
                    <a href="<?php if(isset($_SESSION['nazwa'])){ $id=$_SESSION['ID']; echo 'konto.php?ID=',$id; } else{ echo 'zalogujsie.php';} ?>" class="nav-link nav-item active"><?php if(isset($_SESSION['nazwa'])) {echo $_SESSION['nazwa'];}else{echo "Konto";} ?></a>
                    <a href="#" class="nav-link nav-item">Znajomi</a>
                    <a href="#" class="nav-link nav-item">Autor</a>
                </div>
                <span class="navbar-text d-none d-md-block"><?php echo date('d/m'), "/20", date("y"); ?></span>
                <span class="pl-5 navbar-text d-none d-md-block"></span>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row pt-5">
            <div class="col-12 col-lg-5 border text-center">
                <p class="display-4 pt-3"><?php echo $nazwatego; ?></p>
                <p style="font-family:Helvetica; font-size:24px;"><?php echo $plectego; ?></p>
                <p style="font-family:Helvetica; font-size:28px;">Ranga: <?php echo "rangabedzie";?></p>
                <?php?><!-- tutaj bedzie przycisk do dodania znajomego jesli nie jest na liscie, ale dopiero trzeba zrobicx system znajomych-->
            </div>
            <div class="col-12 col-lg-7 border">
            f
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
</body>
</html>