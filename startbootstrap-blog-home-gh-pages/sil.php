<?php 
ob_start(); 
include("navbar.php");

include("baglanti.php"); 


include "fonksiyon.php";

// if(session_bilgi()!==true){ header("location: kayıtol.php"); }
  
    $yemekN = $_GET['yemek_numarasi'];
    
    $sorgu= "DELETE FROM `yemeke` WHERE `yemek_numarasi`='$yemekN'";

    $sonuc = mysqli_query($baglanti, $sorgu);

    
    echo '<div class="alert alert-success text-center m-2 p-2">'.'Öğrenci Eklenmiştir. </div>';
    header("location: index.php");
    ob_end_flush();
    




?>

<main>

</main>

