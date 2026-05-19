<div class="pagetitle">
    <h1>Historique des Ventes</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Toutes les Ventes</h5>
            <table class="table table-striped dt-responsive nowrap" id="ventesTable" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Vendeur</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th class="all">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal Détails Vente -->
<div class="modal fade" id="detailsVenteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Détails de la Vente <span id="modal-id-vente"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Qté</th>
                            <th>Prix Unit.</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody id="details-vente-body"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadVentes();

    $(document).on('click', '.view-details-vente', function() {
        let id = $(this).data('id');
        $('#modal-id-vente').text('#' + id);
        $('#details-vente-body').html('<tr><td colspan="4" class="text-center"><div class="spinner-border spinner-border-sm text-primary"></div></td></tr>');
        $('#detailsVenteModal').modal('show');

        $.get('api.php?entity=vente&action=getDetails&id=' + id, function(details) {
            let html = '';
            details.forEach(d => {
                html += `<tr>
                    <td>${d.produit_nom}</td>
                    <td class="text-center">${d.quantite}</td>
                    <td class="text-end">${parseFloat(d.prix).toLocaleString()}</td>
                    <td class="text-end fw-bold">${(d.quantite * d.prix).toLocaleString()}</td>
                </tr>`;
            });
            $('#details-vente-body').html(html);
        }, 'json');
    });
});

function loadVentes() {
    $.get('api.php?entity=vente&action=listAll', function(data) {
        if ($.fn.DataTable.isDataTable('#ventesTable')) {
            $('#ventesTable').DataTable().destroy();
        }
        let rows = '';
        data.forEach(v => {
            let client = v.client_nom ? v.client_prenom + ' ' + v.client_nom : '<span class="text-muted">Inconnu</span>';
            let vendeur = v.vendeur_nom || 'Système';
            let badge = v.statut === 'Livré' ? 'bg-success' : (v.statut === 'En attente' ? 'bg-warning' : 'bg-secondary');
            
            rows += `<tr>
                <td>#${v.id_vente}</td>
                <td>${v.date}</td>
                <td>${client}</td>
                <td>${vendeur}</td>
                <td class="fw-bold">${parseFloat(v.total).toLocaleString()} FCFA</td>
                <td><span class="badge ${badge}">${v.statut}</span></td>
                <td class="actions-column">
                    <button class="btn btn-sm btn-info text-white view-details-vente" data-id="${v.id_vente}" title="Voir détails">
                        <i class="bi bi-eye"></i>
                    </button>
                    <a href="assets/fpdf/facture.php?id=${v.id_vente}" target="_blank" class="btn btn-sm btn-primary" title="Facture A4">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </a>
                    <a href="assets/fpdf/tiket.php?id=${v.id_vente}" target="_blank" class="btn btn-sm btn-success text-white" title="Ticket Thermique">
                        <i class="bi bi-receipt"></i>
                    </a>
                </td>
            </tr>`;
        });
        $('#ventesTable tbody').html(rows);
        $('#ventesTable').DataTable({
            responsive: true,
            language: datatable_fr,
            order: [[0, 'desc']]
        });
    }, 'json');
}
</script>