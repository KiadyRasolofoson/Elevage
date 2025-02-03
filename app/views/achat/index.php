<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Import de jQuery -->
</head>

<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container">
        <h1>Achat</h1>
        <?php if (isset($listeAnimaux) && count($listeAnimaux) > 0) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Nom</td>
                        <td>Espèce</td>
                        <td>Poids Minimal</td>
                        <td>Poids Actuel</td>
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
                                <?php if ($animal['deja_dans_ventes'] != "Oui") { ?>
                                    <button class="btn btn-primary vendre-btn" data-id="<?php echo $animal['animal_id']; ?>">Vendre</button>
                                <?php } else { ?>
                                    <span class="text-muted">Déjà en vente</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aucun animal disponible à acheter.</p>
        <?php } ?>
    </div>
</body>

</html>