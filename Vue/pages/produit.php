<div class="pagetitle">
    <h1>Gestion des Produits</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Liste des Produits</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#produitModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Ajouter un Produit
            </button>
        </div>
        <div class="card-body">
            <table class="table table-striped dt-responsive nowrap" id="produitTable" style="width:100%">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Prix Achat</th>
                        <th>Prix Vente</th>
                        <th class="all">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="produitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="produitForm" enctype="multipart/form-data">
                <input type="hidden" name="id_produit" id="id_produit">
                <input type="hidden" name="old_photo" id="old_photo">
                <div class="modal-header">
                    <h5 class="modal-title">Formulaire Produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" id="pNom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prix Achat</label>
                        <input type="number" step="0.01" name="prix_achat" id="pPrixAchat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prix Vente</label>
                        <input type="number" step="0.01" name="prix_vente" id="pPrixVente" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo du produit</label>
                        <input type="file" name="photo" id="pPhoto" class="form-control" accept="image/*">
                        <div id="photoPreview" class="mt-2"></div>
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
    loadProduits();
    
    // Prévisualisation de l'image
    $('#pPhoto').change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#photoPreview').html(`<img src="${event.target.result}" style="width: 100px; border-radius: 5px;">`);
            };
            reader.readAsDataURL(file);
        }
    });
    
    $('#produitForm').submit(function(e) {
        e.preventDefault();
        
        let achat = parseFloat($('#pPrixAchat').val());
        let vente = parseFloat($('#pPrixVente').val());
        
        if (vente < achat) {
            Swal.fire('Attention', 'Le prix de vente ne peut pas être inférieur au prix d\'achat', 'warning');
            return;
        }

        let formData = new FormData(this);
        
        $.ajax({
            url: 'api.php?entity=produit&action=save',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if(res.status==='success'){ 
                    $('#produitModal').modal('hide'); 
                    loadProduits(); 
                    Swal.fire('Succès','Opération réussie','success'); 
                } else {
                    Swal.fire('Erreur','Une erreur est survenue','error');
                }
            }
        });
    });
});

function loadProduits() {
    $.get('api.php?entity=produit&action=list', function(data) {
        if ($.fn.DataTable.isDataTable('#produitTable')) {
            $('#produitTable').DataTable().destroy();
        }
        let rows = '';
        data.forEach(p => {
            let photoUrl = p.photo ? 'assets/img/products/' + p.photo : 'assets/img/not-found.svg';
            rows += `<tr>
                <td><img src="${photoUrl}" alt="${p.nom}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                <td>${p.nom}</td>
                <td>${parseFloat(p.prix_achat).toLocaleString()} FCFA</td>
                <td>${parseFloat(p.prix_vente).toLocaleString()} FCFA</td>
                <td class="actions-column">
                    <button class="btn btn-sm btn-info" onclick='editProduit(${JSON.stringify(p)})'><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="deleteProduit(${p.id_produit})"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`;
        });
        $('#produitTable tbody').html(rows);
        $('#produitTable').DataTable({
            responsive: true,
            language: datatable_fr,
            columnDefs: [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: -1 }
            ]
        });
    });
}

function editProduit(p) {
    resetForm(); 
    $('#id_produit').val(p.id_produit); 
    $('#pNom').val(p.nom); 
    $('#pPrixAchat').val(p.prix_achat); 
    $('#pPrixVente').val(p.prix_vente);
    $('#old_photo').val(p.photo);
    
    if (p.photo) {
        $('#photoPreview').html(`<img src="assets/img/products/${p.photo}" style="width: 100px; border-radius: 5px;">`);
    }
    
    $('#produitModal').modal('show');
}

function deleteProduit(id) {
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('api.php?entity=produit&action=delete', {id_produit: id}, function(response) {
                if (response.status === 'success') {
                    Swal.fire('Supprimé !', 'Le produit a été supprimé.', 'success');
                    loadProduits();
                }
            }, 'json');
        }
    });
}

function resetForm() { 
    $('#produitForm')[0].reset(); 
    $('#id_produit').val(''); 
    $('#old_photo').val('');
    $('#photoPreview').empty();
}
</script>