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
                products.forEach(product => {
                    let inStock = product.stock_disponible > 0;
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
                                    <p class="card-text text-muted small mb-3">Stock : <span class="badge ${inStock ? 'bg-success' : 'bg-danger'}">${product.stock_disponible}</span></p>
                                    <p class="fw-bold text-primary fs-5 mt-auto mb-3">${parseFloat(product.prix_vente).toLocaleString()} FCFA</p>
                                    <button class="btn ${inStock ? 'btn-primary' : 'btn-secondary disabled'} w-100 add-to-cart" 
                                            data-id="${product.id_produit}" 
                                            data-name="${product.nom}" 
                                            data-price="${product.prix_vente}"
                                            data-stock="${product.stock_disponible}"
                                            ${!inStock ? 'disabled' : ''}>
                                        <i class="bi bi-cart-plus"></i> ${inStock ? 'Ajouter au panier' : 'Rupture de stock'}
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

        let item = cart.find(i => i.id === id);
        if (item) {
            if (item.quantity < stock) {
                item.quantity++;
            } else {
                Swal.fire('Erreur', 'Quantité maximale en stock atteinte', 'warning');
                return;
            }
        } else {
            cart.push({ id, name, price, quantity: 1, stock });
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
            title: name + ' ajouté au panier'
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

        Swal.fire({
            title: 'Confirmer la commande ?',
            text: "Votre commande sera enregistrée et en attente de validation.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Oui, commander',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
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
            }
        });
    });
});
</script>