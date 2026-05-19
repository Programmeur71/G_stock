<div class="pagetitle">
    <h1>Tableau de bord</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashbord">Accueil</a></li>
            <li class="breadcrumb-item active">Statistiques</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Ventes <span>| En attente</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="stat-ventes-attente">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Chiffre d'Affaires <span>| Total</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="stat-ca">0 FCFA</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Clients <span>| Inscrits</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="stat-clients">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body pb-0">
                    <h5 class="card-title">Top Produits <span>| Quantité vendue</span></h5>
                    <div id="topProductsChart" style="min-height: 300px;" class="echart"></div>
                </div>
            </div>
        </div>

        <!-- Recent Sales -->
        <div class="col-lg-6">
            <div class="card recent-sales overflow-auto">
                <div class="card-body">
                    <h5 class="card-title">Ventes Récentes</h5>
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Client</th>
                                <th scope="col">Total</th>
                                <th scope="col">Statut</th>
                            </tr>
                        </thead>
                        <tbody id="recent-sales-body">
                            <!-- Items via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Daily Sales Chart -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ventes Quotidiennes <span>| Mois en cours</span></h5>
                    <div id="dailySalesChart" style="min-height: 400px;" class="echart"></div>
                </div>
            </div>
        </div>

        <!-- Monthly Sales Chart -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ventes Mensuelles <span>| Année en cours</span></h5>
                    <div id="monthlySalesChart" style="min-height: 400px;" class="echart"></div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
$(document).ready(function() {
    $.get('api.php?entity=dashboard&action=getStats', function(stats) {
        // ... (Reste du code JS)
        $('#stat-ventes-attente').text(stats.ventes_attente);
        $('#stat-ca').text(parseFloat(stats.ca_total).toLocaleString() + ' FCFA');
        $('#stat-clients').text(stats.total_clients);

        let rows = '';
        stats.recent_sales.forEach(v => {
            let badge = v.statut === 'Livré' ? 'bg-success' : 'bg-warning';
            rows += `<tr>
                <th scope="row">#${v.id_vente}</th>
                <td>${v.client_nom || 'Passager'}</td>
                <td class="fw-bold">${parseFloat(v.total).toLocaleString()} FCFA</td>
                <td><span class="badge ${badge}">${v.statut}</span></td>
            </tr>`;
        });
        $('#recent-sales-body').html(rows);

        if (typeof echarts !== 'undefined') {
            // 1. Top Produits Chart
            var topChart = echarts.init(document.querySelector("#topProductsChart"));
            topChart.setOption({
                tooltip: { trigger: 'item' },
                series: [{
                    name: 'Vendu',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    data: stats.top_products.map(p => ({ value: p.total_vendu, name: p.nom }))
                }]
            });

            // 2. Daily Sales Chart (Courbe)
            var dailyChart = echarts.init(document.querySelector("#dailySalesChart"));
            let days = stats.sales_daily.map(d => 'Jour ' + d.jour);
            let dayTotals = stats.sales_daily.map(d => d.total);
            
            dailyChart.setOption({
                xAxis: { type: 'category', data: days },
                yAxis: { type: 'value' },
                tooltip: { trigger: 'axis' },
                series: [{
                    data: dayTotals,
                    type: 'line',
                    smooth: true,
                    areaStyle: { opacity: 0.1 },
                    itemStyle: { color: '#4154f1' }
                }]
            });

            // 3. Monthly Sales Chart (Histogramme)
            var monthlyChart = echarts.init(document.querySelector("#monthlySalesChart"));
            const monthNames = ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun", "Jul", "Août", "Sep", "Oct", "Nov", "Déc"];
            let months = stats.sales_monthly.map(m => monthNames[m.mois - 1]);
            let monthTotals = stats.sales_monthly.map(m => m.total);

            monthlyChart.setOption({
                xAxis: { type: 'category', data: months },
                yAxis: { type: 'value' },
                tooltip: { trigger: 'axis' },
                series: [{
                    data: monthTotals,
                    type: 'bar',
                    itemStyle: { color: '#2eca6a' }
                }]
            });
        }
    }, 'json');
});
</script>