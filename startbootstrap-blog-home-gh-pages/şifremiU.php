<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    include "baglanti.php";

    
    $email = $email_hata = "";
 
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        
       
        if(empty(trim($_POST["email"]))) {
            $email_hata = "Lütfen email giriniz.";
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email_hata = "Hatalı email adresi girdiniz.";
        } else {
            $email=$_POST["email"];

            $sorgu= "SELECT * FROM `kullanicii` WHERE `eposta`='$email'";

            $sonuc = mysqli_query($baglanti, $sorgu);
                             
            if(mysqli_num_rows($sonuc) == 0){
                $email_hata = "Bu kullanıcı adı kayıtlı değil. Lütfen e-posta adresinizi kontrol ediniz.";
            } else{
                       

            $kullanici = mysqli_fetch_assoc($sonuc);

            $kemail=$kullanici["eposta"];          
            $kadi=$kullanici["kullaniciadi"];

    
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'eekinci871@gmail.com';
        $mail->Password = 'nfkg cllb npao jzdh';
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587; 
        $mail->CharSet  ="UTF-8";
        $mail->SMTPDebug = 0; 

        $mail->setFrom("eekinci871@gmail.com", "eekinci871@gmail.com");
        $mail->addAddress($kemail, $kadi);
    
        $mail->Subject = 'Şifremi Unuttum';

        
        $sifirlamakodu=sha1(time());


        mysqli_query($baglanti, "UPDATE `kullanici_bilgileri` SET `sifirlamakodu`='$sifirlamakodu' WHERE `eposta`='$email'");
        
        $sifirlamalinki="http://localhost/startbootstrap-blog-home-gh-pages/%C5%9Fifreolu%C5%9Ftur.php?kod=".$sifirlamakodu;

        $mail->Body =$sifirlamalinki;
    
        $mail->send();

        



         if(empty($email_hata)) { echo '<div class="alert alert-success text-center">'."Yeni Şifre için E-posta Gönderilmiştir.".'</div>';}

        

  
    }
    }
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    
    <link href="img/favicon.ico" rel="icon">


 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    
    <link href="lib/css_js/bootstrap.min.css" rel="stylesheet">

   
    <link href="lib/css_js/style.css" rel="stylesheet">
</head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">


<div class="card-header mt-2"><h3 class="text-center font-weight-light my-3">Şifremi Unuttum</h3></div>
    <div class="card-body">
        
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" novalidate>

    <div class="row mb-3"><div class="col"><div class="form-floating mb-3">


    <input class="form-control <?php echo (!empty($email_hata)) ? 'is-invalid': ''?>" value="<?php echo $email; ?>" id="email" type="email" name="email" placeholder="Email adresi giriniz"  >
        <label for="email">E-posta Adresinizi Giriniz</label>
        <span class="invalid-feedback"><?php echo $email_hata; ?></span>

    </div><div class="mt-4 mb-0">


<div class="d-grid"><input type="submit" name="epostagonder" value="E-posta Gönder" class="btn btn-primary"></div>
            
    </div></form>
</div>   </div>   </div>   </div>    </div>
        </main>
        
            </div>
  
        </div>
  
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="lib/css_js/main.js"></script>
    </body>
</html>











