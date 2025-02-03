<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achats Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include('app/views/layout/header.php'); ?>
    <div class="container">
        <h1>Achater des animaux</h1>
        <?php if (!empty($achatsDisponibles)) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Vente</th>
                        <th>Date de Vente</th>
                        <th>Prix de Vente</th>
                        <th>Nom de l'Animal</th>
                        <th>Espèce</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($achatsDisponibles as $achat) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($achat['id_vente']); ?></td>
                            <td><?php echo htmlspecialchars($achat['date_vente']); ?></td>
                            <td><?php echo htmlspecialchars($achat['prix_vente']); ?> €</td>
                            <td><?php echo htmlspecialchars($achat['nom_animal']); ?></td>
                            <td><?php echo htmlspecialchars($achat['espece']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aucun achat disponible pour le moment.</p>
        <?php } ?>
    </div>
</body>

</html>