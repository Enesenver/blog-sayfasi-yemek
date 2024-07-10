<?php 
ob_start();

include "navbar.php"; 	
include "fonksiyon.php";

$kullaniciadi = $ad = $soyad = $id = $email = $sifre = $eski_sifre = $yeni_sifre = $sifre_onay = $yeni_sifre_onay= "";
$kullaniciadi_hata = $email_hata = $sifre_hata = $eski_sifre_hata = $yeni_sifre_hata = $sifre_onay_hata = $yeni_sifre_onay_hata = "";

if(session_bilgi() == true){
    $kullaniciadi = $_SESSION["kullaniciadi_bilgisi"];
    $id = $_SESSION["id_bilgisi"];
    $sonuc = bilgi_getir($id);

    if ($sonuc) {
        $row = mysqli_fetch_assoc($sonuc);
        $id = $row["id"];
        $kullaniciadi_veritabani = $row["kullaniciadi"];
        $ad = $row["adi"];
        $soyad = $row["soyadi"];
        $email = $row["eposta"];
        $adres = $row["adres"];
        $ilce = $row["ilce"];
        $il = $row["il"];
    } else {
        echo '<div class="alert alert-danger text-center m-2 p-2">Kullanıcı bilgileri alınamadı. Lütfen tekrar deneyin.</div>';
    }
}

if(!empty($_POST["kullaniciadi"])){
    $kullaniciadi = $_POST["kullaniciadi"];
    
    if($kullaniciadi == $kullaniciadi_veritabani){
        $kullaniciadi_hata = "";
    } else {
        $kullaniciadi_hata = kullaniciadi_kontrol($kullaniciadi);

        if (empty($kullaniciadi_hata)){
            kullaniciadi_guncelle($id, $kullaniciadi); // $id parametresi eklenmeli
            echo '<div class="alert alert-success text-center m-2 p-2">'.'Kullanıcı adınız <strong>'.$kullaniciadi. '</strong> olarak değiştirilmiştir.</div>';
        }
    }
}

if(!empty($_POST["foto_yukle"])){
    avatar_yukle($_FILES["foto"], $id);
}

if(isset($_POST["sifre_degistir"])){
    $eski_sifre = $_POST["eski_sifre"];
    $gizli_sifre = $row["sifre"];
    
    if(empty($eski_sifre)){
        $eski_sifre_hata = "Mevcut şifrenizi girmediniz.";
    } else {
        if(!password_verify($eski_sifre, $gizli_sifre)) {
            $eski_sifre_hata = "Mevcut şifrenizi yanlış girdiniz.";
        }
    }

    $yeni_sifre = $_POST["yeni_sifre"];
    if(empty($yeni_sifre)){
        $yeni_sifre_hata = "Lütfen yeni şifrenizi giriniz.";
    } else {
        if (strlen($yeni_sifre) < 6) {
            $yeni_sifre_hata = "Yeni Şifre en az 6 karakter olmalıdır.";
        }
    }

    $yeni_sifre_onay = $_POST["yeni_sifre_onay"];
    if(empty($yeni_sifre_onay)){
        $yeni_sifre_onay_hata = "Lütfen yeni şifrenizi tekrar giriniz.";
    } else {
        if(empty($yeni_sifre_hata) && ($yeni_sifre != $yeni_sifre_onay)) {
            $yeni_sifre_onay_hata = "Şifreler eşleşmiyor. Lütfen kontrol ediniz.";
        }
    }

    if (!empty($yeni_sifre) && empty($yeni_sifre_hata) && empty($eski_sifre_hata) && !empty($yeni_sifre_onay) && empty($yeni_sifre_onay_hata)){
        sifre_guncelle($id, $yeni_sifre);
        echo '<div class="alert alert-success text-center m-2 p-2">Şifreniz güncellenmiştir.</div>';
    }
}

if(isset($_POST["kayit"])){
    bilgi_guncelle($id, $_POST["ad"], $_POST["soyad"], $_POST["email"], $_POST["adres"], $_POST["ilce"], $_POST["il"]);
    echo '<div class="alert alert-success text-center m-2 p-2">'.'Bilgileriniz güncellenmiştir. </div>';
}
?>












<!-- Blank Start -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<div class="container-fluid pt-4 px-4">

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" novalidate enctype="multipart/form-data"> 

    <div class="row justify-content-center align-items-center g-2">
        <div class="col-12 col-md-4">
        <div class="col-md-4">
		
                        <?php

                $img="img/avatars/".$id.".jpg";
                if(empty(file_exists($img))){
                $GLOBALS['img']="https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg";}            
                ?>


		<div class="d-flex justify-content-center mb-4">
			<img src="<?php echo $img;?>"
			class="rounded-circle" alt="<?php echo $kullaniciadi;?>"  width="128" height="128"/>
		</div>
		<div class="d-flex justify-content-center">
			<div class="btn btn-primary btn-rounded m-1">
				<label class="form-label text-white m-1" for="foto">Foto Seç</label>
				<input type="file" class="form-control d-none" id="foto" name="foto"/>
			</div>
		
			<div class="btn btn-danger btn-rounded m-1">
				<label class="form-label text-white m-1" for="foto_yukle">Foto Yükle</label>
				<input type="submit" class="form-control d-none" id="foto_yukle" name="foto_yukle"/>
			</div>
		</div>


		<!-- <div class="text-center">
			<img alt="<?php echo $kullaniciadi;?>" src="img/avatars/<?php $kullaniciadi;?>.jpg" class="rounded-circle img-responsive mt-2" width="128" height="128"/>
			<div class="mt-2">
				<span class="btn btn-primary" name="yukle"><i class="fas fa-upload"></i> Yükle</span>
			</div>
			<small>En az 128px X 128px boyutlarında ve .jpg formatında  bir görsel kullanın.</small>
		</div> -->


	</div>
        </div>
        <div class="col-12 col-md-8">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-12 col-md-6">
            <div class="mb-3">
			<label for="kullaniciadi" class="form-label">Kullanıcı Adı</label>
			<input class="form-control <?php echo (!empty($kullaniciadi_hata)) ? 'is-invalid': ''?>" id="kullaniciadi" type="text" name="kullaniciadi" placeholder="Kullanıcı Adı" value="<?php echo $kullaniciadi; ?>">
			<span class="invalid-feedback"><?php echo $kullaniciadi_hata; ?></span>
		</div>
            </div>
            <div class="col-12 col-md-6">
            <div class="mb-3">
			<label for="email" class="form-label">Email</label>
			<input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email; ?>">
		</div>
            </div>
            <div class="col-12 col-md-6">
            <div class="mb-3">
			<label for="ad" class="form-label">Ad</label>
			<input type="text" class="form-control" id="ad" placeholder="Ad" name="ad" value="<?php echo $ad; ?>">
		</div>
            </div>
            <div class="col-12 col-md-6">
            <div class="mb-3">
			<label for="soyad" class="form-label">Soyad</label>
			<input type="text" class="form-control" id="soyad" name="soyad" placeholder="Soyad" value="<?php echo $soyad; ?>">
		    </div>
            </div>

        </div>
                    




        </div>
    </div>
    
	<div class="row">
		<div class="mb-3 col-md-8">
		<div class="mb-3">
		<label for="adres" class="form-label">Adres</label>
		<input type="text" class="form-control" id="adres" name="adres" value="<?php echo $adres; ?>" placeholder="Adres">
		</div></div>
	
		<div class="mb-3 col-md-2">
			<label for="ilce" class="form-label">İlçe</label>
			<input type="text" class="form-control" id="ilce" name="ilce" placeholder="İlçe" value="<?php echo $ilce; ?>">
		</div>
		<div class="mb-3 col-md-2">
			<label for="il" class="form-label">İl</label>
			<input type="text" class="form-control" id="il"  name="il" value="<?php echo $il; ?>" placeholder="İl">
		</div>
				
	</div>
	


			<button type="submit" class="btn btn-primary" name="kayit">Değişikleri Kaydet</button>
</form>


			<br><br><br>


<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" novalidate>				
				<div class="mb-3">
				<label for="eski_sifre" class="form-label">Mevcut Şifreniz</label>
				<input class="form-control <?php echo (!empty($eski_sifre_hata)) ? 'is-invalid': ''?>" id="eski_sifre" name="eski_sifre" value="<?php echo $eski_sifre; ?>" type="password" placeholder="Mevcut Şifre">
				<span class="invalid-feedback"><?php echo $eski_sifre_hata; ?></span>
				<small><a href="şifremiU.php">Şifremi Unuttum</a></small>				
				</div>
				
				<div class="mb-3">
					<label for="yeni_sifre" class="form-label">Yeni Şifre</label>
					<input class="form-control <?php echo (!empty($yeni_sifre_hata)) ? 'is-invalid': ''?>"               value="<?php echo $yeni_sifre; ?>" id="yeni_sifre" name="yeni_sifre" type="password" placeholder="Yeni Şifrenizi Giriniz">
					<span class="invalid-feedback"><?php echo $yeni_sifre_hata; ?></span>
				</div>
				<div class="mb-3">
					<label for="yeni_sifre_onay" class="form-label">Yeni Şifre Onay</label>
					<input class="form-control <?php echo (!empty($yeni_sifre_onay_hata)) ? 'is-invalid': ''?>" value="<?php echo $yeni_sifre_onay; ?>" id="yeni_sifre_onay" name="yeni_sifre_onay" type="password" placeholder="Yeni Şifre Onay">
					<span class="invalid-feedback"><?php echo $yeni_sifre_onay_hata; ?></span>
				</div>		
				
				<button type="submit" class="btn btn-primary" name="sifre_degistir">Değişikleri Kaydet</button>
											</form>









</div>
<!-- Blank End -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
  
    <script src="js/scripts.js"></script>

