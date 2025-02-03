<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Animal</title>
</head>
<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container mt-4">
        <div class="card shadow-lg p-4">
            <h2 class="text-center text-primary">Ajouter un Animal</h2>
            <form action="<?= $base_url ?>/ajouter-animal" method="POST">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de l'Animal</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_espece" class="form-label">Espèce</label>
                    <select id="id_espece" name="id_espece" class="form-select" required>
                        <option value="">Sélectionner une espèce</option>
                        <?php foreach ($especes as $espece) : ?>
                            <option value="<?= $espece['id'] ?>"><?= htmlspecialchars($espece['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                 <div class="mb-3">
                    <label for="poids" class="form-label">Poids initial</label>
                    <input type="number" id="poids" name="poids" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Ajouter</button>
                    <a href="<?= $base_url ?>/ajouter-animal" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
