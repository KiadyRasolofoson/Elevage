<?php
$base_url = Flight::app()->get('flight.base_url');

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6">
<?php include('app/views/layout/header.php'); ?>
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold mb-4 md:mb-0">Farm Dashboard</h1>
            <div class="flex items-center space-x-4">
                <i class="fas fa-calendar-alt text-gray-500"></i>
                <span class="text-gray-500">02/04/2025</span>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Financial Status</h2>
                    <i class="fas fa-chart-line text-green-500"></i>
                </div>
                <p class="text-2xl font-bold">€20.00</p>
                <p class="text-sm text-gray-500">Current Capital</p>
                <div class="flex justify-between mt-4">
                    <p class="text-green-500">+€0.00</p>
                    <p class="text-red-500">-€0.00</p>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <p>Total Income</p>
                    <p>Total Expenses</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Livestock Value</h2>
                    <i class="fas fa-balance-scale text-blue-500"></i>
                </div>
                <p class="text-2xl font-bold">€4.00</p>
                <p class="text-sm text-gray-500">Total Value</p>
                <div class="flex justify-between mt-4">
                    <p class="text-gray-500">1</p>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <p>Total Animals</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Food Inventory</h2>
                    <i class="fas fa-box text-yellow-500"></i>
                </div>
                <p class="text-2xl font-bold">€4.00</p>
                <p class="text-sm text-gray-500">Inventory Value</p>
                <div class="flex justify-between mt-4">
                    <p class="text-gray-500">1</p>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <p>Total Types</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-lg font-semibold mb-4">Animal Status</h2>
                <p>chien</p>
                <p class="text-gray-500">Weight: 4.0 kg</p>
                <p class="text-gray-500">Value: €4.00</p>
                <div class="flex space-x-2 mt-4">
                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-0.5 rounded">Healthy</span>
                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded">Ready for Sale</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                <h2 class="text-lg font-semibold mb-4">Status Summary</h2>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-4">
                    <div class="bg-red-100 text-red-700 p-4 rounded-lg flex-1">
                        <h3 class="font-semibold">Critical Status</h3>
                        <p>Dead Animals: 0</p>
                        <p>Starving: 0</p>
                    </div>
                    <div class="bg-green-100 text-green-700 p-4 rounded-lg flex-1">
                        <h3 class="font-semibold">Healthy Status</h3>
                        <p>Healthy Animals: 1</p>
                        <p>Ready for Sale: 1</p>
                    </div>
                </div>
                <p class="text-gray-500">Food Inventory</p>
                <p>vary</p>
                <p class="text-gray-500 mt-4">Recent Transactions</p>
                <p>2.0 kg</p>
            </div>
        </div>
    </div>
</body>
</html>