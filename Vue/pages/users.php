<div class="pagetitle">
    <h1>Gestion des Utilisateurs</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Liste du Personnel (Non-Clients)</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Ajouter un Utilisateur
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped dt-responsive nowrap" id="userTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Groupe / Rôle</th>
                        <th class="all">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="userForm">
                <input type="hidden" name="id_user" id="id_user">
                <div class="modal-header">
                    <h5 class="modal-title">Formulaire Utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" id="userNom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" id="userPrenom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact / Téléphone</label>
                        <input type="text" name="contact" id="userContact" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="userEmail" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Groupe / Rôle</label>
                        <select name="id_role" id="userRole" class="form-select" required>
                            <option value="">Sélectionner un groupe...</option>
                            <!-- Chargé via AJAX -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="userPassword" class="form-control" placeholder="Laisser vide pour garder l'ancien ou par défaut 123456">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadUsers();
    loadGroupOptions();
    
    $('#userForm').submit(function(e) {
        e.preventDefault();
        console.log("Envoi des données utilisateur...");
        $.ajax({
            url: 'api.php?entity=utilisateur&action=save',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                console.log("Réponse reçue :", res);
                if(res.status==='success'){ 
                    $('#userModal').modal('hide'); 
                    loadUsers(); 
                    Swal.fire({ title: 'Succès', text: res.message, type: 'success' }); 
                } else {
                    Swal.fire({ title: 'Erreur', text: res.message || 'Une erreur est survenue', type: 'error' });
                }
            },
            error: function(xhr) {
                console.error("Erreur critique lors de l'enregistrement :");
                console.log(xhr.responseText);
                Swal.fire({ title: 'Erreur Serveur', text: 'Impossible d\'enregistrer. Appuyez sur F12 pour voir l\'erreur.', type: 'error' });
            }
        });
    });
});

function loadUsers() {
    $.get('api.php?entity=utilisateur&action=list', function(data) {
        if (!Array.isArray(data)) {
            console.error("Les données reçues ne sont pas un tableau:", data);
            return;
        }

        if ($.fn.DataTable.isDataTable('#userTable')) {
            $('#userTable').DataTable().destroy();
        }
        
        let rows = '';
        data.forEach(u => {
            let roleBadge = u.role_nom ? `<span class="badge bg-info">${u.role_nom}</span>` : '<span class="badge bg-secondary">Aucun</span>';
            rows += `<tr>
                <td>${u.nom}</td>
                <td>${u.prenom}</td>
                <td>${u.email}</td>
                <td>${roleBadge}</td>
                <td class="actions-column">
                    <button class="btn btn-sm btn-info text-white" onclick='editUser(${JSON.stringify(u)})'><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="deleteUser(${u.id_user})"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`;
        });
        $('#userTable tbody').html(rows);
        $('#userTable').DataTable({
            responsive: true,
            language: datatable_fr,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ]
        });
    }, 'json');
}

function loadGroupOptions() {
    $.get('api.php?entity=groupe&action=list', function(data) {
        let options = '<option value="">Sélectionner un groupe...</option>';
        data.forEach(g => {
            // Ne pas afficher le rôle CLIENTS dans la gestion du personnel
            if (g.designation !== 'CLIENTS') {
                options += `<option value="${g.id_role}">${g.designation}</option>`;
            }
        });
        $('#userRole').html(options);
    }, 'json');
}

function editUser(u) {
    resetForm(); 
    $('#id_user').val(u.id_user); 
    $('#userNom').val(u.nom); 
    $('#userPrenom').val(u.prenom); 
    $('#userContact').val(u.contact); 
    $('#userEmail').val(u.email);
    
    // Si l'utilisateur a déjà un rôle, on le sélectionne
    if(u.id_role) {
        $('#userRole').val(u.id_role);
    }

    $('#userModal').modal('show');
}

function deleteUser(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action supprimera l'utilisateur !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer !'
    }).then((result) => {
        if (result.value) {
            $.post('api.php?entity=utilisateur&action=delete', {id_user: id}, function(res) {
                if(res.status === 'success') {
                    Swal.fire({ title: 'Supprimé !', text: 'L\'utilisateur a été supprimé.', type: 'success' });
                    loadUsers();
                }
            }, 'json');
        }
    });
}

function resetForm() { 
    $('#userForm')[0].reset(); 
    $('#id_user').val(''); 
}
</script>
