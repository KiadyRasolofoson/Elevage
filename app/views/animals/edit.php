<?php 
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des especes</title>
    <style>
        .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    h1.text-primary {
        color: #B22222;
        font-size: 2.5rem;
        margin-bottom: 0;
    }

    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        border-radius: 0.25rem;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-success {
        background-color: #28a745;
        color: #fff;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #000;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .card {
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-body {
        padding: 1.25rem;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-collapse: collapse;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table-dark {
        background-color: #343a40;
        color: #fff;
    }

    .table-dark th {
        border-color: #454d55;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
         /* Centrer le contenu des cellules */
    }
    .table td:nth-child(3),td:nth-child(2),td:nth-child(4),td:nth-child(5),td:nth-child(6),td:nth-child(7) {
        text-align: center;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    .mt-4 {
        margin-top: 1.5rem !important;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    .d-flex {
        display: flex !important;
    }

    .justify-content-between {
        justify-content: space-between !important;
    }

    .align-items-center {
        align-items: center !important;
    }
    .table td {
        cursor: pointer; /* Curseur pour indiquer que c'est éditable */
    }

    .table td.editable {
        background-color: #ffffcc; /* Jaune clair pour indiquer l'édition */
        outline: 2px solid #ffa500; /* Contour orange pour visibilité */
    }

    .table td input {
    width: 100%;
    border: 2px solid transparent; /* Bordure rouge foncé */
    border-radius: 5px; /* Bords arrondis */
    padding: 5px; /* Espace interne */
    background: transparent; /* Blanc cassé */
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
    outline: none; /* Supprime le contour par défaut */
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); /* Ombre légère */
    transition: all 0.2s ease-in-out;
    border: 2px solid #B22222; /* Rouge caractéristique */
  background-color: #fffaf0; 
}

/* Effet au focus */
.table td input:focus {
    border-color: #ff8c00; /* Bordure orange foncé */
    box-shadow: 0 0 8px rgba(255, 140, 0, 0.7); /* Lumière orange */
    background: #fff; /* Fond blanc pur */
}
/* Icône crayon au survol */
.table tbody td {
  position: relative;
  transition: all 0.2s ease;
}

.table tbody td:hover::after {
  content: '✎';
  position: absolute;
  right: 8px;
  top: 50%;
  transform: translateY(-50%);
  color: #B22222;
  font-size: 16px;
  pointer-events: none;
}

/* Message d'instruction */
.edit-instruction {
  margin-top: 1rem;
  padding: 0.5rem;
  background-color: #f8f9fa;
  border-radius: 4px;
  text-align: center;
  font-size: 0.9em;
  color: #666;
  border: 1px solid #dee2e6;
}

.table td input:focus {
  border-color: #ff8c00; /* Orange foncé */
  box-shadow: 0 0 8px rgba(178, 34, 34, 0.3); /* Ombre rouge */
}
    </style>
</head>
<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-primary">Gestion des Especes</h1>
            <div class="flex">
                <a href="<?= $base_url ?>/animal" class="button" style="background-color: #B22222;">Retour</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped ">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Poids minimal vente</th>
                            <th>Poids maximal</th>
                            <th>Jours sans manger</th>
                            <th>Perte poids par jour</th>
                            <th>Prix (Ar/kg)</th>
                            <th>Quota ration Journalier</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($especes as $espece) : ?>
                            <tr>
                                <td class="nom"><?= htmlspecialchars($espece['nom']) ?></td>
                                <td><?= htmlspecialchars($espece['poids_minimal_vente']) ?></td>
                                <td><?= htmlspecialchars($espece['poids_maximal']) ?></td>
                                <td><?= htmlspecialchars($espece['jours_sans_manger']) ?></td>
                                <td><?= htmlspecialchars($espece['perte_poids_par_jour']) ?></td>
                                <td><?= htmlspecialchars($espece['prix_kg']) ?> </td>
                                <td><?= htmlspecialchars($espece['quota_nourriture_journalier']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                        </table>
            </div>
            </div>
<div class="edit-instruction">
  Cliquez sur les éléments pour les modifier et appuyez sur Entrée pour confirmer
</div>
</div>
        </div>
    </div>
    <?php include('app/views/layout/footer.php'); ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let tableCells = document.querySelectorAll(".table td");

        tableCells.forEach(cell => {
            cell.addEventListener("click", function () {
                // Vérifie si une autre cellule est déjà en mode édition
                let activeCell = document.querySelector(".editable");
                if (activeCell && activeCell !== this) {
                    saveCell(activeCell);
                }

                // Active l'édition pour la cellule cliquée
                this.classList.add("editable");
                let oldValue = this.innerText;
                let input = document.createElement("input");
                if (this.classList.contains("nom")){
                     input.type = "text";
                }else{
                     input.type = "number";
                }
               
                input.value = oldValue;
                input.style.width = "100%";
                input.style.border = "none";
                input.style.background = "transparent";
                input.style.textAlign = "center";
                
                this.innerHTML = "";
                this.appendChild(input);
                input.focus();
                input.addEventListener("keypress", function (event) {
                    if (event.key === "Enter") {
                        saveCell(cell);
                    }
                });
            });
        });

        function saveCell(cell) {
            let input = cell.querySelector("input");
            if (input) {
                let newValue = input.value;
                cell.innerText = newValue; 
                cell.classList.remove("editable"); 

               
                let row = cell.parentElement;
                let nom = row.querySelector(".nom").innerText; 
                let columnIndex = cell.cellIndex; 

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "<?= $base_url ?>/update-espece", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log("Données mises à jour avec succès");
                    }
                };
                console.log(encodeURIComponent(newValue));
                xhr.send("nom=" + encodeURIComponent(nom) + "&columnIndex=" + columnIndex + "&newValue=" + encodeURIComponent(newValue));
            }
        }
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>