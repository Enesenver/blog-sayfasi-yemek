<?php
ob_start();
include "baglanti.php";
include "navbar.php";

if (isset($_POST["yemekEkle"])) {
    
    $yemekN = mysqli_real_escape_string($baglanti, $_POST["yemekN"]);
    $adsoyad = mysqli_real_escape_string($baglanti, $_POST["adsoyad"]);
    $yemekA = mysqli_real_escape_string($baglanti, $_POST["yemekA"]);
    $tarifi = mysqli_real_escape_string($baglanti, $_POST["tarifi"]);
    $kactl = mysqli_real_escape_string($baglanti, $_POST["kactl"]);

    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Dosya bir resim değil.";
        $uploadOk = 0;
    }


    
    if ($_FILES["image"]["size"] > 500000) {
        echo "Üzgünüz, dosya boyutu çok büyük.";
        $uploadOk = 0;
    }

    
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Üzgünüz, sadece JPG, JPEG, PNG & GIF dosyaları kabul edilmektedir.";
        $uploadOk = 0;
    }

    
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Dosya ". htmlspecialchars(basename($_FILES["image"]["name"])). " yüklendi.";

            
            $sorgu = "INSERT INTO `yemeke` (`id`, `resim`, `yemek_numarasi`, `ad_soyad`, `yemek_adi`, `tarifi`, `kac_tl`) 
                      VALUES (NULL, '$target_file', '$yemekN', '$adsoyad', '$yemekA', '$tarifi', '$kactl')";
            
            $sonuc = mysqli_query($baglanti, $sorgu);

            if($sonuc){
                echo "Veri başarıyla kaydedildi.";
            } else {
                echo "Veritabanına ekleme sırasında hata oluştu: " . mysqli_error($baglanti);
            }

            mysqli_close($baglanti);

            ob_end_flush();
            header("location: yemekEkle.php");
        } else {
            echo "Üzgünüz, dosya yüklenirken bir hata oluştu.";
        }
    }
}
?>

<main>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <button class="btn btn-outline-primary m-2" onclick="history.back()">Geri Dön</button>
    <hr class="bg-primary">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <div class="row justify-content-center align-items-center g-2 m-2">
            <div class="col">
                <div class="d-flex justify-content-center mb-4">
                    <label for="image">Fotoğraf Seç:</label>
                    <input type="file" name="image" id="image" required>
                </div>
            </div>
            <div class="col">
                <div class="m-3">
                    <label for="yemekN" class="form-label">Yemek Numarası</label>
                    <input class="form-control" id="yemekN" type="text" name="yemekN" value="123" required>
                </div>
            </div>
            <div class="col">
                <div class="m-3">
                    <label for="adsoyad" class="form-label">Ad Soyad</label>
                    <input class="form-control" id="adsoyad" type="text" name="adsoyad" required>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center g-2 m-2">
            <div class="col">
                <div class="m-3">
                    <label for="yemekA" class="form-label">Yemek Adı</label>
                    <input class="form-control" id="yemekA" type="text" name="yemekA">
                </div>
            </div>
            <div class="col">
                <div class="m-3">
                    <label for="tarifi" class="form-label">Tarifi</label>
                    <input class="form-control" id="tarifi" type="text" name="tarifi">
                </div>
            </div>
            <div class="col">
                <div class="m-3">
                    <label for="kactl" class="form-label">Kaç TL</label>
                    <input class="form-control" id="kactl" type="text" name="kactl">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary m-2" name="yemekEkle">Kaydet</button>
    </form>
</main>
