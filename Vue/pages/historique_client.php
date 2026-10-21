<div class="pagetitle">
    <h1>Mon Historique de Commandes</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="ecommerce">Accueil</a></li>
            <li class="breadcrumb-item active">Historique</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mes Commandes</h5>
                    <div class="table-responsive">
                        <table class="table table-hover" id="ventesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Détails Commande -->
<div class="modal fade" id="detailsCommandeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Détails de la Commande <span id="modal-id-commande"></span></h5>
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
                    <tbody id="details-commande-body"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function loadVentes() {
        $.ajax({
            url: 'api.php?entity=vente&action=listByUser',
            type: 'GET',
            dataType: 'json',
            success: function(ventes) {
                let html = '';
                ventes.forEach(vente => {
                    let badgeClass = 'bg-warning';
                    if (vente.statut === 'Livré') badgeClass = 'bg-success';
                    if (vente.statut === 'Annulé') badgeClass = 'bg-danger';

                    html += `
                        <tr>
                            <td>#${vente.id_vente}</td>
                            <td>${vente.date}</td>
                            <td>${parseFloat(vente.total).toLocaleString()} FCFA</td>
                            <td><span class="badge ${badgeClass}">${vente.statut}</span></td>
                            <td>
                                <button class="btn btn-sm btn-info text-white view-details" data-id="${vente.id_vente}">
                                    <i class="bi bi-eye"></i> Détails
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#ventesTable tbody').html(html);
            }
        });
    }

    loadVentes();

    $(document).on('click', '.view-details', function() {
        let id = $(this).data('id');
        $('#modal-id-commande').text('#' + id);
        $('#details-commande-body').html('<tr><td colspan="4" class="text-center"><div class="spinner-border spinner-border-sm text-primary"></div></td></tr>');
        $('#detailsCommandeModal').modal('show');

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
            $('#details-commande-body').html(html);
        }, 'json');
    });
});
</script>