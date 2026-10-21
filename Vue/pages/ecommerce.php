<div class="pagetitle">
    <h1>Boutique en ligne</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="ecommerce">Accueil</a></li>
            <li class="breadcrumb-item active">Boutique</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row" id="products-list">
        <!-- Products will be loaded here via AJAX -->
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    let cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    updateCartDisplay();

    function loadProducts() {
        $.ajax({
            url: 'api.php?entity=produit&action=listWithStock',
            type: 'GET',
            dataType: 'json',
            success: function(products) {
                let html = '';
                // Filtrer pour n'afficher que les produits en stock
                let inStockProducts = products.filter(p => p.stock_disponible > 0);
                
                if (inStockProducts.length === 0) {
                    $('#products-list').html('<div class="col-12 text-center p-5"><i class="bi bi-box-seam fs-1 text-muted"></i><p class="mt-3">Aucun produit n\'est disponible en stock pour le moment.</p></div>');
                    return;
                }

                inStockProducts.forEach(product => {
                    let photoHtml = product.photo 
                        ? `<img src="assets/img/products/${product.photo}" class="card-img-top h-100 w-100" style="object-fit: cover;" alt="${product.nom}">`
                        : `<div class="h-100 w-100 d-flex align-items-center justify-content-center bg-light text-secondary"><i class="bi bi-box-seam fs-1"></i></div>`;
                    
                    html += `
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div style="height: 200px; overflow: hidden;">
                                    ${photoHtml}
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1">${product.nom}</h5>
                                    <p class="card-text text-muted small mb-3">Disponible : <span class="badge bg-success">${product.stock_disponible}</span></p>
                                    <p class="fw-bold text-primary fs-5 mt-auto mb-3">${parseFloat(product.prix_vente).toLocaleString()} FCFA</p>
                                    <button class="btn btn-primary w-100 add-to-cart" 
                                            data-id="${product.id_produit}" 
                                            data-name="${product.nom}" 
                                            data-price="${product.prix_vente}"
                                            data-stock="${product.stock_disponible}">
                                        <i class="bi bi-cart-plus"></i> Commander
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#products-list').html(html);
            }
        });
    }

    loadProducts();

    $(document).on('click', '.add-to-cart', function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let price = parseFloat($(this).data('price'));
        let stock = parseInt($(this).data('stock'));

        Swal.fire({
            title: 'Quantité pour ' + name,
            text: 'Stock disponible : ' + stock,
            input: 'number',
            inputAttributes: {
                min: 1,
                max: stock,
                step: 1
            },
            inputValue: 1,
            showCancelButton: true,
            confirmButtonText: 'Ajouter',
            cancelButtonText: 'Annuler',
            inputValidator: (value) => {
                if (!value || value < 1) {
                    return 'Veuillez entrer une quantité valide';
                }
                if (value > stock) {
                    return 'La quantité dépasse le stock disponible';
                }
            }
        }).then((result) => {
            if (result.value) {
                let quantity = parseInt(result.value);
                let item = cart.find(i => i.id === id);
                
                if (item) {
                    if ((item.quantity + quantity) <= stock) {
                        item.quantity += quantity;
                    } else {
                        item.quantity = stock;
                        Swal.fire('Information', 'Quantité ajustée au maximum du stock disponible', 'info');
                    }
                } else {
                    cart.push({ id, name, price, quantity: quantity, stock });
                }

                sessionStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
                
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'success',
                    title: quantity + ' x ' + name + ' ajouté(s) au panier'
                });
            }
        });
    });

    function updateCartDisplay() {
        let count = cart.reduce((sum, item) => sum + item.quantity, 0);
        $('.cart-count').text(count);

        let html = '';
        let total = 0;
        if (cart.length === 0) {
            html = '<li class="p-3 text-center text-muted">Votre panier est vide</li>';
        } else {
            cart.forEach(item => {
                total += item.price * item.quantity;
                html += `
                    <li class="notification-item">
                        <div class="w-100">
                            <div class="d-flex justify-content-between">
                                <h6>${item.name}</h6>
                                <span class="text-primary fw-bold">${(item.price * item.quantity).toLocaleString()} FCFA</span>
                            </div>
                            <p class="small mb-0">Quantité : ${item.quantity} x ${item.price.toLocaleString()}</p>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                `;
            });
            html += `
                <li class="p-2">
                    <div class="d-flex justify-content-between fw-bold px-2">
                        <span>Total :</span>
                        <span class="text-success">${total.toLocaleString()} FCFA</span>
                    </div>
                </li>
            `;
        }
        $('#cart-items-list').html(html);
    }

    $('.clear-cart').click(function(e) {
        e.preventDefault();
        cart = [];
        sessionStorage.setItem('cart', JSON.stringify(cart));
        updateCartDisplay();
    });

    $('.checkout-btn').click(function() {
        if (cart.length === 0) {
            Swal.fire('Oups', 'Votre panier est vide', 'info');
            return;
        }

        // Appel direct sans confirmation supplémentaire comme demandé
        $.ajax({
            url: 'api.php?entity=vente&action=createFromCart',
            type: 'POST',
            data: { cart: JSON.stringify(cart) },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Succès', response.message, 'success').then(() => {
                        cart = [];
                        sessionStorage.setItem('cart', JSON.stringify(cart));
                        window.location.href = 'Historique';
                    });
                } else {
                    Swal.fire('Erreur', response.message, 'error');
                }
            }
        });
    });
});
</script>