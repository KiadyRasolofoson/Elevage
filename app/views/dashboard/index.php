<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Dashboard</title>
</head>

<body>

<?php
// Données du tableau de bord
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$farm = ['capital' => 50000.00];
$totalIncome = 12000.50;
$totalExpenses = 4500.75;

// Données des transactions
$transactions = [
    ['date' => '2024-03-15', 'description' => 'Organic Fertilizer Purchase', 'amount' => -450.00],
    ['date' => '2024-03-14', 'description' => 'Tomato Harvest Sale', 'amount' => 1200.00],
    ['date' => '2024-03-12', 'description' => 'Equipment Maintenance', 'amount' => -230.50],
];

// Données des cultures
$crops = [
    ['name' => 'Tomatoes', 'health' => 'Good', 'growth' => 75],
    ['name' => 'Wheat', 'health' => 'Average', 'growth' => 45],
    ['name' => 'Lettuce', 'health' => 'Excellent', 'growth' => 90],
];
?>
<?php include('app/views/layout/header.php'); ?>

<main class="container mx-auto px-4 py-8">
    <div class="space-y-8">
        <!-- En-tête avec sélecteur de date -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Farm Dashboard</h1>
            <div class="flex items-center space-x-4">
                <i data-lucide="calendar" class="h-5 w-5 text-gray-500"></i>
                <input
                    type="date"
                    value="<?php echo $selectedDate; ?>"
                    onchange="window.location.href='?date=' + this.value"
                    class="border rounded-md px-3 py-2"
                    min="2025-02-03"
                />
            </div>
        </div>

        <!-- Grille principale -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Statut financier -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-700">Financial Status</h2>
                    <i data-lucide="trending-up" class="h-6 w-6 text-green-500"></i>
                </div>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Current Capital</p>
                        <p class="text-2xl font-bold text-gray-900">€<?= number_format($farm['capital'], 2) ?></p>
                    </div>
                    <div class="flex justify-between text-sm">
                        <div>
                            <p class="text-gray-500">Total Income</p>
                            <p class="text-green-600">+€<?= number_format($totalIncome, 2) ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500">Total Expenses</p>
                            <p class="text-red-600">-€<?= number_format($totalExpenses, 2) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dernières transactions -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Recent Transactions</h2>
                    <i data-lucide="wallet" class="h-6 w-6 text-blue-500"></i>
                </div>
                <div class="space-y-4">
                    <?php foreach ($transactions as $transaction) : ?>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900"><?= $transaction['description'] ?></p>
                            <p class="text-xs text-gray-500"><?= date('M j, Y', strtotime($transaction['date'])) ?></p>
                        </div>
                        <span class="<?= $transaction['amount'] > 0 ? 'text-green-600' : 'text-red-600' ?> font-medium">
                            <?= number_format($transaction['amount'], 2) ?>€
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- État des cultures -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Crop Status</h2>
                    <i data-lucide="leaf" class="h-6 w-6 text-green-500"></i>
                </div>
                <div class="space-y-4">
                    <?php foreach ($crops as $crop) : ?>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium"><?= $crop['name'] ?></span>
                            <span class="text-gray-500"><?= $crop['health'] ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 rounded-full h-2" style="width: <?= $crop['growth'] ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Graphique des tendances -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-700">Financial Trends</h2>
                <i data-lucide="bar-chart" class="h-6 w-6 text-purple-500"></i>
            </div>
            <canvas id="financialChart" class="w-full h-64"></canvas>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialisation des icônes
    lucide.createIcons();

    // Configuration du graphique
    const ctx = document.getElementById('financialChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Income',
                data: [6500, 5900, 8000, 8100, 5600, 7500],
                borderColor: '#10B981',
                tension: 0.4
            },
            {
                label: 'Expenses',
                data: [2800, 3100, 2950, 4200, 3700, 3900],
                borderColor: '#EF4444',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>

</body>
</html>