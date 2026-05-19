<div class="pagetitle">
    <h1>Gestion des Fournisseurs</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Liste des Fournisseurs</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#fournisseurModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Ajouter un Fournisseur
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped dt-responsive nowrap" id="fournisseurTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th class="all">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="fournisseurModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="fournisseurForm">
                <input type="hidden" name="id_fournisseur" id="id_fournisseur">
                <div class="modal-header">
                    <h5 class="modal-title">Formulaire Fournisseur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nom</label><input type="text" name="nom" id="fNom" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Prénom</label><input type="text" name="prenom" id="fPrenom" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" id="fEmail" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Adresse</label><input type="text" name="adresse" id="fAdresse" class="form-control"></div>
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
    loadFournisseurs();
    $('#fournisseurForm').submit(function(e) {
        e.preventDefault();
        $.post('api.php?entity=fournisseur&action=save', $(this).serialize(), function(res) {
            if(res.status==='success'){ $('#fournisseurModal').modal('hide'); loadFournisseurs(); Swal.fire('Succès','Opération réussie','success'); }
        }, 'json');
    });
});
function loadFournisseurs() {
    $.get('api.php?entity=fournisseur&action=list', function(data) {
        if ($.fn.DataTable.isDataTable('#fournisseurTable')) {
            $('#fournisseurTable').DataTable().destroy();
        }
        let rows = '';
        data.forEach(f => {
            rows += `<tr><td>${f.nom}</td><td>${f.prenom}</td><td>${f.email || ''}</td><td>${f.adresse || ''}</td><td class="actions-column">
                <button class="btn btn-sm btn-info" onclick='editFournisseur(${JSON.stringify(f)})'><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-danger" onclick="deleteFournisseur(${f.id_fournisseur})"><i class="bi bi-trash"></i></button>
            </td></tr>`;
        });
        $('#fournisseurTable tbody').html(rows);
        $('#fournisseurTable').DataTable({
            responsive: true,
            language: datatable_fr,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ]
        });
    });
}
function editFournisseur(f) {
    resetForm(); $('#id_fournisseur').val(f.id_fournisseur); $('#fNom').val(f.nom); $('#fPrenom').val(f.prenom); $('#fEmail').val(f.email); $('#fAdresse').val(f.adresse);
    $('#fournisseurModal').modal('show');
}
function deleteFournisseur(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('api.php?entity=fournisseur&action=delete', {id_fournisseur: id}, function(response) {
                if (response.status === 'success') {
                    Swal.fire('Supprimé !', 'Le fournisseur a été supprimé.', 'success');
                    loadFournisseurs();
                }
            }, 'json');
        }
    });
}
function resetForm() { $('#fournisseurForm')[0].reset(); $('#id_fournisseur').val(''); }
</script>
