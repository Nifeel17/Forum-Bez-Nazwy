
<?php
session_start();
if(isset($_SESSION['nazwa'])||isset($_COOKIE['nazwa'])){
    header("Location: index.php");
}
    $nazwa=$_POST['nazwa'];
    $haslo=$_POST['haslo'];
    $plec=$_POST['plec'];
    $mail=$_POST['mail'];
    $wiek=$_POST['wiek'];
    $_SESSION['hasloztextarea']=$haslo;
    $_SESSION['mailztextarea']=$mail;
    $_SESSION['nazwaztextarea']=$nazwa;
    $_SESSION['wiekztextarea']=$wiek;
    $_SESSION['nazwajestzajeta']=0;
    $_SESSION['nieodpowideniwiek']=0;
    $_SESSION['haslozakrotkie']=0;
    require_once "connect.php";
    $polaczenie=@new mysqli($host, $db_user, $db_password, $db_name);
    $sql="SELECT * FROM uzytkownicy WHERE nazwa='$nazwa'";
    if($rezultat=@$polaczenie->query($sql))
    {
        $dlugoschaslo=strlen($haslo);
        echo $dlugoschaslo;
        $liczbauzytkowanikow=$rezultat->num_rows;
        if($liczbauzytkowanikow!=0)
        {
            $_SESSION['nazwajestzajeta']=1;
        }
        if($dlugoschaslo<5)
        {
            $_SESSION['haslozakrotkie']=1;
        }
        if($wiek<10||$wiek>100)
        {
            $_SESSION['nieodpowideniwiek']=1;
        }
        if($_SESSION['nieodpowideniwiek']==1 || $_SESSION['haslozakrotkie']==1 || $_SESSION['nazwajestzajeta']==1)
        {
            header("Location: rejestracja.php");
        }
        else
        {
            $data=date("y-m-d");
            if($polaczenie->query("INSERT INTO uzytkownicy VALUES(default,'$nazwa','$haslo','$data','$plec','$mail','$wiek', 'Początkujący')"))
            {
                $_SESSION['haslo']=$haslo;
                $_SESSION['plec']=$plec;
                $_SESSION['mail']=$mail;
                $_SESSION['wiek']=$wiek;
                $_SESSION['data-dolaczenia']=$data;
                $_SESSION['nazwa']=$nazwa;
                if(isset($_POST['zapamietajhaslo'])){
                    $zapamietajhaslo=$_POST['zapamietajhaslo']; 
                    if($zapamietajhaslo==1){
                        $_SESSION['zgodanacookies']=1;
                        setcookie("nazwa","$nazwa",time() + (86400 * 30));
                    }
                }
                header("Location: index.php");
            }
        }
    }

?>