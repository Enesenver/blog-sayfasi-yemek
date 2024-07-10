<?php
// Bağlantı dosyasını ekleyin
include "baglanti.php";

// Eğer yemek numarası varsa
if (isset($_GET['yemek_numarasi'])) {
    $yemekN = $_GET['yemek_numarasi'];

    // Yemek bilgilerini çek
    $sorgu = "SELECT * FROM yemeke WHERE yemek_numarasi = '$yemekN'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    if (!$sonuc) {
        die("Sorgu hatası: " . mysqli_error($baglanti));
    }

    $yemeke = mysqli_fetch_assoc($sonuc);

    // Form post edildiyse
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Formdan gelen verileri al
        $adsoyad = mysqli_real_escape_string($baglanti, $_POST['adsoyad']);
        $tarifi = mysqli_real_escape_string($baglanti, $_POST['tarifi']);
        $kactl = mysqli_real_escape_string($baglanti, $_POST['kactl']);

        // Yemek bilgilerini güncelle
        $guncelleme_sorgu = "UPDATE yemeke SET ad_soyad = '$adsoyad', tarifi = '$tarifi', kac_tl = '$kactl' WHERE yemek_numarasi = '$yemekN'";

        if (mysqli_query($baglanti, $guncelleme_sorgu)) {
            echo "Yemek bilgileri güncellendi.";
        } else {
            echo "Hata: " . mysqli_error($baglanti);
        }
    }
} else {
    echo "Hata: Yemek numarası belirtilmemiş.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Blog</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<main>

<button class="btn btn-outline-primary m-2" onclick="history.back()">Geri Dön</button>

<hr class="bg-primary">

<form action="" method="POST" novalidate> 

<div class="row justify-content-center align-items-center g-2 m-2">
    <div class="col">
        <div class="d-flex justify-content-center mb-4">
            <img src="https://mdbootstrap.com/img/Photos/Others/placeholder-avatar.jpg"
            class="rounded-circle" alt="<?php echo isset($yemeke['ad_soyad']) ? $yemeke['ad_soyad'] : ''; ?>"  width="128" height="128"/>
        </div>
    </div>
    <div class="col">
        <div class="m-3">
            <label for="onumarasi" class="form-label">Yemek Numarası</label>
            <input class="form-control" id="yemekN" type="text" name="yemek_numarasi" value="<?php echo isset($yemeke['yemek_numarasi']) ? $yemeke['yemek_numarasi'] : ''; ?>">
        </div>
    </div>
    <div class="col">
        <div class="m-3">
            <label for="oadsoyad" class="form-label">Ad-Soyad</label>
            <input class="form-control" id="adsoyad" type="text" name="adsoyad" value="<?php echo isset($yemeke['ad_soyad']) ? $yemeke['ad_soyad'] : ''; ?>">
        </div>
    </div>
</div>

<div class="row justify-content-center align-items-center g-2 m-2">
    <div class="col">
        <div class="m-3">
            <label for="obolumu" class="form-label">Tarif</label>
            <input class="form-control" id="tarifi" type="text" name="tarifi" value="<?php echo isset($yemeke['tarifi']) ? $yemeke['tarifi'] : ''; ?>">
        </div>
    </div>
    <div class="col">
        <div class="m-3">
            <label for="odonemi" class="form-label">Kaç TL</label>
            <input class="form-control" id="kactl" type="text" name="kactl" value="<?php echo isset($yemeke['kac_tl']) ? $yemeke['kac_tl'] : ''; ?>">
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary m-2">Değişiklikleri Kaydet</button>
</form>

</main>

</body>
</html>
