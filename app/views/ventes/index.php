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

<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container">
        <h1>Vendre</h1>
        <?php if (isset($listeAnimaux) && count($listeAnimaux) > 0) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Nom</td>
                        <td>Espèce</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listeAnimaux as $animal) { ?>
                        <tr id="row-<?php echo $animal['animal_id']; ?>">
                            <td><?php echo htmlspecialchars($animal['animal_id']); ?></td>
                            <td><?php echo htmlspecialchars($animal['animal_name']); ?></td>
                            <td><?php echo htmlspecialchars($animal['espece_name']); ?></td>
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
            <p>Aucun animal disponible à vendre.</p>
        <?php } ?>
    </div>

    <script>
        $(document).ready(function () {
            $(".vendre-btn").click(function () {
                let id_animal = $(this).data("id");
                let button = $(this);
                console.log("<?php echo $base_url; ?>/vente/vendre/" + id_animal);
                $.ajax({
                    url: "<?php echo $base_url; ?>/vente/vendre/" + id_animal,
                    type: "POST",
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            button.replaceWith('<span class="text-muted">Déjà en vente</span>'); // Remplacer le bouton par un texte
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert("Erreur lors de la vente.");
                    }
                });
            });
        });
    </script>
</body>

</html>
