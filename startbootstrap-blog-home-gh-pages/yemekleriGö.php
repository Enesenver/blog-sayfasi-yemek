<?php
ob_start();
include "baglanti.php";

// if(session_bilgi() !== true){ header("location: giris.php"); }
// ob_end_flush();

$sorgu = "SELECT * FROM yemek ORDER BY ad_soyad";
$sonuc = mysqli_query($baglanti, $sorgu);

mysqli_close($baglanti);
?>

<main>
<a class="btn btn-primary m-2" href="oekle.php" role="button">Yemek Ekle</a>

<div class="card mb-4">
    <div class="card-body">
        <table id="datatablesSimple" class="table">
            <thead>
                <tr>
                    <th scope="col">Yemek Numarası</th>
                    <th scope="col">Ad Soyad</th>
                    <th scope="col">Yemek Adı</th>
                    <th scope="col">Tarifi</th>
                    <th scope="col">Kaç TL</th>
                    <th scope="col">Aksiyon</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($yemek = mysqli_fetch_assoc($sonuc)){ ?>
                <tr>
                    <td><?php echo htmlspecialchars($yemek["yemek_numarasi"]); ?></td>
                    <td><?php echo htmlspecialchars($yemek["ad_soyad"]); ?></td>
                    <td><?php echo htmlspecialchars($yemek["yemek_adi"]); ?></td>
                    <td><?php echo htmlspecialchars($yemek["tarifi"]); ?></td>
                    <td><?php echo htmlspecialchars($yemek["kac_tl"]); ?></td>
                    <td>
                        <a href="oduzenle.php?id=<?php echo htmlspecialchars($yemek["id"]); ?>" class="btn btn-sm btn-warning">
                            Düzenle
                        </a>
                        &nbsp;
                        <a class="btn btn-sm btn-danger" href="osil.php?id=<?php echo htmlspecialchars($yemek["id"]); ?>" onclick="if (!confirm('Bu yemeği silmek istediğinizden emin misiniz?')) return false;">
                            Sil
                        </a>
                        &nbsp;
                        <a href="ogoruntule.php?id=<?php echo htmlspecialchars($yemek["id"]); ?>" class="btn btn-sm btn-info">
                            Görüntüle
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</main>

