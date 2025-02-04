<?php
$base_url = Flight::app()->get('flight.base_url');

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= $base_url; ?>/public/assets/css/dash.css" />
</head>
<body>
<?php include('app/views/layout/header.php'); ?>
<?php $title = 'Tableau de Bord'; ?>

<div class="container">
    <div class="dashboard-header">
        <h1>Tableau de Bord</h1>
        <input type="date" value="<?= $date ?>" id="dateSelector" class="date-input">
        <br><br><br>
    </div>
    <br><br>
    <div class="statistics-grid">
        <div class="stat-card">
            <h3>Vue d'ensemble</h3>
            <div class="stat-content">
                <p>Animaux total: <?= $statistics['total_animals'] ?></p>
                <h4>Par espèce:</h4>
                <ul>
                    <?php foreach ($statistics['animals_by_species'] as $species): ?>
                        <li><?= $species['nom'] ?>: <?= $species['count'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="stat-card">
            <h3>Ventes</h3>
            <div class="stat-content">
                <p>Ventes totales: <?= $statistics['sales_data']['total_sales'] ?></p>
                <p>Revenu total: <?= isset($statistics['sales_data']['total_revenue']) ? number_format($statistics['sales_data']['total_revenue'], 2) : 'N/A' ?> €</p>
                <p>Prix moyen: <?= isset($statistics['sales_data']['average_sale_price']) ? number_format($statistics['sales_data']['average_sale_price'], 2) : 'N/A' ?> €</p>
            </div>
        </div>

        <div class="stat-card">
            <h3>Consommation d'aliments</h3>
            <div class="stat-content">
                <?php foreach ($statistics['food_consumption'] as $food): ?>
                    <div class="food-stat">
                        <p><?= $food['nom'] ?>:</p>
                        <p>Consommé: <?= $food['total_consumed'] ?> kg</p>
                        <p>Animaux nourris: <?= $food['animals_fed'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="stat-card">
            <h3>Mortalité</h3>
            <div class="stat-content">
                <?php foreach ($statistics['deaths'] as $death): ?>
                    <div class="death-stat">
                        <p><?= $death['species'] ?>:</p>
                        <p>Morts: <?= $death['death_count'] ?></p>
                        <p>Durée de vie moyenne: <?= round($death['avg_lifespan']) ?> jours</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="stat-card">
            <h3>Résultats Financiers</h3>
            <div class="stat-content">
                <p>Revenus: <?= number_format($statistics['profit_loss']['total_revenue'], 2) ?> €</p>
                <p>Coûts: <?= number_format($statistics['profit_loss']['total_costs'], 2) ?> €</p>
                <p class="<?= $statistics['profit_loss']['net_profit'] >= 0 ? 'profit' : 'loss' ?>">
                    Bénéfice net: <?= number_format($statistics['profit_loss']['net_profit'], 2) ?> €
                </p>
            </div>
        </div>
    </div>

    <div class="animals-grid">
        <?php foreach ($animals as $animal): ?>
            <div class="animal-card">
                <div class="animal-image">
                    <img src="<?= $animal['photo'] ?? '/assets/images/default-animal.jpg' ?>" 
                         alt="<?= htmlspecialchars($animal['nom']) ?>">
                </div>
                <div class="animal-info">
                    <h3><?= htmlspecialchars($animal['nom']) ?></h3>
                    <p class="animal-species"><?= htmlspecialchars($animal['espece_nom']) ?></p>
                    <div class="animal-details">
                        <p>Poids actuel: <?= $animal['poids'] ?? 'N/A' ?> kg</p>
                        <p>Poids minimal de vente: <?= $animal['poids_minimal_vente'] ?> kg</p>
                        <p>Vente auto: <?= $animal['auto_vente'] ? 'Oui' : 'Non' ?></p>
                        <?php if ($animal['date_mort']): ?>
                            <p class="animal-death">Mort le: <?= $animal['date_mort'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
    <?php include('app/views/layout/footer.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Date selector handling
    const dateSelector = document.getElementById('dateSelector');
    if (dateSelector) {
        dateSelector.addEventListener('change', function(e) {
            fetch(`/?date=${e.target.value}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = document.querySelector('.animals-grid');
                    document.querySelector('.animals-grid').innerHTML = newContent.innerHTML;
                })
                .catch(error => console.error('Error:', error));
        });
    }

    // Capital modal handling
    const updateCapitalBtn = document.getElementById('updateCapital');
    const capitalModal = document.getElementById('capitalModal');
    const capitalForm = document.getElementById('capitalForm');

    if (updateCapitalBtn && capitalModal) {
        updateCapitalBtn.addEventListener('click', function() {
            capitalModal.style.display = 'flex';
        });

        capitalModal.addEventListener('click', function(e) {
            if (e.target === capitalModal) {
                capitalModal.style.display = 'none';
            }
        });

        if (capitalForm) {
            capitalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const amount = document.getElementById('amount').value;

                fetch('/transactions/update-capital', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ amount }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        }
    }
});
    </script>
</body>
</html>