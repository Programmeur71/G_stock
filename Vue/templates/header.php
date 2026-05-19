<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>MboaStock</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/wmobile.png" rel="icon">
    <link href="assets/img/wmobile.png" rel="apple-touch-icon">

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
        /* Assurer que la colonne Actions reste visible */
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before {
            display: none !important;
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

    <script>
        const datatable_fr = {
            "emptyTable": "Aucune donnée disponible dans le tableau",
            "info": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "infoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
            "infoFiltered": "(filtré à partir de _MAX_ éléments au total)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Afficher _MENU_ éléments",
            "loadingRecords": "Chargement...",
            "processing": "Traitement...",
            "search": "Rechercher :",
            "zeroRecords": "Aucun élément correspondant trouvé",
            "paginate": {
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précédent"
            },
            "aria": {
                "sortAscending": ": activer pour trier la colonne par ordre croissant",
                "sortDescending": ": activer pour trier la colonne par ordre décroissant"
            }
        };
    </script>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="dashbord" class="logo d-flex align-items-center text-decoration-none">
                <img src="assets/img/wdesktop.png" alt="mboaStock Logo" style="max-height: 70px;">
                <!-- <span class="d-none d-lg-block fs-4 fw-bold ms-2">mboaStock</span> -->
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['user']->prenom . ' ' . $_SESSION['user']->nom ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $_SESSION['user']->prenom . ' ' . $_SESSION['user']->nom ?></h6>
                            <span>Utilisateur</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="profile">
                                <i class="bi bi-person"></i>
                                <span>Mon Profil</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="ecommerce">
                                <i class="bi bi-cart"></i>
                                <span>Espace Client</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="api.php?entity=utilisateur&action=logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Déconnexion</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="dashbord"?"":"collapsed"?>" href="dashbord">
                    <i class="bi bi-grid"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>

            <?php if(hasPermission('VOIR_CLIENT')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="client"?"":"collapsed"?>" href="client">
                    <i class="bi bi-person"></i>
                    <span>Clients</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(hasPermission('VOIR_FOURNISSEUR')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="fournisseur"?"":"collapsed"?>" href="fournisseur">
                    <i class="bi bi-people"></i>
                    <span>Fournisseurs</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(hasPermission('VOIR_PRODUIT')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="produit"?"":"collapsed"?>" href="produit">
                    <i class="bi bi-box-seam"></i>
                    <span>Produits</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(hasPermission('VOIR_STOCK')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="stock"?"":"collapsed"?>" href="stock">
                    <i class="bi bi-box"></i>
                    <span>Stocks</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(hasPermission('VOIR_COMMANDE')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="commande"?"":"collapsed"?>" href="commande">
                    <i class="bi bi-cart"></i>
                    <span>Nouvel Appro.</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(hasPermission('VOIR_VENTE')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="vente"?"":"collapsed"?>" href="vente">
                    <i class="bi bi-cash-stack"></i>
                    <span>Nouvelle Vente</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="Historique"?"":"collapsed"?>" href="Historique">
                    <i class="bi bi-clock-history"></i>
                    <span>Historique Ventes</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(hasPermission('VOIR_COMMANDE')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="Approvisionnement"?"":"collapsed"?>" href="Approvisionnement">
                    <i class="bi bi-journal-check"></i>
                    <span>Historique Appro.</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(hasPermission('VOIR_UTILISATEUR')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="users"?"":"collapsed"?>" href="users">
                    <i class="bi bi-people"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(hasPermission('VOIR_ROLE')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="groupe"?"":"collapsed"?>" href="groupe">
                    <i class="bi bi-shield-lock"></i>
                    <span>Groupes</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(hasPermission('VOIR_PERMISSION')): ?>
            <li class="nav-item">
                <a class="nav-link <?=$route[0]=="permissions"?"":"collapsed"?>" href="permissions">
                    <i class="bi bi-key"></i>
                    <span>Permissions</span>
                </a>
            </li>
            <?php endif; ?>

        </ul>

    </aside>
    <main id="main" class="main">