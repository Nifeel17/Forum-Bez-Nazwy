<?php
session_start();
if(isset($_SESSION['nazwa']))
{
header("Location: index.php");
}

if(isset($_COOKIE['nazwa'])&&isset($_SESSION['nazwa'])==false){
   header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaloguj się!</title>
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
                    <a class="nav-link nav-item active">Konto</a>
                    <a href="zalogujsie.php" class="nav-link nav-item">Znajomi</a>
                    <a href="autor.php" class="nav-link nav-item">Autor</a>
                </div>
                <span class="navbar-text d-none d-md-block"><?php echo date('d/m'), "/20", date("y"); ?></span>
                <span class="pl-5 navbar-text d-none d-md-block"></span>
            </div>
        </div>
    </nav>

<div class="container py-5  bg-light">
    <div class="row mt-3 mt-md-2">
        <div class="col-12 col-md-8 offset-md-2 text-center">
            <h1 class="display-4 pb-4">Zaloguj się</h1>
            <form method="POST" action="zalogujsie.php">
                <div class="form-row">
                    <div class="form-group col-10 offset-1 col-md-8 offset-md-2 pb-3">
                        <label for="name">Nazwa użytkownika</label>
                        <input type="text" name="nazwa" id="nazwa" placeholder="Twoja nazwa użytkownika" value="<?php if(isset($_POST['nazwa'])){ echo $_POST['nazwa'];}?>" class="form-control">
                    </div>
                    <div class="form-group col-10 offset-1 col-md-8 offset-md-2 pb-3">
                        <label for="email">Hasło</label>
                        <input type="text" name="haslo" value="<?php if(isset($_POST['haslo'])){ echo $_POST['haslo'];}?>" id="haslo" placeholder="Hasło, które powinieneś znać tylko ty" class="form-control">
                    </div>
                </div>
                <label title="Zaznaczając opcję 'zapamiętaj mnie' akceptujesz pliki cookies"  class="form-check-label col-12 mb-4 mb-md-5">
                        <input type="checkbox" name="zapamietajhaslo" id="zapamietajhaslo" value="1" class="form-check-input">
                        Zapamiętaj mnie
                    </label>
                <button type="submit" class="btn btn-lg btn-primary">Zaloguj się</button>
            </form>
            <p class="pt-3">Nie masz jeszcze konta? <a href="rejestracja.php">Zarejestruj się!</a></p>
        </div>
    </div>
</div>
<?php
if(isset($_POST['nazwa']))
{
    $nazwa=$_POST['nazwa'];
    $haslo=$_POST['haslo'];
    require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $sql="SELECT * FROM uzytkownicy WHERE nazwa='$nazwa'";
    if($rezultat=@$polaczenie->query($sql))
     {
        $wiersz=$rezultat->fetch_assoc();
        $liczbauzytkowanikow=$rezultat->num_rows;
        if($liczbauzytkowanikow==0)
        {
            echo "<script>
            document.getElementById('nazwa').classList.remove('is-valid');
            document.getElementById('nazwa').classList.add('is-invalid');
            </script>";
        }
        else if($liczbauzytkowanikow==1)
        {
            echo "<script>
            document.getElementById('nazwa').classList.remove('is-invalid');
            document.getElementById('nazwa').classList.add('is-valid');
            </script>";
            $haslozbazy=$wiersz['haslo'];
            if($haslozbazy==$haslo)
            {
                echo "<script>
                document.getElementById('haslo').classList.remove('is-invalid');
                document.getElementById('haslo').classList.add('is-valid');
                </script>"; 
                if(isset($_POST['zapamietajhaslo'])){
                    $zapamietajhaslo=$_POST['zapamietajhaslo']; 
                    if($zapamietajhaslo==1){
                        $_SESSION['zgodanacookies']=1;
                        setcookie("nazwa","$nazwa",time() + (86400 * 30));
                    }
                }
                $_SESSION['ID']=$wiersz['ID'];
                $_SESSION['haslo']=$wiersz['haslo'];
                $_SESSION['plec']=$wiersz['plec'];
                $_SESSION['mail']=$wiersz['mail'];
                $_SESSION['wiek']=$wiersz['wiek'];
                $_SESSION['data-dolaczenia']=$wiersz['data_dolaczenia'];
                $_SESSION['nazwa']=$nazwa;
                header("Location: index.php");
            }
            else{
                echo "<script>
                document.getElementById('haslo').classList.remove('is-valid');
                document.getElementById('haslo').classList.add('is-invalid');
                </script>"; 
            }
        }
    }
}

?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   

</body>
</html>