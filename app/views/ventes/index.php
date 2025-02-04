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
    <div class="container">
        <br>
        <h1>Vendre</h1>
        <br>
        <?php if (isset($listeAnimaux) && count($listeAnimaux) > 0) { ?>
            <table class="table table-striped table-bordered">
                <thead table-dark>
                    <tr>
                        <td>Id</td>
                        <td>Nom</td>
                        <td>Espèce</td>
                        <td>Poids Minimal</td>
                        <td>Poids Actuel</td>
                        <td>Date</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listeAnimaux as $animal) { ?>
                        <tr id="row-<?php echo $animal['animal_id']; ?>">
                            <td><?php echo htmlspecialchars($animal['animal_id']); ?></td>
                            <td><?php echo htmlspecialchars($animal['animal_name']); ?></td>
                            <td><?php echo htmlspecialchars($animal['espece_name']); ?></td>
                            <td><?php echo htmlspecialchars($animal['poids_minimal_vente']); ?> kg</td>
                            <td><?php echo htmlspecialchars($animal['poids_actuel']) ? htmlspecialchars($animal['poids_actuel']) . ' kg' : 'Non disponible'; ?></td>
                            <td>
                                <input type="date" name="date">
                            </td>
                            <td>
                                <button class="vendre-btn" data-id="<?php echo $animal['animal_id']; ?>">Vendre</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aucun animal disponible à vendre.</p>
        <?php } ?>
    </div>
    <script>
        $(document).ready(function() {
            $(".vendre-btn").click(function() {
                let id_animal = $(this).data("id");
                let button = $(this);
                $.ajax({
                    url: "<?php echo $base_url; ?>/vente/vendre/" + id_animal,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            button.replaceWith('<span class="text-muted">Vendu</span>'); // Remplacer le bouton par un texte
                            alert(response.message + " , prix de vente = " + response.prix_vente);
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