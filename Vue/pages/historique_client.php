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
                    if (vente.statut === 'Terminé') badgeClass = 'bg-success';
                    if (vente.statut === 'Annulé') badgeClass = 'bg-danger';

                    html += `
                        <tr>
                            <td>#${vente.id_vente}</td>
                            <td>${vente.date}</td>
                            <td>${parseFloat(vente.total).toLocaleString()} FCFA</td>
                            <td><span class="badge ${badgeClass}">${vente.statut}</span></td>
                            <td>
                                <button class="btn btn-sm btn-info view-details" data-id="${vente.id_vente}">
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
        // Logic to show details could be added here (modal with detail_vente)
        Swal.fire('Détails', 'Fonctionnalité de consultation des détails à implémenter pour la commande #' + id, 'info');
    });
});
</script>