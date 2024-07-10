<?php
ob_start();
include "baglanti.php";
include "navbar.php";

// if(session_bilgi() !== true){ header("location: giris.php"); }
// ob_end_flush();

$sorgu = "SELECT id, resim, yemek_numarasi, ad_soyad, yemek_adi, tarifi, kac_tl, kayit_tarihi FROM yemeke";
$sonuc = mysqli_query($baglanti, $sorgu);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Final Sınavı</title>

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    
    <link href="css/styles.css" rel="stylesheet" />
    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    

    
    <header class="py-5 bg-light border-bottom mb-4">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">852</h1>
                <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
            </div>
        </div>
    </header>
    
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8">
               
                <div class="card mb-4">
                    <a href="#!"><img class="card-img-top" src="ee.jpg" alt="..." /></a>
                    <div class="card-body">
                        <h2 class="card-title">Featured Post Title</h2>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                    </div>
                </div>
             
                <div class="row">
                    <?php
                    if ($sonuc) {
                        while ($satir = mysqli_fetch_assoc($sonuc)) {
                            $resimYolu = htmlspecialchars($satir['resim']);
                            echo '<div class="col-lg-6">';
                            echo '<div class="card mb-4">';
                            echo '<a href="#!"><img class="card-img-top" src="' . $resimYolu . '" alt="Yemek Resmi" /></a>';
                            echo '<div class="card-body">';
                            echo '<div class="small text-muted"> ' . htmlspecialchars($satir['kayit_tarihi']) . '</div>';
                            echo '<h2 class="card-title h4">' . htmlspecialchars($satir['yemek_adi']) . '</h2>';
                            echo '<p class="card-text">' . htmlspecialchars($satir['tarifi']) . '</p>';
                            echo '<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal' . $satir['yemek_numarasi'] . '">Read more →</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';

                            echo '<div class="modal fade" id="modal' . $satir['yemek_numarasi'] . '" tabindex="-1" aria-labelledby="modalLabel' . $satir['yemek_numarasi'] . '" aria-hidden="true">';
                            echo '<div class="modal-dialog modal-dialog-scrollable">';
                            echo '<div class="modal-content">';
                            echo '<div class="modal-header">';
                            echo '<h5 class="modal-title" id="modalLabel' . $satir['yemek_numarasi'] . '">' . htmlspecialchars($satir['yemek_adi']) . '</h5>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                            echo '</div>';
                            echo '<div class="modal-body">';
                            echo '<p>Ad Soyad: ' . htmlspecialchars($satir['ad_soyad']) . '</p>';
                            echo '<p>Tarifi: ' . htmlspecialchars($satir['tarifi']) . '</p>';
                            echo '<p>Kaç TL: ' . htmlspecialchars($satir['kac_tl']) . '</p>';
                            echo '<a href="düzenle.php?yemek_numarasi=' . $satir['yemek_numarasi'] . '" class="btn btn-sm btn-warning">Düzenle</a>';
                            echo '<a class="btn btn-sm btn-danger" href="sil.php?yemek_numarasi=' . $satir["yemek_numarasi"] . '" onclick="return confirm(\'Bu Öğrenciyi Silmek İstediğinizden Emin Misiniz?\');">Sil</a>';


                            echo '</div>';
                            echo '<div class="modal-footer">';
                            echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    mysqli_close($baglanti);
                    ?>
                </div>
                
                <nav aria-label="Pagination">
                    <hr class="my-0" />
                    <ul class="pagination justify-content-center my-4">
                        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                        <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                        <li class="page-item"><a class="page-link" href="#!">2</a></li>
                        <li class="page-item"><a class="page-link" href="#!">3</a></li>
                        <li class="page-item disabled"><a class="page-link
" href="#!">...</a></li>
                        <li class="page-item"><a class="page-link" href="#!">15</a></li>
                        <li class="page-item"><a class="page-link" href="#!">Older</a></li>
                    </ul>
                </nav>
            </div>
           
            <div class="col-lg-4">
              
                <div class="card mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                        </div>
                    </div>
                </div>
             
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="şifreoluştur">Web Design</a></li>
                                    <li><a href="düzenle.php">HTML</a></li>
                                    <li><a href="#!">Freebies</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!">JavaScript</a></li>
                                    <li><a href="#!">CSS</a></li>
                                    <li><a href="#!">Tutorials</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                </div>
            </div>
        </div>
    </div>
  
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
  
    <script src="js/scripts.js"></script>
</body>
</html>
