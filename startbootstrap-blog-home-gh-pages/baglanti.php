
<?php
    $DB_SERVER = "localhost";
    $DB_USERNAME = "root";
    $DB_PASSWORD ="";
    $DB_NAME ='final';

    $baglanti=mysqli_connect($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB_NAME);

    mysqli_set_charset($baglanti,"utf8");

    if(!$baglanti){
        die("Veritabanı Bağlantı Hasası : ". mysqli_connect_errno());
    }
?>
