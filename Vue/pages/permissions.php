<div class="pagetitle">
    <h1>Liste des Permissions</h1>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Permissions du système</h5>
            <table class="table table-striped datatable" id="permissionTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Désignation</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    loadPermissions();
});

function loadPermissions() {
    $.get('api.php?entity=permission&action=list', function(data) {
        if ($.fn.DataTable.isDataTable('#permissionTable')) {
            $('#permissionTable').DataTable().destroy();
        }
        let rows = '';
        data.forEach(p => {
            rows += `<tr><td>${p.id_permission}</td><td>${p.designation}</td></tr>`;
        });
        $('#permissionTable tbody').html(rows);
        $('#permissionTable').DataTable({
            responsive: true,
            language: datatable_fr
        });
    });
}
</script>
