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
    <title>Rejestracja</title>
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
                    <a class="nav-link nav-item">Strona główna</a>
                    <a href="forum.php" class="nav-link nav-item">Forum</a>
                    <a class="nav-link nav-item active">Konto</a>
                    <a href="#" class="nav-link nav-item">Znajomi</a>
                    <a href="#" class="nav-link nav-item">Autor</a>
                </div>
                <span class="navbar-text d-none d-md-block"><?php echo date('d/m'), "/20", date("y"); ?></span>
                <span class="pl-5 navbar-text d-none d-md-block"></span>
            </div>
        </div>
    </nav>


    <div class="container py-5  bg-light">
    <div class="row mt-3 mt-md-2">
        <div class="col-12 col-md-8 offset-md-2 text-center">
            <h1 class="display-4 pb-4">Zarejestruj się</h1>
            <form method="POST" action="rejestracja.php">
                <div class="form-row">
                    <div class="form-group col-10 offset-1 col-md-8 offset-md-2 pb-3">
                        <label for="name">Nazwa użytkownika</label>
                        <input type="text" name="nazwa" id="nazwa" placeholder="Twoja nazwa użytkownika" value="<?php if(isset($_POST['nazwa'])){ echo $_POST['nazwa'];}?>" class="form-control">
                    </div>
                    <div class="form-group col-10 offset-1 col-md-8 offset-md-2 pb-3">
                        <label for="mail">Mail</label>
                        <input type="text" name="mail" id="mail" placeholder="Adres email" value="<?php if(isset($_POST['mail'])){ echo $_POST['mail'];}?>" class="form-control">
                    </div>
                    <div class="form-group col-10 offset-1 col-md-8 offset-md-2 pb-3">
                        <label for="email">Hasło</label>
                        <input type="text" name="haslo" value="<?php if(isset($_POST['haslo'])){ echo $_POST['haslo'];}?>" id="haslo" placeholder="Hasło, które powinieneś znać tylko ty" class="form-control">
                    </div>
                </div>
                <label class="form-check-label col-12 mb-4 mb-md-5">
                        <input type="checkbox" name="zapamietajhaslo" id="zapamietajhaslo" value="1" class="form-check-input">
                        Zapamiętaj mnie
                    </label>
                <button type="submit" class="btn btn-lg btn-primary">Zarejestruj się</button>
            </form>
            <p class="pt-3">Masz już konto? <a href="zalogujsie.php">Zaloguj się!</a></p>
        </div>
    </div>
</div>
<!-- form jeszcze nie skonczyony -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>     
</body>
</html>