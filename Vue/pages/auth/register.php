<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>mboaStock - Inscription</title>
    <meta content="mboaStock - Gestion de stock intelligente" name="description">
    <meta content="stock, gestion, mboaStock" name="keywords">

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

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: #f6f9ff;
        }
        .logo span {
            color: #012970;
        }
    </style>
</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="logo d-flex flex-column align-items-center w-auto text-decoration-none text-center">
                                    <img src="assets/img/wdesktop.png" alt="mboaStock Logo" style="max-height: 80px;" class="mb-2">
                                    <span class="d-lg-block fs-2 fw-bold">mboaStock</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Créer un compte</h5>
                                        <p class="text-center small">Entrez vos détails personnels pour créer un compte</p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate id="registerForm">
                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Nom</label>
                                            <input type="text" name="name" class="form-control" id="yourName" required>
                                            <div class="invalid-feedback">S'il vous plaît, entrez votre nom !</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourFirstName" class="form-label">Prénom</label>
                                            <input type="text" name="firstname" class="form-control" id="yourFirstName" required>
                                            <div class="invalid-feedback">S'il vous plaît, entrez votre prénom !</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourContact" class="form-label">Contact (Téléphone)</label>
                                            <input type="text" name="contact" class="form-control" id="yourContact" required>
                                            <div class="invalid-feedback">S'il vous plaît, entrez votre numéro de téléphone !</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="yourEmail"
                                                required>
                                            <div class="invalid-feedback">S'il vous plaît, entrez une adresse email valide !</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Mot de passe</label>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" required>
                                            <div class="invalid-feedback">S'il vous plaît, entrez votre mot de passe !</div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" name="terms" type="checkbox" value=""
                                                    id="acceptTerms" required>
                                                <label class="form-check-label" for="acceptTerms">J'accepte les
                                                    <a href="#">termes et conditions</a></label>
                                                <div class="invalid-feedback">Vous devez accepter avant de soumettre.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Créer le compte</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Déjà un compte ? <a href="login">Se connecter</a>
                                            </p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script type="text/javascript" src="assets/dist/js/Jquery.js"></script>
    <script type="text/javascript" src="assets/dist/js/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            
            if (this.checkValidity() === false) {
                e.stopPropagation();
                $(this).addClass('was-validated');
                return;
            }

            $.ajax({
                url: 'api.php?entity=utilisateur&action=register',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            type: 'success',
                            title: 'Succès',
                            text: response.message
                        }).then(() => {
                            window.location.href = 'login';
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Erreur',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        type: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue lors de la communication avec le serveur.'
                    });
                }
            });
        });
    });
    </script>

</body>

</html>