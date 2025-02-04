<?php 
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Animaux</title>
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
    .table td:nth-child(3),td:nth-child(2) {
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
</head>
<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-primary">Gestion des Animaux</h1>
            <a href="<?= $base_url ?>/ajouter-animal" class="button" style="background-color: #B22222;">Acheter un animal</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped ">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Espèce</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($animaux as $animal) : ?>
                            <tr>
                                <td><?= htmlspecialchars($animal['nom']) ?></td>
                                <td><?= htmlspecialchars($animal['id_espece']) ?></td>
                                <td>
                                    <a href="<?= $base_url ?>/nourrir?idAnimal=<?= $animal['id'] ?>&nomAnimal=<?= urlencode($animal['nom']) ?>" class="button" style="background-color:#6B8E23">Nourrir</a>
                                    <a href="<?= $base_url ?>/modifier?idAnimal=<?= $animal['id'] ?>&nomAnimal=<?= urlencode($animal['nom']) ?>" class="button" style="background-color:#B22222">Modifier</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>