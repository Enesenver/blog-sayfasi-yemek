<?php

function session_bilgi(){
    if (isset($_SESSION["giris_bilgisi"]) && $_SESSION["giris_bilgisi"]){
        return true;
    } else {
        return false;
    }
}

function bilgi_getir($id){

    include "baglanti.php";

    $sorgu = "SELECT * FROM `kullanicii` WHERE `id`='$id'";

    $sonuc = mysqli_query($baglanti, $sorgu);

    mysqli_close($baglanti);

    return $sonuc;
}

function bilgi_guncelle($id, $ad, $soyad, $email, $adres, $ilce, $il) {
    include "baglanti.php";
    $sorgu = "UPDATE `kullanicii` SET `adi`='$ad', `soyadi`='$soyad', `eposta`='$email', `adres`='$adres', `ilce`='$ilce', `il`='$il' WHERE `id`='$id'";
    $sonuc = mysqli_query($baglanti, $sorgu);
    mysqli_close($baglanti);
    return $sonuc;
}


function kullaniciadi_kontrol($kullaniciadi){

    include("baglanti.php");

    $kullaniciadi_hata = "";

    if(empty(trim($kullaniciadi))){
        $kullaniciadi_hata = "Lütfen kullanıcı adı giriniz.";
        
    } elseif (strlen(trim($kullaniciadi)) < 4 || strlen(trim($kullaniciadi)) > 12){
        $kullaniciadi_hata = "Kullanıcı adı 4-12 karakter arasında olmalıdır.";
        
    } elseif(!preg_match('/^[a-z\d_]+$/i', trim($kullaniciadi))){
        $kullaniciadi_hata = "Kullanıcı adı sadece harf, sayı ve alt çizgi içerebilir, boşluk içermemelidir.";
        
    } else {
        $sorgu = "SELECT `kullaniciadi` FROM `kullanicii` WHERE kullaniciadi= ?";
            
        if($stmt = mysqli_prepare($baglanti, $sorgu)){
                
            $kullaniciadi = trim($kullaniciadi);

            mysqli_stmt_bind_param($stmt, "s", $kullaniciadi);
                
            if(mysqli_stmt_execute($stmt)){
                    
                mysqli_stmt_store_result($stmt);
                    
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $kullaniciadi_hata = "Bu kullanıcı adı önceden alınmış.";
                } else{
                        $kullaniciadi = trim($kullaniciadi);
                    }
            } else{
                echo "Hata! Bir şeyler ters gitti. Lütfen daha sonra tekrar deneyiniz.";
            }
            
            mysqli_stmt_close($stmt);
        }
    }

    return $kullaniciadi_hata;
}

function kullaniciadi_guncelle($id, $kullaniciadi){
    include("baglanti.php");

    $sorgu = "UPDATE `kullanicii` SET `kullaniciadi`='$kullaniciadi' WHERE `id`='$id'";

    $sonuc = mysqli_query($baglanti, $sorgu);
    
    mysqli_close($baglanti);

    return $sonuc;
}

function sifre_guncelle($id, $yeni_sifre){

    include("baglanti.php");

    $yeni_gizli_sifre = password_hash($yeni_sifre, PASSWORD_DEFAULT);

    $sorgu = "UPDATE `kullanicii` SET `sifre`='$yeni_gizli_sifre' WHERE `id`='$id'";

    $sonuc = mysqli_query($baglanti, $sorgu);
    
    mysqli_close($baglanti);

    return $sonuc;
}

function avatar_yukle($foto, $id){

    $dosyatempadi = $_FILES["foto"]["name"];
    $dosya_tipi = strtolower(pathinfo($dosyatempadi, PATHINFO_EXTENSION));
    
    if($dosya_tipi != "jpg" && $dosya_tipi != "png" && $dosya_tipi != "jpeg" && $dosya_tipi != "gif") {
        echo '<div class="alert alert-danger text-center">'."Üzgünüz, yalnızca JPG, JPEG, PNG ve GIF dosyalarına izin verilmektedir.".'</div>';
    } else {
        echo '<div class="alert alert-success text-center">'."Yükleme başarılı...".'</div>';
        $dosyaadi = $id.".jpg";
        $dosyatempadi = $_FILES["foto"]["tmp_name"];
        $yol = "img/avatars/";
        move_uploaded_file($dosyatempadi, $yol.$dosyaadi);
    }
}

?>
