<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acheter nourriture</title>
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
            <h2 class="text-center text-primary">Acheter nourriture</h2>
            <form id="achat-form">
                <div class="mb-3">
                    <label for="id_alim" class="form-label">Alimentation</label>
                    <select id="id_alim" name="id_alim" class="form-select" required>
                        <option value="">Sélectionner une alimentation</option>
                        <?php foreach ($alimentations as $l) : ?>
                            <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input type="number" id="quantite" name="quantiter" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Acheter</button>
                </div>
            </form>
            <div id="message" class="mt-3 text-center"></div>
        </div>
        
    </div>

    <script>
        document.getElementById('achat-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche la soumission classique du formulaire

            let formData = new FormData(this);

            fetch('<?= $base_url ?>/achat/nourriture', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json()) // Conversion en JSON
                .then(data => {
                    let messageDiv = document.getElementById('message');
                    if (data.success) {
                        
                        messageDiv.innerHTML = `<br><p style="color: green;">${data.message}</p>`;
                    } else {
                        messageDiv.innerHTML = `<br><p style="color: red;">${data.message}</p>`;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('message').innerHTML = `<p style="color: red;">Erreur lors de l'achat.</p>`;
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>