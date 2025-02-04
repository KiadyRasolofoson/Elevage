<?php
namespace app\controllers;
use app\models\Animal;
class DashboardController {

    public function index() {
        $date = Flight::request()->query->date ?? date('Y-m-d');
        
        $animal = new Animal(Flight::db());
        
        // Process automatic actions for the selected date
        $animal->processAutomaticFeeding($date);
        $animal->processAutomaticSales($date);
        
        // Get updated data
        $animals = $animal->getAllAnimals();
        $statistics = $animal->getStatistics($date);
        
        Flight::render('dashboard/index', [
            'animals' => $animals,
            'statistics' => $statistics,
            'date' => $date
        ]);
    }
}