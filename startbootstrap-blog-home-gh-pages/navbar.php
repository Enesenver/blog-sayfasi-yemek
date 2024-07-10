<?php session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#!">final</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Anasayfa</a></li>
                <li class="nav-item"><a class="nav-link" href="yemekEkle.php">Yemek Ekle</a></li>
                <li class="nav-item"><a class="nav-link" href="yemekleriGö.php">Yemekler</a></li>
                <?php if (!isset($_SESSION["giris_bilgisi"]) || $_SESSION["giris_bilgisi"] !== True) { ?>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="kayıtol.php">Kayıt Ol</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <?php if (isset($_SESSION["giris_bilgisi"])) { 
                        $id = $_SESSION["id_bilgisi"]; ?>
                        <img class="rounded-circle me-lg-2" src="img/avatars/<?php echo $id; ?>.jpg" alt="" style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex">
                            <?php echo $_SESSION["kullaniciadi_bilgisi"]; ?>
                        </span>
                    <?php } else { ?>
                        <img class="rounded-circle me-lg-2" src="img/user_empty.jpg" alt="" style="width: 40px; height: 40px;">
                    <?php } ?>
                </a>
                <?php if (isset($_SESSION["giris_bilgisi"]) && $_SESSION["giris_bilgisi"] === True) { ?>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="profil.php" class="dropdown-item">Profil</a>
                        <a href="cıkış.php" class="dropdown-item">Çıkış</a>
                    </div>
                <?php } else { ?>
                    <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="kayıtol.php" class="dropdown-item">Giriş</a>
                        <a href="kayitol.php" class="dropdown-item">Kayıt Ol</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS, Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
