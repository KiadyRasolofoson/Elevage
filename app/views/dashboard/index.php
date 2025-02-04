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
// Inclure le fichier de mise en page
$base_url = Flight::app()->get('flight.base_url');

// Définir les données du tableau de bord
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$farm = ['capital' => 50000.00]; // Exemple de capital
$totalIncome = 12000.50;
$totalExpenses = 4500.75;
?>
<?php include('app/views/layout/header.php'); ?>
<main class="container mx-auto px-4 py-8">
    <div class="space-y-6">
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

        <!-- Carte du statut financier -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-700">Financial Status</h2>
                    <i data-lucide="trending-up" class="h-6 w-6 text-green-500"></i>
                </div>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Current Capital</p>
                        <p class="text-2xl font-bold text-gray-900">€<?php echo number_format($farm['capital'], 2); ?></p>
                    </div>
                    <div class="flex justify-between text-sm">
                        <div>
                            <p class="text-gray-500">Total Income</p>
                            <p class="text-green-600">+€<?php echo number_format($totalIncome, 2); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-500">Total Expenses</p>
                            <p class="text-red-600">-€<?php echo number_format($totalExpenses, 2); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    lucide.createIcons();
</script>
    
    
</body>

</html>



