<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuer un animal</title>
</head>

<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container mt-5">
        <h1 class="mb-4">Tuer un animal</h1>
        <!-- Formulaire pour nourrir un animal -->
        <form id="animalForm">
            <!-- Sélection de l'animal -->
            <div class="mb-3">
                <label for="animal_id" class="form-label">Sélectionner un animal</label>
                <select class="form-select" id="animal_id" name="animal_id" required>
                    <option value="">Choisir  un animal</option>
                    <?php foreach ($animaux as $animal) : ?>
                        <option value="<?= $animal['id'] ?>"><?= $animal['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Date de nourriture -->
            <div class="mb-3">
                <label for="date_nourriture" class="form-label">Date</label>
                <input type="date" class="form-control" id="date_nourriture" name="date" required>
            </div>
            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary">Tuer</button>
        </form>
        <!-- Zone pour afficher les messages -->
        <div id="message"></div>
    </div>

    <!-- Inclure Bootstrap JS pour les fonctionnalités supplémentaires -->

    <script>
        // Gérer la soumission du formulaire via AJAX
        $('#animalForm').on('submit', function(e) {
            e.preventDefault(); // Empêcher le comportement par défaut du formulaire

            var formData = $(this).serialize(); // Sérialiser les données du formulaire
            console.log(formData);
            $.ajax({
                url: '<?= $base_url ?>/mourrir/tuer', // URL d'action du formulaire
                type: 'POST', // Méthode HTTP
                data: formData, // Données du formulaire
                success: function(response) {
                    // Traiter la réponse serveur
                    var message = response.success ? "<div class='alert alert-success'>" + response.message + "</div>" : "<div class='alert alert-danger'>" + response.message + "</div>";
                    $('#message').html(message); // Afficher le message de succès ou d'erreur
                },
                error: function() {
                    // Gérer les erreurs
                    $('#message').html("<div class='alert alert-danger'>Une erreur s'est produite, veuillez réessayer.</div>");
                }
            });
        });
    </script>
</body>

</html>