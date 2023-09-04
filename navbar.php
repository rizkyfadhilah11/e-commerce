

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="index.php">Gummo Ltd</a> 
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produk.php">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <!-- jika ada session login-->
                    <?php if(isset($_SESSION['pelanggan'])):?>
                        <a class="nav-link" href="logout.php">Logout</a>
                    <?php else:?>
                        <a class="nav-link" href="login.php">Login</a>
                    <?php endif ?>
                </li>
                <li class="nav-item">
                    <!-- jika ada session login-->
                    <?php if(isset($_SESSION['pelanggan'])):?>
                        <a class="nav-link" href="riwayat.php">Riwayat Belanja</a>
                    <?php else:?>
                        
                    <?php endif ?>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
                </li>
                <li class="nav-item ">
                    <?php if(isset($_SESSION['pelanggan'])):?>
                    <a class="nav-link -toggle" href="edit_profil.php?id=<?= $_SESSION['pelanggan']['id'];?>" id="navbar" role="button" >
                    <i class="fa-solid fa-user"></i> <?= $_SESSION['name'];?>
                </a>
                
                    <?php else:?>

                    <?php endif?>
                </li>
            </ul>
        </div>
    </div>
</nav>