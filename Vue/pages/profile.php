<div class="pagetitle">
    <h1>Profil</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashbord">Accueil</a></li>
            <li class="breadcrumb-item active">Profil</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <i class="bi bi-person-circle fs-1 text-primary mb-2"></i>
                    <h2><?= $_SESSION['user']->prenom . ' ' . $_SESSION['user']->nom ?></h2>
                    <h3>Utilisateur</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier le profil</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">
                            <form id="profileForm">
                                <input type="hidden" name="id_user" value="<?= $_SESSION['user']->id_user ?>">
                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="nom" type="text" class="form-control" id="nom" value="<?= $_SESSION['user']->nom ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="firstName" class="col-md-4 col-lg-3 col-form-label">Prénom</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="prenom" type="text" class="form-control" id="prenom" value="<?= $_SESSION['user']->prenom ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="email" value="<?= $_SESSION['user']->email ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="Password" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe (laisser vide pour garder l'ancien)</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="password">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    $('#profileForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'api.php?entity=utilisateur&action=updateProfile',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Succès', response.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Erreur', response.message, 'error');
                }
            }
        });
    });
});
</script>
