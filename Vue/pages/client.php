<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#clientModal" onclick="resetForm()">Ajouter Client</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="clientTable">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="clientModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="clientForm">
                <input type="hidden" name="id_client" id="id_client">
                <div class="modal-header"><h5 class="modal-title">Client</h5></div>
                <div class="modal-body">
                    <input type="text" name="nom" id="nom" class="form-control mb-2" placeholder="Nom" required>
                    <input type="text" name="prenom" id="prenom" class="form-control mb-2" placeholder="Prénom" required>
                    <input type="text" name="adresse" id="adresse" class="form-control mb-2" placeholder="Adresse">
                    <input type="email" name="email" id="email" class="form-control mb-2" placeholder="Email">
                    <input type="text" name="telephone" id="telephone" class="form-control mb-2" placeholder="Téléphone">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadClients();

    $('#clientForm').submit(function(e) {
        e.preventDefault();
        $.post('api.php?entity=client&action=save', $(this).serialize(), function() {
            $('#clientModal').modal('hide');
            loadClients();
        });
    });
});

function loadClients() {
    $.get('api.php?entity=client&action=list', function(data) {
        let rows = '';
        data.forEach(c => {
            rows += `<tr>
                <td>${c.nom}</td><td>${c.prenom}</td><td>${c.email}</td><td>${c.telephone}</td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="editClient(${JSON.stringify(c).replace(/"/g, '&quot;')})">Editer</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteClient(${c.id_client})">Supprimer</button>
                </td>
            </tr>`;
        });
        $('#clientTable tbody').html(rows);
    });
}

function editClient(c) {
    $('#id_client').val(c.id_client);
    $('#nom').val(c.nom);
    $('#prenom').val(c.prenom);
    $('#email').val(c.email);
    $('#telephone').val(c.telephone);
    $('#adresse').val(c.adresse);
    $('#clientModal').modal('show');
}

function deleteClient(id) {
    if(confirm('Supprimer ce client ?')) {
        $.post('api.php?entity=client&action=delete', {id_client: id}, loadClients);
    }
}

function resetForm() { $('#clientForm')[0].reset(); $('#id_client').val(''); }
</script>
