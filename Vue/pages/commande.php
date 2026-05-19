<div class="pagetitle">
    <h1>Gestion des Commandes (Approvisionnement)</h1>
</div>

<section class="section">
    <div class="row">
        <!-- Zone de recherche et Panier -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nouvelle Commande</h5>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">1. Choisir le Fournisseur</label>
                            <select class="form-select" id="select-fournisseur">
                                <option value="">Sélectionner un fournisseur...</option>
                                <!-- Chargé via AJAX -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">2. Rechercher un Produit</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="search-produit" placeholder="Saisissez le nom du produit..." autocomplete="off">
                                <div id="search-results" class="list-group position-absolute w-100 shadow-sm d-none" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                    <!-- Résultats de recherche -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="panier-commande">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix Achat</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th>Péremption</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Items du panier -->
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold fs-5 bg-light">
                                    <td colspan="3" class="text-end">Total Général :</td>
                                    <td colspan="3"><span id="total-panier">0</span> FCFA</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-danger" id="btn-vider-panier">
                            <i class="bi bi-trash"></i> Vider le panier
                        </button>
                        <button class="btn btn-success btn-lg px-5" id="btn-valider-commande">
                            <i class="bi bi-check-all"></i> Valider l'Approvisionnement
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Détails Produit -->
<div class="modal fade" id="produitDetailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modal-produit-nom">Détails du Produit</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal-produit-id">
                <div class="alert alert-secondary">
                    <p class="mb-1">Prix d'achat actuel: <strong id="modal-produit-prix">0</strong> FCFA</p>
                    <p class="mb-0">Stock disponible: <strong id="modal-produit-stock">0</strong></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Quantité à commander</label>
                    <input type="number" class="form-control form-control-lg" id="modal-input-qte" min="1" value="1">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Date de péremption</label>
                    <input type="date" class="form-control" id="modal-input-peremption">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="btn-ajouter-depuis-modal">Ajouter au panier</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let panier = JSON.parse(sessionStorage.getItem('panier_appro')) || [];
    let selectedProduit = null;

    // Charger les fournisseurs et restaurer l'état
    $.get('api.php?entity=fournisseur&action=list', function(data) {
        let options = '<option value="">Sélectionner un fournisseur...</option>';
        data.forEach(f => {
            options += `<option value="${f.id_fournisseur}">${f.nom} ${f.prenom}</option>`;
        });
        $('#select-fournisseur').html(options);
        
        // Restaurer le fournisseur si panier non vide
        let savedFournisseur = sessionStorage.getItem('fournisseur_appro');
        if (panier.length > 0 && savedFournisseur) {
            $('#select-fournisseur').val(savedFournisseur).prop('disabled', true);
        }
        renderPanier();
    }, 'json');

    // Sauvegarder le fournisseur quand il change
    $('#select-fournisseur').change(function() {
        sessionStorage.setItem('fournisseur_appro', $(this).val());
    });

    // Recherche dynamique de produits
    $('#search-produit').on('input', function() {
        let query = $(this).val().trim();
        if (query.length < 1) {
            $('#search-results').addClass('d-none');
            return;
        }

        $.get('api.php?entity=produit&action=listWithStock', function(products) {
            let filtered = products.filter(p => p.nom.toLowerCase().includes(query.toLowerCase()));
            let html = '';
            if (filtered.length > 0) {
                filtered.forEach(p => {
                    html += `<a href="#" class="list-group-item list-group-item-action select-item-search" 
                                data-id="${p.id_produit}" 
                                data-nom="${p.nom}" 
                                data-prix="${p.prix_achat}" 
                                data-stock="${p.stock_disponible}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>${p.nom}</span>
                                    <span class="badge bg-info rounded-pill">${p.stock_disponible} en stock</span>
                                </div>
                             </a>`;
                });
                $('#search-results').html(html).removeClass('d-none');
            } else {
                $('#search-results').html('<div class="list-group-item text-muted">Aucun produit trouvé</div>').removeClass('d-none');
            }
        }, 'json');
    });

    // Sélection d'un produit
    $(document).on('click', '.select-item-search', function(e) {
        e.preventDefault();
        if (!$('#select-fournisseur').val()) {
            Swal.fire({
                title: 'Attention',
                text: 'Veuillez d\'abord choisir un fournisseur',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            $('#search-results').addClass('d-none');
            $('#search-produit').val('');
            return;
        }

        selectedProduit = {
            id: $(this).data('id'),
            nom: $(this).data('nom'),
            prix: parseFloat($(this).data('prix')),
            stock: $(this).data('stock')
        };

        $('#modal-produit-nom').text(selectedProduit.nom);
        $('#modal-produit-prix').text(selectedProduit.prix.toLocaleString());
        $('#modal-produit-stock').text(selectedProduit.stock);
        $('#modal-produit-id').val(selectedProduit.id);
        $('#modal-input-qte').val(1);
        
        $('#search-results').addClass('d-none');
        $('#search-produit').val('');
        $('#produitDetailModal').modal('show');
    });

    // Ajouter au panier
    $('#btn-ajouter-depuis-modal').click(function() {
        let qte = parseInt($('#modal-input-qte').val());
        let peremption = $('#modal-input-peremption').val();

        if (isNaN(qte) || qte <= 0) {
            Swal.fire({
                title: 'Erreur',
                text: 'Quantité invalide',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (!selectedProduit) {
            Swal.fire({
                title: 'Erreur',
                text: 'Aucun produit sélectionné',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        panier.push({
            id_produit: selectedProduit.id,
            nom: selectedProduit.nom,
            prix: selectedProduit.prix,
            quantite: qte,
            date_peremption: peremption
        });

        saveAndRender();
        $('#produitDetailModal').modal('hide');
        $('#select-fournisseur').prop('disabled', true);
        
        // Réinitialiser la date de péremption pour le prochain produit
        $('#modal-input-peremption').val('');
    });

    function saveAndRender() {
        sessionStorage.setItem('panier_appro', JSON.stringify(panier));
        renderPanier();
    }

    function renderPanier() {
        let html = '';
        let total = 0;
        
        if (panier.length === 0) {
            html = '<tr><td colspan="6" class="text-center text-muted py-4">Le panier est vide. Recherchez un produit pour commencer.</td></tr>';
            $('#select-fournisseur').prop('disabled', false);
        } else {
            panier.forEach((item, index) => {
                let subtotal = item.prix * item.quantite;
                total += subtotal;
                html += `
                    <tr>
                        <td class="fw-bold">${item.nom}</td>
                        <td>${item.prix.toLocaleString()} FCFA</td>
                        <td>
                            <input type="number" class="form-control form-control-sm update-qte" data-index="${index}" value="${item.quantite}" style="width: 80px;" min="1">
                        </td>
                        <td class="text-primary fw-bold">${subtotal.toLocaleString()} FCFA</td>
                        <td>${item.date_peremption || '<span class="text-muted">N/A</span>'}</td>
                        <td>
                            <button class="btn btn-sm btn-danger remove-item" data-index="${index}"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('#panier-commande tbody').html(html);
        $('#total-panier').text(total.toLocaleString());
    }

    // Vider le panier (sans confirmation)
    $('#btn-vider-panier').click(function() {
        if (panier.length > 0) {
            panier = [];
            sessionStorage.removeItem('panier_appro');
            sessionStorage.removeItem('fournisseur_appro');
            saveAndRender();
        }
    });

    // Modifier quantité
    $(document).on('change', '.update-qte', function() {
        let index = $(this).data('index');
        let newQte = parseInt($(this).val());
        if (newQte > 0) {
            panier[index].quantite = newQte;
            saveAndRender();
        } else {
            Swal.fire({
                title: 'Erreur',
                text: 'La quantité doit être supérieure à 0',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            $(this).val(panier[index].quantite);
        }
    });

    // Supprimer un article (sans confirmation)
    $(document).on('click', '.remove-item', function() {
        let index = $(this).data('index');
        panier.splice(index, 1);
        saveAndRender();
    });

    // Fermer la recherche au clic ailleurs
    $(document).click(function(e) {
        if (!$(e.target).closest('.position-relative').length) {
            $('#search-results').addClass('d-none');
        }
    });

    // Valider la commande finale (sans confirmation)
    $('#btn-valider-commande').click(function() {
        let id_fournisseur = $('#select-fournisseur').val();
        
        if (panier.length === 0) {
            Swal.fire({
                title: 'Oups',
                text: 'Le panier est vide. Ajoutez des produits avant de valider.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        if (!id_fournisseur) {
            Swal.fire({
                title: 'Attention',
                text: 'Veuillez sélectionner un fournisseur',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Afficher un loader
        Swal.fire({
            title: 'Traitement en cours...',
            text: 'Veuillez patienter',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // On s'assure d'avoir la valeur même si le champ est désactivé
        const finalFournisseurId = $('#select-fournisseur').val() || sessionStorage.getItem('fournisseur_appro');

        $.ajax({
            url: 'api.php?entity=commande&action=createAndStock',
            type: 'POST',
            data: { 
                id_fournisseur: finalFournisseurId,
                panier: JSON.stringify(panier)
            },
            dataType: 'json',
            success: function(response) {
                console.log("Réponse serveur :", response);
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Succès !',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Super'
                    }).then((result) => {
                        console.log("Confirmation Swal cliquée, nettoyage...");
                        panier = [];
                        sessionStorage.removeItem('panier_appro');
                        sessionStorage.removeItem('fournisseur_appro');
                        window.location.reload();
                    });
                } else {
                    console.error("Erreur renvoyée par le serveur :", response.message);
                    Swal.fire({
                        title: 'Erreur',
                        text: response.message || 'Une erreur est survenue lors de la validation',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Erreur AJAX critique :");
                console.log("Statut :", status);
                console.log("Erreur :", error);
                console.log("Réponse brute du serveur :", xhr.responseText);
                Swal.fire({
                    title: 'Erreur Critique',
                    text: 'Une erreur serveur est survenue. Veuillez vérifier la console pour plus de détails.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>