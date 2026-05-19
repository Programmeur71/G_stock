<div class="pagetitle">
    <h1>Historique des Approvisionnements</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Toutes les Commandes Fournisseurs</h5>
            <table class="table table-striped dt-responsive nowrap" id="approTable" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>Total Achat</th>
                        <th>Statut</th>
                        <th class="all">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Détails Approvisionnement -->
<div class="modal fade" id="detailsApproModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Détails de l'Approvisionnement <span id="modal-id-commande"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Qté</th>
                            <th>Prix Achat</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody id="details-appro-body"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadAppro();

    $(document).on('click', '.view-details', function() {
        let id = $(this).data('id');
        $('#modal-id-commande').text('#' + id);
        $('#details-appro-body').html('<tr><td colspan="4" class="text-center"><div class="spinner-border spinner-border-sm text-info"></div></td></tr>');
        $('#detailsApproModal').modal('show');

        $.get('api.php?entity=commande&action=getDetails&id=' + id, function(details) {
            let html = '';
            details.forEach(d => {
                html += `<tr>
                    <td>${d.produit_nom}</td>
                    <td class="text-center">${d.quantite}</td>
                    <td class="text-end">${parseFloat(d.prix_unitaire).toLocaleString()}</td>
                    <td class="text-end fw-bold">${(d.quantite * d.prix_unitaire).toLocaleString()}</td>
                </tr>`;
            });
            $('#details-appro-body').html(html);
        }, 'json');
    });
});

function loadAppro() {
    $.get('api.php?entity=commande&action=listWithDetails', function(data) {
        if ($.fn.DataTable.isDataTable('#approTable')) {
            $('#approTable').DataTable().destroy();
        }
        let rows = '';
        data.forEach(c => {
            let utilisateur = c.utilisateur_nom ? c.utilisateur_prenom + ' ' + c.utilisateur_nom : 'Système';
            
            rows += `<tr>
                <td>#${c.id_commande}</td>
                <td>${c.date}</td>
                <td>${utilisateur}</td>
                <td class="fw-bold">${parseFloat(c.total).toLocaleString()} FCFA</td>
                <td><span class="badge bg-success">${c.statut}</span></td>
                <td class="actions-column">
                    <button class="btn btn-sm btn-info text-white view-details" data-id="${c.id_commande}">
                        <i class="bi bi-eye"></i> Détails
                    </button>
                </td>
            </tr>`;
        });
        $('#approTable tbody').html(rows);
        $('#approTable').DataTable({
            responsive: true,
            language: datatable_fr,
            order: [[0, 'desc']]
        });
    }, 'json');
}
</script>