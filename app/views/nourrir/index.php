<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nourrir un animal</title>
    <!-- Inclure Bootstrap CSS pour le style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container mt-5">
        <h1 class="mb-4">Nourrir un animal</h1>

        <!-- Formulaire pour nourrir un animal -->
        <form action="<?= $base_url ?>/nourrir" method="POST">
            <!-- Sélection de l'animal -->
            <div class="mb-3">
                <label for="animal_id" class="form-label">Sélectionner un animal</label>
                <select class="form-select" id="animal_id" name="animal_id" required>
                    <option value="">Choisir un animal</option>
                    <?php foreach ($animals as $animal) : ?>
                        <option value="<?= $animal['id'] ?>"><?= $animal['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Sélection de l'alimentation -->
            <div class="mb-3">
                <label for="alimentation_id" class="form-label">Sélectionner un aliment</label>
                <select class="form-select" id="alimentation_id" name="alimentation_id" required>
                    <option value="">Choisir un aliment</option>
                    <?php foreach ($alimentations as $alimentation) : ?>
                        <option value="<?= $alimentation['id'] ?>"><?= $alimentation['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date de nourriture -->
            <div class="mb-3">
                <label for="date_nourriture" class="form-label">Date de nourriture</label>
                <input type="date" class="form-control" id="date_nourriture" name="date_nourriture" required>
            </div>

            <!-- Quantité de nourriture donnée -->
            <div class="mb-3">
                <label for="quantite_nourriture" class="form-label">Quantité de nourriture (en kg)</label>
                <input type="number" class="form-control" id="quantite_nourriture" name="quantite_nourriture" step="0.01" min="0" required>
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary">Nourrir l'animal</button>
        </form>
    </div>

    <!-- Inclure Bootstrap JS pour les fonctionnalités supplémentaires -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>