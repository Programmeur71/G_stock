<div class="pagetitle d-flex justify-content-between align-items-center">
    <h1>Interface de Vente</h1>
    <button class="btn btn-primary position-relative" id="btn-ouvrir-panier">
        <i class="bi bi-cart3 fs-4"></i>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="panier-badge">
            0
        </span>
    </button>
</div>

<section class="section mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body pt-4">
                    <div class="input-group input-group-lg border rounded-pill overflow-hidden bg-white shadow-sm">
                        <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-primary"></i></span>
                        <input type="text" class="form-control border-0" id="search-stock-vente" placeholder="Rechercher un produit en stock..." autocomplete="off">
                    </div>
                    <div id="results-stock-vente" class="list-group mt-2 shadow-sm d-none">
                        <!-- Résultats ici -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Panier et Validation -->
<div class="modal fade" id="panierVenteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-cart-fill me-2"></i>Récapitulatif de la Vente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produit</th>
                                <th>Prix Unit.</th>
                                <th>Quantité</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="panier-liste-body">
                            <!-- Items du panier -->
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold fs-5">
                                <td colspan="3" class="text-end">NET À PAYER :</td>
                                <td colspan="2" class="text-success"><span id="total-recap-vente">0</span> FCFA</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <hr>

                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label fw-bold">Sélectionner le Client</label>
                        <select class="form-select" id="recap-select-client">
                            <option value="">Choisir un client...</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Livraison immédiate ?</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="switch-livraison" checked>
                            <label class="form-check-label" for="switch-livraison" id="label-livraison">Oui (Décrémenter le stock)</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-danger" id="recap-btn-vider">Vider tout</button>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuer mes recherches</button>
                    <button type="button" class="btn btn-primary px-4" id="btn-finaliser-vente">Confirmer la Vente</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Quantité -->
<div class="modal fade" id="modalQtyVente" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <h6 class="fw-bold mb-3" id="qty-prod-nom">Produit</h6>
                <p class="text-muted small">Stock dispo: <span id="qty-prod-stock">0</span></p>
                <input type="number" class="form-control form-control-lg text-center mb-3" id="input-qty-val" value="1" min="1">
                <button class="btn btn-primary w-100" id="btn-valider-qty">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let panier = JSON.parse(sessionStorage.getItem('panier_vente_v2')) || [];
    let currentProd = null;

    // Charger clients une fois
    $.get('api.php?entity=client&action=list', function(data) {
        let options = '<option value="">Choisir un client...</option>';
        data.forEach(c => options += `<option value="${c.id_client}">${c.nom} ${c.prenom}</option>`);
        $('#recap-select-client').html(options);
    }, 'json');

    updateBadge();

    // Recherche sur stock (uniquement > 0)
    $('#search-stock-vente').on('input', function() {
        let query = $(this).val().trim();
        if (query.length < 1) { $('#results-stock-vente').addClass('d-none'); return; }

        $.get('api.php?entity=produit&action=listWithStock', function(products) {
            let filtered = products.filter(p => p.nom.toLowerCase().includes(query.toLowerCase()) && p.stock_disponible > 0);
            let html = '';
            if (filtered.length > 0) {
                filtered.forEach(p => {
                    html += `
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center select-prod-vente" 
                           data-id="${p.id_produit}" data-nom="${p.nom}" data-prix="${p.prix_vente}" data-stock="${p.stock_disponible}">
                            <div>
                                <h6 class="mb-0">${p.nom}</h6>
                                <small class="text-primary fw-bold">${parseFloat(p.prix_vente).toLocaleString()} FCFA</small>
                            </div>
                            <span class="badge bg-success rounded-pill">${p.stock_disponible} en stock</span>
                        </a>`;
                });
                $('#results-stock-vente').html(html).removeClass('d-none');
            } else {
                $('#results-stock-vente').html('<div class="list-group-item text-muted">Rupture de stock ou produit inconnu</div>').removeClass('d-none');
            }
        }, 'json');
    });

    // Clic sur un résultat
    $(document).on('click', '.select-prod-vente', function(e) {
        e.preventDefault();
        currentProd = {
            id: $(this).data('id'),
            nom: $(this).data('nom'),
            prix: parseFloat($(this).data('prix')),
            stock: parseInt($(this).data('stock'))
        };
        $('#qty-prod-nom').text(currentProd.nom);
        $('#qty-prod-stock').text(currentProd.stock);
        $('#input-qty-val').val(1).attr('max', currentProd.stock);
        $('#modalQtyVente').modal('show');
        $('#results-stock-vente').addClass('d-none');
        $('#search-stock-vente').val('');
    });

    // Valider quantité
    $('#btn-valider-qty').click(function() {
        let qte = parseInt($('#input-qty-val').val());
        if (qte > 0 && qte <= currentProd.stock) {
            let existing = panier.find(i => i.id_produit === currentProd.id);
            if (existing) {
                if (existing.quantite + qte > currentProd.stock) {
                    Swal.fire({ title: 'Erreur', text: 'Stock insuffisant pour ce cumul', type: 'error' });
                    return;
                }
                existing.quantite += qte;
            } else {
                panier.push({ id_produit: currentProd.id, nom: currentProd.nom, prix: currentProd.prix, quantite: qte, stock_max: currentProd.stock });
            }
            sessionStorage.setItem('panier_vente_v2', JSON.stringify(panier));
            updateBadge();
            $('#modalQtyVente').modal('hide');
            
            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1500 });
            Toast.fire({ type: 'success', title: 'Ajouté au panier' });
        }
    });

    function updateBadge() {
        let count = panier.reduce((sum, i) => sum + i.quantite, 0);
        $('#panier-badge').text(count);
    }

    // Ouvrir le panier modal
    $('#btn-ouvrir-panier').click(function() {
        renderModalPanier();
        $('#panierVenteModal').modal('show');
    });

    function renderModalPanier() {
        let html = '';
        let total = 0;
        if (panier.length === 0) {
            html = '<tr><td colspan="5" class="text-center text-muted">Le panier est vide</td></tr>';
        } else {
            panier.forEach((item, index) => {
                let st = item.prix * item.quantite;
                total += st;
                html += `
                    <tr>
                        <td>${item.nom}</td>
                        <td>${item.prix.toLocaleString()}</td>
                        <td><input type="number" class="form-control form-control-sm upd-qty-m" data-index="${index}" value="${item.quantite}" min="1" max="${item.stock_max}" style="width:70px"></td>
                        <td class="fw-bold">${st.toLocaleString()}</td>
                        <td><button class="btn btn-sm text-danger del-item-m" data-index="${index}"><i class="bi bi-trash"></i></button></td>
                    </tr>`;
            });
        }
        $('#panier-liste-body').html(html);
        $('#total-recap-vente').text(total.toLocaleString());
    }

    // Actions dans le modal
    $(document).on('change', '.upd-qty-m', function() {
        let idx = $(this).data('index');
        let val = parseInt($(this).val());
        if (val > 0 && val <= panier[idx].stock_max) {
            panier[idx].quantite = val;
            sessionStorage.setItem('panier_vente_v2', JSON.stringify(panier));
            renderModalPanier();
            updateBadge();
        }
    });

    $(document).on('click', '.del-item-m', function() {
        panier.splice($(this).data('index'), 1);
        sessionStorage.setItem('panier_vente_v2', JSON.stringify(panier));
        renderModalPanier();
        updateBadge();
    });

    $('#recap-btn-vider').click(function() {
        panier = [];
        sessionStorage.removeItem('panier_vente_v2');
        renderModalPanier();
        updateBadge();
    });

    $('#switch-livraison').change(function() {
        $('#label-livraison').text($(this).is(':checked') ? 'Oui (Décrémenter le stock)' : 'Non (Garder le stock)');
    });

    // Finaliser la vente
    $('#btn-finaliser-vente').click(function() {
        let id_client = $('#recap-select-client').val();
        if (panier.length === 0) { Swal.fire({ title: 'Erreur', text: 'Panier vide', type: 'error' }); return; }
        
        if (!id_client || id_client === "") { 
            Swal.fire({ 
                title: 'Client manquant', 
                text: 'Veuillez sélectionner un client pour valider la vente.', 
                type: 'warning' 
            }); 
            return; 
        }

        $.ajax({
            url: 'api.php?entity=vente&action=createAdminSale',
            type: 'POST',
            data: {
                id_client: id_client,
                livrer: $('#switch-livraison').is(':checked'),
                panier: JSON.stringify(panier)
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({ title: 'Succès', text: res.message, type: 'success' }).then(() => {
                        panier = [];
                        sessionStorage.removeItem('panier_vente_v2');
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ title: 'Erreur', text: res.message, type: 'error' });
                }
            }
        });
    });
});
</script>