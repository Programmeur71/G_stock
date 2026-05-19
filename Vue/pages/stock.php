<div class="pagetitle">
    <h1>Gestion du Stock</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">État du Stock</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#stockModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Ajouter au Stock
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped datatable" id="stockTable">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Fournisseur</th>
                        <th>Quantité</th>
                        <th>Date Péremption</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="stockForm">
                <input type="hidden" name="id_stock" id="id_stock">
                <div class="modal-header">
                    <h5 class="modal-title">Formulaire Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Produit</label>
                        <select name="id_produit" id="id_produit" class="form-select" required></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fournisseur</label>
                        <select name="id_fournisseur" id="id_fournisseur" class="form-select" required></select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantité</label>
                        <input type="number" name="quantite" id="quantite" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date Péremption</label>
                        <input type="date" name="date_peremption" id="date_peremption" class="form-control" required>
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
    loadStock();
    loadDropdowns();

    $('#stockForm').submit(function(e) {
        e.preventDefault();
        $.post('api.php?entity=stock&action=save', $(this).serialize(), function(res) {
            if(res.status==='success'){ 
                $('#stockModal').modal('hide'); 
                loadStock(); 
                Swal.fire('Succès','Opération réussie','success'); 
            }
        }, 'json');
    });
});

function loadStock() {
    $.get('api.php?entity=stock&action=list', function(data) {
        if ($.fn.DataTable.isDataTable('#stockTable')) {
            $('#stockTable').DataTable().destroy();
        }
        let rows = '';
        data.forEach(s => {
            rows += `<tr>
                <td>${s.produit_nom}</td>
                <td>${s.fournisseur_nom}</td>
                <td>${s.quantite}</td>
                <td>${s.date_peremption}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick='editStock(${JSON.stringify(s)})'><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="deleteStock(${s.id_stock})"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`;
        });
        $('#stockTable tbody').html(rows);
        $('#stockTable').DataTable({
            responsive: true,
            language: datatable_fr
        });
    });
}

function loadDropdowns() {
    $.get('api.php?entity=produit&action=list', function(data) {
        let options = '<option value="">Sélectionner un produit</option>';
        data.forEach(p => options += `<option value="${p.id_produit}">${p.nom}</option>`);
        $('#id_produit').html(options);
    });
    $.get('api.php?entity=fournisseur&action=list', function(data) {
        let options = '<option value="">Sélectionner un fournisseur</option>';
        data.forEach(f => options += `<option value="${f.id_fournisseur}">${f.nom}</option>`);
        $('#id_fournisseur').html(options);
    });
}

function editStock(s) {
    resetForm();
    $('#id_stock').val(s.id_stock);
    $('#id_produit').val(s.id_produit);
    $('#id_fournisseur').val(s.id_fournisseur);
    $('#quantite').val(s.quantite);
    $('#date_peremption').val(s.date_peremption);
    $('#stockModal').modal('show');
}

function deleteStock(id) {
    if(confirm('Supprimer cette entrée de stock ?')) {
        $.post('api.php?entity=stock&action=delete', {id_stock: id}, loadStock, 'json');
    }
}

function resetForm() { $('#stockForm')[0].reset(); $('#id_stock').val(''); }
</script>
