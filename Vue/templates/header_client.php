<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>mboaStock - Boutique</title>
    <meta content="mboaStock - Votre boutique en ligne" name="description">
    <meta content="ecommerce, stock, mboaStock" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/wdesktop.png" rel="icon">
    <link href="assets/img/wdesktop.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    
    <!-- DataTables Responsive CSS -->
    <link href="assets/datatable/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="assets/datatable/css/responsive.dataTables.min.css" rel="stylesheet">
    
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
        }
        .actions-column {
            white-space: nowrap;
        }
    </style>

    <!-- jQuery (Must be before page scripts) -->
    <script src="assets/datatable/js/jquery.min.js"></script>
    <script src="assets/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/datatable/js/dataTables.responsive.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="assets/dist/js/sweetalert2.all.min.js"></script>

</head>

<body class="toggle-sidebar">

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="ecommerce" class="logo d-flex align-items-center text-decoration-none">
                <img src="assets/img/wdesktop.png" alt="mboaStock Logo" style="max-height: 40px;">
                <span class="d-none d-lg-block fs-4 fw-bold ms-2">mboaStock</span>
            </a>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item">
                    <a class="nav-link nav-icon d-flex align-items-center" href="ecommerce">
                        <i class="bi bi-house"></i>
                        <span class="d-none d-md-block ms-2">Boutique</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-icon d-flex align-items-center" href="Historique">
                        <i class="bi bi-clock-history"></i>
                        <span class="d-none d-md-block ms-2">Mes Commandes</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-cart"></i>
                        <span class="badge bg-success badge-number cart-count">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow cart-dropdown" style="min-width: 300px;">
                        <li class="dropdown-header">
                            Votre Panier
                            <a href="#" class="clear-cart"><span class="badge rounded-pill bg-danger p-2 ms-2">Vider</span></a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <div id="cart-items-list">
                            <!-- Items will be injected here -->
                        </div>
                        <li><hr class="dropdown-divider"></li>
                        <li class="dropdown-footer">
                            <button class="btn btn-primary btn-sm w-100 checkout-btn">Passer la commande</button>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['user']->prenom . ' ' . $_SESSION['user']->nom ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $_SESSION['user']->prenom . ' ' . $_SESSION['user']->nom ?></h6>
                            <span>Client</span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="profile">
                                <i class="bi bi-person"></i>
                                <span>Mon Profil</span>
                            </a>
                        </li>
                        <?php if($_SESSION['user']->id_client === null): ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="dashbord">
                                <i class="bi bi-shield-lock"></i>
                                <span>Administration</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="api.php?entity=utilisateur&action=logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Déconnexion</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>

    </header>

    <main id="main" class="main" style="margin-left: 0;">
