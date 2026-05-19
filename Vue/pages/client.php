<div class="pagetitle">
    <h1>Gestion des Clients</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Liste des Clients</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#clientModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Ajouter un Client
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped dt-responsive nowrap" id="clientTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th class="all">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Client -->
<div class="modal fade" id="clientModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="clientForm">
                <input type="hidden" name="id_client" id="id_client">
                <div class="modal-header">
                    <h5 class="modal-title">Formulaire Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" id="prenom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" id="telephone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse</label>
                        <textarea name="adresse" id="adresse" class="form-control"></textarea>
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
let clientTable;

$(document).ready(function() {
    loadClients();

    $('#clientForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'api.php?entity=client&action=save',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#clientModal').modal('hide');
                    Swal.fire('Succès', 'Opération réussie', 'success');
                    loadClients();
                } else {
                    Swal.fire('Erreur', 'Une erreur est survenue', 'error');
                }
            }
        });
    });
});

function loadClients() {
    $.get('api.php?entity=client&action=list', function(data) {
        if ($.fn.DataTable.isDataTable('#clientTable')) {
            $('#clientTable').DataTable().destroy();
        }
        
        let rows = '';
        data.forEach(c => {
            rows += `<tr>
                <td>${c.nom}</td>
                <td>${c.prenom}</td>
                <td>${c.email || ''}</td>
                <td>${c.telephone || ''}</td>
                <td>${c.adresse || ''}</td>
                <td class="actions-column">
                    <button class="btn btn-sm btn-info" onclick='editClient(${JSON.stringify(c)})'><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="deleteClient(${c.id_client})"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`;
        });
        $('#clientTable tbody').html(rows);
        
        $('#clientTable').DataTable({
            responsive: true,
            language: datatable_fr,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ]
        });
    });
}

function editClient(c) {
    resetForm();
    $('#id_client').val(c.id_client);
    $('#nom').val(c.nom);
    $('#prenom').val(c.prenom);
    $('#email').val(c.email);
    $('#telephone').val(c.telephone);
    $('#adresse').val(c.adresse);
    $('#clientModal').modal('show');
}

function deleteClient(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('api.php?entity=client&action=delete', {id_client: id}, function(response) {
                if (response.status === 'success') {
                    Swal.fire('Supprimé !', 'Le client a été supprimé.', 'success');
                    loadClients();
                }
            }, 'json');
        }
    });
}

function resetForm() {
    $('#clientForm')[0].reset();
    $('#id_client').val('');
}
</script>
