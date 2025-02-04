<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alimentation</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/styles.css"> <!-- Lien vers votre fichier CSS -->
</head>

<body>
    <style>
        /* styles.css */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        form div {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container">
        <h1>Nourriture</h1>

        <!-- Formulaire d'ajout d'alimentation -->
        <h2>Acheter un nourriture</h2>
        <form action="<?php echo $base_url; ?>/achat/nourriture" method="POST">
            <div>
                <label for="nom">Aliment</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div>
                <label for="pourcentage_gain">Quantiter en kg </label>
                <input type="number" id="pourcentage_gain" name="pourcentage_gain" step="0.01" required>
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>

</html>