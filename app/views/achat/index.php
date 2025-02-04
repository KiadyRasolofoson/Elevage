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
        <h1>Acheter des animaux</h1>
        <?php if (!empty($achatsDisponibles)) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Vente</th>
                        <th>Date de Vente</th>
                        <th>Prix de Vente</th>
                        <th>Nom de l'Animal</th>
                        <th>Espèce</th>
                        <th>Vendeur</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($achatsDisponibles as $achat) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($achat['id_animal']); ?></td>
                            <td><?php echo htmlspecialchars($achat['date_vente']); ?></td>
                            <td><?php echo htmlspecialchars($achat['prix_vente']); ?> €</td>
                            <td><?php echo htmlspecialchars($achat['nom_animal']); ?></td>
                            <td><?php echo htmlspecialchars($achat['espece']); ?></td>
                            <td><?php echo htmlspecialchars($achat['nom_vendeur']); ?></td>
                            <td>
                                <button class="btn btn-primary acheter-btn" data-id="<?php echo $achat['id_animal']; ?>">Acheter</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aucun achat disponible pour le moment.</p>
        <?php } ?>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Gérer le clic sur le bouton "Acheter"
        $('.acheter-btn').click(function() {
            let id_animal = $(this).data("id");
            let button = $(this);
            $.ajax({
                url: "<?php echo $base_url; ?>/achat/acheter/" + id_animal,
                type: "POST",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        button.replaceWith('<span class="text-muted">Acheter</span>'); // Remplacer le bouton par un texte
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

</html>