<?php 
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Animaux</title>
</head>
<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-primary">Gestion des Animaux</h1>
            <a href="<?= $base_url ?>/ajouter-animal" class="btn btn-success">Ajouter un Animal</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Espèce</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($animaux as $animal) : ?>
                            <tr>
                                <td><?= htmlspecialchars($animal['nom']) ?></td>
                                <td><?= htmlspecialchars($animal['id_espece']) ?></td>
                                <td>
                                    <a href="<?= $base_url ?>/nourrir-animal/idAnimal<?= $animal['id'] ?>" class="btn btn-warning btn-sm">Nourrir</a>
                                   
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