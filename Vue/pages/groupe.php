<div class="pagetitle">
    <h1>Gestion des Groupes et Permissions</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Liste des Groupes (Rôles)</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#groupeModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Nouveau Groupe
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped dt-responsive nowrap" id="groupeTable" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Désignation</th>
                        <th class="all">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Groupe -->
<div class="modal fade" id="groupeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="groupeForm">
                <input type="hidden" name="id_role" id="id_role">
                <div class="modal-header">
                    <h5 class="modal-title">Formulaire Groupe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Désignation du groupe</label>
                        <input type="text" name="designation" id="roleDesignation" class="form-control" required>
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

<!-- Modal Permissions -->
<div class="modal fade" id="permissionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-shield-lock me-2"></i>Permissions pour : <span id="perm-groupe-nom" class="fw-bold"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="perm-id-role">
                <div class="alert alert-light border small mb-3 d-flex justify-content-between align-items-center">
                    <span>Cochez les actions autorisées pour ce groupe.</span>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check-all-perms">
                        <label class="form-check-label fw-bold text-primary" for="check-all-perms">Tout sélectionner</label>
                    </div>
                </div>
                
                <div class="row" id="permissions-container">
                    <!-- Chargé via AJAX -->
                    <div class="text-center py-4">
                        <div class="spinner-border text-info" role="status"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-info text-white px-4" id="btn-save-permissions">
                    <i class="bi bi-check-circle me-1"></i> Appliquer les changements
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadGroupes();
    
    $('#groupeForm').submit(function(e) {
        e.preventDefault();
        $.post('api.php?entity=groupe&action=save', $(this).serialize(), function(res) {
            if(res.status==='success'){ 
                $('#groupeModal').modal('hide'); 
                loadGroupes(); 
                Swal({ title: 'Succès', text: 'Groupe enregistré', type: 'success' }); 
            }
        }, 'json');
    });

    // Sauvegarder les permissions
    $('#btn-save-permissions').click(function() {
        let id_role = $('#perm-id-role').val();
        let selected = [];
        $('.perm-checkbox:checked').each(function() {
            selected.push($(this).val());
        });

        $.ajax({
            url: 'api.php?entity=groupe&action=syncPermissions',
            type: 'POST',
            data: { id_role: id_role, permissions: JSON.stringify(selected) },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({ title: 'Mis à jour', text: 'Les permissions ont été synchronisées.', type: 'success' });
                    $('#permissionsModal').modal('hide');
                }
            }
        });
    });

    // Logique Tout cocher / décocher
    $(document).on('change', '#check-all-perms', function() {
        $('.perm-checkbox').prop('checked', $(this).is(':checked'));
    });
});

function loadGroupes() {
    $.get('api.php?entity=groupe&action=list', function(data) {
        if ($.fn.DataTable.isDataTable('#groupeTable')) {
            $('#groupeTable').DataTable().destroy();
        }
        let rows = '';
        data.forEach(g => {
            rows += `<tr>
                <td>${g.id_role}</td>
                <td><span class="badge bg-light text-dark border">${g.designation}</span></td>
                <td class="actions-column">
                    <button class="btn btn-sm btn-info text-white" onclick='managePermissions(${JSON.stringify(g)})' title="Gérer les permissions">
                        <i class="bi bi-key"></i>
                    </button>
                    <button class="btn btn-sm btn-primary" onclick='editGroupe(${JSON.stringify(g)})' title="Modifier">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteGroupe(${g.id_role})" title="Supprimer">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>`;
        });
        $('#groupeTable tbody').html(rows);
        $('#groupeTable').DataTable({
            responsive: true,
            language: datatable_fr,
            columnDefs: [{ responsivePriority: 1, targets: 1 }, { responsivePriority: 2, targets: -1 }]
        });
    });
}

function managePermissions(g) {
    $('#perm-groupe-nom').text(g.designation);
    $('#perm-id-role').val(g.id_role);
    $('#permissions-container').html('<div class="text-center py-4"><div class="spinner-border text-info"></div></div>');
    $('#permissionsModal').modal('show');

    // 1. Charger toutes les permissions existantes
    $.get('api.php?entity=permission&action=list', function(allPerms) {
        // 2. Charger les permissions du groupe
        $.get('api.php?entity=groupe&action=getPermissions&id_role=' + g.id_role, function(rolePerms) {
            let userPermIds = rolePerms.map(p => p.id_permission);
            let html = '';
            
            // On regroupe les permissions par catégorie (optionnel pour la lisibilité)
            allPerms.forEach(p => {
                let isChecked = userPermIds.includes(p.id_permission) ? 'checked' : '';
                html += `
                    <div class="col-md-4 mb-2">
                        <div class="form-check card p-2 border-light shadow-none hover-shadow">
                            <input class="form-check-input perm-checkbox" type="checkbox" value="${p.id_permission}" id="perm${p.id_permission}" ${isChecked}>
                            <label class="form-check-label small fw-bold" for="perm${p.id_permission}">
                                ${p.designation.replace(/_/g, ' ')}
                            </label>
                        </div>
                    </div>`;
            });
            $('#permissions-container').html(html);
        }, 'json');
    }, 'json');
}

function editGroupe(g) {
    resetForm(); $('#id_role').val(g.id_role); $('#roleDesignation').val(g.designation);
    $('#groupeModal').modal('show');
}

function deleteGroupe(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "La suppression du groupe retirera tous les accès aux utilisateurs liés.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer'
    }).then((result) => {
        if (result.value) {
            $.post('api.php?entity=groupe&action=delete', {id_role: id}, function(res) {
                if(res.status==='success') { loadGroupes(); Swal.fire({ title: 'Supprimé', type: 'success' }); }
            }, 'json');
        }
    });
}

function resetForm() { $('#groupeForm')[0].reset(); $('#id_role').val(''); }
</script>
<style>
.hover-shadow:hover { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important; }
</style>
