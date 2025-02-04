<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vente</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Import de jQuery -->
</head>
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    h1.text-primary {
        color: #B22222;
        font-size: 2.5rem;
        margin-bottom: 0;
    }

    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        border-radius: 0.25rem;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #000;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .card {
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-body {
        padding: 1.25rem;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-collapse: collapse;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table-dark {
        background-color: #343a40;
        color: #fff;
    }

    .table-dark th {
        border-color: #454d55;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        /* Centrer le contenu des cellules */
         text-align: center;
    }

    .table td:nth-child(3),
    td:nth-child(2) {
        text-align: center;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    .mt-4 {
        margin-top: 1.5rem !important;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    .d-flex {
        display: flex !important;
    }

    .justify-content-between {
        justify-content: space-between !important;
    }

    .align-items-center {
        align-items: center !important;
    }
</style>

<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-primary">Liste des Ventes disponible</h1>
            <div class="flex">
                </div>
        </div>
        <?php if (isset($listeAnimaux) && count($listeAnimaux) > 0) { ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Espèce</th>
                            <th>Poids actuel</th>
                            <th>Auto vente</th>
                            <th>Date de vente</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($listeAnimaux as $animal) { ?>
                            <tr id="row-<?php echo $animal['animal_id']; ?>">
                                <td><?php echo htmlspecialchars($animal['animal_id']); ?></td>
                                <td><?php echo htmlspecialchars($animal['animal_name']); ?></td>
                                <td><?php echo htmlspecialchars($animal['poids_actuel']); ?></td>
                                <td><?php echo htmlspecialchars($animal['poids_minimal_vente']); ?> kg</td>
                                <?php if ($animal['auto_vente'] == 0) { ?>
                                    <td>False</td>
                                <?php } else { ?>
                                    <td>True</td>
                                <?php
                                } ?>
                                <td>
                                    <input type="date" name="date">
                                </td>
                                <td>
                                    <button class="vendre-btn button" data-id="<?php echo $animal['animal_id']; ?>" style="background-color:#6B8E23">Vendre</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                    <p>Aucun animal disponible à vendre.</p>
                <?php } ?>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $(".vendre-btn").click(function() {
                let id_animal = $(this).data("id");
                let button = $(this);
                let dateVente = button.closest("tr").find("input[name='date']").val(); // Récupérer la date

                if (!dateVente) {
                    alert("Veuillez sélectionner une date de vente.");
                    return;
                }

                $.ajax({
                    url: "<?php echo $base_url; ?>/vente/vendre/" + id_animal,
                    type: "POST",
                    data: {
                        date_vente: dateVente
                    }, // Envoyer la date en POST
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            button.replaceWith('<span class="text-muted">Vendu</span>'); // Remplacer le bouton par un texte
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert("Erreur lors de la vente.");
                    }
                });
            });
        });
    </script>
</body>

</html>