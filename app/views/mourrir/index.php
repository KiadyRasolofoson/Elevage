<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuer un animal</title>
    <style>
        /* Reset CSS de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .card {
            background-color: #fff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        .card h2 {
            font-size: 2rem;
            color: #e74c3c;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        .d-grid {
            display: grid;
            gap: 1rem;
        }

        .gap-2 {
            gap: 1rem;
        }

        .shadow-lg {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .p-4 {
            padding: 2rem;
        }

        .text-center {
            text-align: center;
        }

        .text-primary {
            color: #007bff;
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card h2 {
                font-size: 1.75rem;
            }

            .form-control,
            .form-select {
                padding: 0.5rem;
                font-size: 0.875rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .card h2 {
                font-size: 1.5rem;
            }

            .form-control,
            .form-select {
                padding: 0.375rem;
                font-size: 0.75rem;
            }

            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container mt-4">
        <div class="card shadow-lg p-4">
            <h2 class="text-center text-primary">Tuer un animal</h2>
            <form id="animalForm" action="<?= $base_url ?>/ajouter-animal" method="POST">

                <div class="mb-3">
                    <label for="id_espece" class="form-label">Espèce</label>
                    <select id="id_espece" name="animal_id" class="form-select" required>
                        <option value="">Sélectionner l'animal</option>
                        <?php foreach ($animaux as $animal) : ?>
                            <option value="<?= $animal['id'] ?>"><?= $animal['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="date_nourriture" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date_nourriture" name="date" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="button" style="background-color: #B22222;">Choissir</button>
                </div>
            </form>
            <div id="message"></div>
        </div>
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
                    var message = response.success ?
                        "<p style='color: green;'>" + response.message + "</p>" // Message vert pour succès
                        :
                        "<p style='color: red;'>" + response.message + "</p>"; // Message rouge pour erreur
                    $('#message').html(message); // Afficher le message de succès ou d'erreur
                    if (response.success) {
                        setTimeout(function() {
                            location.reload(); // Recharge la page
                        }, 1000); // 1 seconde
                    }
                },
                error: function() {
                    // Gérer les erreurs
                    $('#message').html("<p style='color: red;'>Une erreur s'est produite, veuillez réessayer.</p>");
                }
            });
        });
    </script>

</body>

</html>