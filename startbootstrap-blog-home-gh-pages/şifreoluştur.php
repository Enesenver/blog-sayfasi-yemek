<?php
    session_start();
    include "baglanti.php";
   

    if($_SERVER["REQUEST_METHOD"] == "GET"){

        $_SESSION["kod"]=$_GET["kod"];
    }

    $kod=$_SESSION["kod"];


    $sonuc1 = mysqli_query($baglanti, "SELECT * FROM `kullanicii` WHERE `sifirlamakodu`='$kod'");
                     
    if(mysqli_num_rows($sonuc1) == 0){
        header("refresh:5 ; url=sifremiU.php"); 
        echo '<div class="alert alert-danger text-center">'."<strong>Şifre değiştirme linki geçersiz.</strong> Şifremi Unuttum Sayfasına Yönlendiriliyorsunuz...".'</div>';
        
    }
  

    $sifre = $sifre_onay = "";
    $sifre_hata = $sifre_onay_hata = "";
 
    if($_SERVER["REQUEST_METHOD"] == "POST"){


        // Şifre Kontrolü
        if(empty(trim($_POST["sifre"]))) {
            $sifre_hata = "Lütfen şifre giriniz.";
        } elseif (strlen($_POST["sifre"]) < 6) {
            $sifre_hata = "Şifre en az 6 karakter olmalıdır.";
        } else {
            $sifre = trim($_POST["sifre"]);
        }
        // Şifre Onay Kontrolü
        if(empty(trim($_POST["sifre_onay"]))) {
            $sifre_onay_hata = "Şifrenizi tekrar girmelisiniz.";
        } else {
            $sifre_onay = $_POST["sifre_onay"];
                if(empty($sifre_hata) and ($sifre != $sifre_onay)) {
                    $sifre_onay_hata = "Şifreler eşleşmiyor. Lütfen kontrol ediniz.";
                }
        }

        
        if(empty($sifre_hata) && empty($sifre_onay_hata)) {
            $sifre = password_hash($sifre, PASSWORD_DEFAULT);
            $sorgu= "UPDATE `kullanicii` SET `sifre`='$sifre' WHERE `sifirlamakodu`='$kod'";
   

            $sonuc = mysqli_query($baglanti, $sorgu);

            mysqli_close($baglan);
            
            if($sonuc) {
                header("refresh:5 ; url=giris.php"); 
                echo '<div class="alert alert-success text-center">'."<strong>Şifreniz Değiştirilmiştir.</strong> Giriş Sayfasına Yönlendiriliyorsunuz...".'</div>';

            }


           
        
        }





    
    }
?>

<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Yeni Şifre Oluştur</title>
        <link href="lib/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">


<div class="card-header mt-2"><h3 class="text-center font-weight-light my-3">Yeni Şifre Oluştur</h3></div>
    <div class="card-body">
        
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" novalidate>

<div class="row mb-3"><div class="col-md-6"><div class="form-floating mb-3 mb-md-0">
<!-- Şifre Kısmı -->
     
        <input class="form-control <?php echo (!empty($sifre_hata)) ? 'is-invalid': ''?>" id="sifre" name="sifre" type="password" placeholder="Şifre oluştur" />
        <label for="sifre">Şifre</label>
        <span class="invalid-feedback"><?php echo $sifre_hata; ?></span>

    </div></div><div class="col-md-6"><div class="form-floating mb-3 mb-md-0">
<!-- Şifre Kontrol Kısmı -->

        <input class="form-control <?php echo (!empty($sifre_onay_hata)) ? 'is-invalid': ''?>" id="sifre_onay" name="sifre_onay" type="password" placeholder="Şifre Onay">
        <label for="sifre_onay">Şifre Onay</label>
        <span class="invalid-feedback"><?php echo $sifre_onay_hata; ?></span>

    </div></div></div><div class="mt-4 mb-0">
<!-- Gönder Butonu Kısmı -->

<div class="d-grid"><input type="submit" name="sifreolustur" value="Şifre Oluştur" class="btn btn-primary"></div>
            
    </div></form></div>
            
        </div>   </div>   </div>    </div>
        </main>
        
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-3">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="lib/js/scripts.js"></script>
    </body>
</html>