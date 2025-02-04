<?php

namespace app\models;

use app\models\Etat;
use app\models\Food;

use Flight;

use Exception;

class Animal
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAnimal() {}

    public function getIdDernierAnimal()
    {
        $stmt = $this->db->query('SELECT id FROM animaux ORDER BY id DESC LIMIT 1');
        $dernierAnimal = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $dernierAnimal ? $dernierAnimal['id'] : null;
    }


    public function getAnimalByNom($nom)
    {
        $stmt = $this->db->prepare('SELECT * FROM animaux WHERE nom= :nom');
        $stmt->execute(['nom' => $nom]);
        $animal = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($animal) {
            return $animal;
        }
        return null;
    }

    public function getAnimalById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM animaux WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $animal = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($animal) {
            return $animal;
        }
        return null;
    }

    public function estVendable($id_animal, $date)
    {
        // Récupérer le poids minimal requis pour la vente et le poids actuel de l'animal
        $query = "SELECT e.poids_minimal_vente, et.poids 
              FROM animaux a
              JOIN espece e ON a.id_espece = e.id
              JOIN etat et ON et.id_animaux = a.id
               WHERE a.id = :id_animal
              ORDER BY et.id_etat DESC LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal
            // 'date' => $date
        ]);

        $animal = $stmt->fetch();

        if (!$animal) {
            return false;
        }
        return $animal['poids'] >= $animal['poids_minimal_vente'];
    }

    public function getAllAnimal()
    {
        session_start();
        $user_id = $_SESSION['user']['id_user']; // Assurez-vous que c'est bien "id_user"   
        $stmt = $this->db->prepare('SELECT * FROM animaux 
                                WHERE id NOT IN (SELECT animal_id FROM ventes_animaux) 
                                AND id_user = :id_user');  // Correction ici

        $stmt->execute(['id_user' => $user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function upload_photo($file)
    {
        // Vérifier si un fichier a été uploadé
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            // Dossier de destination pour les photos
            $uploadDir = 'public/upload/';

            // Créer le dossier s'il n'existe pas
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Valider le type de fichier (image)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                throw new Exception("Seuls les fichiers JPEG, PNG et GIF sont autorisés.");
            }

            // Valider la taille du fichier (par exemple, 5 Mo maximum)
            $maxSize = 5 * 1024 * 1024; // 5 Mo
            if ($file['size'] > $maxSize) {
                throw new Exception("La taille du fichier ne doit pas dépasser 5 Mo.");
            }

            // Générer un nom de fichier unique pour éviter les conflits
            $fileName = uniqid('animal_') . '_' . basename($file['name']);
            $uploadFilePath = $uploadDir . $fileName;

            // Déplacer le fichier uploadé vers le dossier de destination
            if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                return $uploadFilePath; // Retourner le chemin du fichier
            } else {
                throw new Exception("Erreur lors de l'upload de la photo.");
            }
        } else {
            throw new Exception("Aucun fichier uploadé ou erreur lors de l'upload.");
        }
    }

    public function add($id_espece, $nom, $poids, $autovente, $file)
    {
        session_start();
        try {
            // Vérifier si un fichier a été uploadé
            if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Aucun fichier uploadé ou erreur lors de l'upload.");
            }

            // Appeler la fonction upload_photo pour gérer le téléchargement de la photo
            $photoPath = $this->upload_photo($file);

            // Préparation de la requête SQL pour insérer un enregistrement dans la table animaux
            $stmt = $this->db->prepare('INSERT INTO animaux (id_espece, nom, id_user, auto_vente, photo) 
                                    VALUES (:id_espece, :nom, :id_user, :autovente, :photo)');

            // Exécution de la requête avec les paramètres fournis
            $stmt->execute([
                'id_espece' => $id_espece,
                'nom' => $nom,
                'id_user' => $_SESSION['user']['id_user'],
                'autovente' => $autovente,
                'photo' => $photoPath
            ]);

            // Traitement du poids et du capital
            $etat = new Etat(Flight::db());
            $etat->addEtat($this->getIdDernierAnimal(), $poids);
            $espece = new Espece(Flight::db());
            $prix = $espece->getPrixParKg($id_espece) * $poids;
            $capital = new Capital(Flight::db());
            $capital->modifierCapital($_SESSION['user']['id_user'], -$prix);

            return true;
        } catch (\PDOException $e) {
            // En cas d'erreur, afficher l'erreur
            return 'Erreur lors de l\'ajout : ' . $e->getMessage();
        } catch (\Exception $e) {
            // En cas d'erreur lors de l'upload de la photo
            return 'Erreur : ' . $e->getMessage();
        }
    }

    public function getAllAnimals() {
        $stmt = $this->db->query('
            SELECT a.*, e.nom as espece_nom, e.quota_nourriture_journalier,
                   e.poids_minimal_vente, e.prix_kg, e.poids_maximal,
                   e.jours_sans_manger, e.perte_poids_par_jour,
                   et.poids, et.date_etat,
                   COALESCE(m.date_vente, NULL) as date_mort
            FROM animaux a 
            LEFT JOIN espece e ON a.id_espece = e.id 
            LEFT JOIN etat et ON a.id = et.id_animaux 
                AND et.date_etat = (
                    SELECT MAX(date_etat) 
                    FROM etat 
                    WHERE id_animaux = a.id
                )
            LEFT JOIN mort m ON a.id = m.id_animal
            WHERE m.date_vente IS NULL
            ORDER BY a.id DESC
        ');
        return $stmt->fetchAll();
    }

    public function processAutomaticFeeding($date) {
        // Get available food stock
        $foodModel = new Food(FLight::db());
        $availableFood = $foodModel->getFoodStock();
        
        // Get all living animals that need feeding
        $animals = $this->getAnimalsNeedingFood($date);
        
        // Sort animals by priority (closest to sale weight first)
        usort($animals, function($a, $b) {
            $aDistance = $a['poids_minimal_vente'] - $a['poids'];
            $bDistance = $b['poids_minimal_vente'] - $b['poids'];
            return $aDistance <=> $bDistance;
        });

        foreach ($animals as $animal) {
            $quotaNeeded = $animal['quota_nourriture_journalier'];
            
            // Check if we have enough food
            foreach ($availableFood as &$food) {
                if ($food['stock_total'] >= $quotaNeeded) {
                    // Feed the animal
                    $this->feedAnimal($animal['id'], $food['id'], $quotaNeeded, $date);
                    $food['stock_total'] -= $quotaNeeded;
                    
                    // Update animal weight based on food's gain percentage
                    $newWeight = $animal['poids'] * (1 + ($food['pourcentage_gain'] / 100));
                    $this->updateAnimalWeight($animal['id'], $newWeight, $date);
                    break;
                }
            }
        }

        // Process weight loss for unfed animals
        $this->processUnfedAnimals($date);
    }

    private function getAnimalsNeedingFood($date) {
        $stmt = $this->db->prepare('
            SELECT a.*, e.quota_nourriture_journalier, e.poids_minimal_vente,
                   e.perte_poids_par_jour, et.poids, 
                   DATEDIFF(?, COALESCE(
                       (SELECT MAX(date_nourriture) 
                        FROM nourrir_animaux 
                        WHERE animal_id = a.id), 
                       et.date_etat
                   )) as days_without_food
            FROM animaux a
            JOIN espece e ON a.id_espece = e.id
            JOIN etat et ON a.id = et.id_animaux
            WHERE et.date_etat = (
                SELECT MAX(date_etat) 
                FROM etat 
                WHERE id_animaux = a.id
            )
            AND NOT EXISTS (
                SELECT 1 FROM mort 
                WHERE id_animal = a.id
            )
            AND NOT EXISTS (
                SELECT 1 FROM nourrir_animaux 
                WHERE animal_id = a.id 
                AND date_nourriture = ?
            )
        ');
        $stmt->execute([$date, $date]);
        return $stmt->fetchAll();
    }

    private function feedAnimal($animalId, $foodId, $quantity, $date) {
        $stmt = $this->db->prepare('
            INSERT INTO nourrir_animaux (animal_id, alimentation_id, date_nourriture, quantite_nourriture)
            VALUES (?, ?, ?, ?)
        ');
        return $stmt->execute([$animalId, $foodId, $date, $quantity]);
    }

    private function updateAnimalWeight($animalId, $weight, $date) {
        $stmt = $this->db->prepare('
            INSERT INTO etat (id_animaux, date_etat, poids)
            VALUES (?, ?, ?)
        ');
        return $stmt->execute([$animalId, $date, $weight]);
    }

   
    private function processUnfedAnimals($date) {
        $unfedAnimals = $this->getUnfedAnimals($date);
        foreach ($unfedAnimals as $animal) {
            $daysWithoutFood = $animal['days_without_food'];
            
            // Calculate new weight after weight loss
            $weightLossPercentage = $animal['perte_poids_par_jour'] * $daysWithoutFood;
            $newWeight = $animal['poids'] * (1 - ($weightLossPercentage / 100));
            
            // Update weight
            $this->updateAnimalWeight($animal['id'], $newWeight, $date);
            
            // Check if animal dies from starvation
            if ($daysWithoutFood >= $animal['jours_sans_manger']) {
                $this->recordAnimalDeath($animal['id'], $date);
            }
        }
    }

    public function processAutomaticSales($date) {
        $stmt = $this->db->prepare('
            SELECT a.*, e.poids_minimal_vente, e.prix_kg, et.poids
            FROM animaux a
            JOIN espece e ON a.id_espece = e.id
            JOIN etat et ON a.id = et.id_animaux
            WHERE a.auto_vente = 1
            AND et.date_etat = (
                SELECT MAX(date_etat) 
                FROM etat 
                WHERE id_animaux = a.id
            )
            AND et.poids >= e.poids_minimal_vente
            AND NOT EXISTS (
                SELECT 1 FROM ventes_animaux 
                WHERE animal_id = a.id
            )
            AND NOT EXISTS (
                SELECT 1 FROM mort 
                WHERE id_animal = a.id
            )
        ');
        $stmt->execute();
        $animalsToSell = $stmt->fetchAll();

        foreach ($animalsToSell as $animal) {
            $salePrice = $animal['poids'] * $animal['prix_kg'];
            $this->sellAnimal($animal['id'], $salePrice, $date);
        }
    }

    private function sellAnimal($animalId, $price, $date) {
        $stmt = $this->db->prepare('
            INSERT INTO ventes_animaux (animal_id, date_vente, prix_vente, estVendu)
            VALUES (?, ?, ?, 1)
        ');
        return $stmt->execute([$animalId, $date, $price]);
    }


    public function recordAnimalDeath($animalId, $date) {
        $stmt = $this->db->prepare('
            INSERT INTO mort (id_animal, date_vente)
            VALUES (?, ?)
        ');
        return $stmt->execute([$animalId, $date]);
    }

    public function getStatistics($date) {
        return [
            'total_animals' => $this->getTotalAnimals(),
            'animals_by_species' => $this->getAnimalsBySpecies(),
            'sales_data' => $this->getSalesData($date),
            'food_consumption' => $this->getFoodConsumption($date),
            'deaths' => $this->getDeathStatistics($date),
            'profit_loss' => $this->getProfitLoss($date)
        ];
    }

    private function getTotalAnimals() {
        $stmt = $this->db->query('
            SELECT COUNT(*) as total
            FROM animaux a
            WHERE NOT EXISTS (
                SELECT 1 FROM mort 
                WHERE id_animal = a.id
            )
            AND NOT EXISTS (
                SELECT 1 FROM ventes_animaux 
                WHERE animal_id = a.id 
                AND estVendu = 1
            )
        ');
        return $stmt->fetch()['total'];
    }

    private function getAnimalsBySpecies() {
        $stmt = $this->db->query('
            SELECT e.nom, COUNT(*) as count
            FROM animaux a
            JOIN espece e ON a.id_espece = e.id
            WHERE NOT EXISTS (
                SELECT 1 FROM mort 
                WHERE id_animal = a.id
            )
            AND NOT EXISTS (
                SELECT 1 FROM ventes_animaux 
                WHERE animal_id = a.id 
                AND estVendu = 1
            )
            GROUP BY e.id, e.nom
        ');
        return $stmt->fetchAll();
    }

    private function getSalesData($date) {
        $stmt = $this->db->prepare('
            SELECT 
                COUNT(*) as total_sales,
                SUM(prix_vente) as total_revenue,
                AVG(prix_vente) as average_sale_price
            FROM ventes_animaux
            WHERE date_vente <= ?
            AND estVendu = 1
        ');
        $stmt->execute([$date]);
        return $stmt->fetch();
    }

    private function getFoodConsumption($date) {
        $stmt = $this->db->prepare('
            SELECT 
                al.nom,
                SUM(na.quantite_nourriture) as total_consumed,
                COUNT(DISTINCT na.animal_id) as animals_fed
            FROM nourrir_animaux na
            JOIN alimentations al ON na.alimentation_id = al.id
            WHERE na.date_nourriture <= ?
            GROUP BY al.id, al.nom
        ');
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }

    private function getDeathStatistics($date) {
        $stmt = $this->db->prepare('
            SELECT 
                e.nom as species,
                COUNT(*) as death_count,
                AVG(DATEDIFF(m.date_vente, aa.date_achat)) as avg_lifespan
            FROM mort m
            JOIN animaux a ON m.id_animal = a.id
            JOIN espece e ON a.id_espece = e.id
            JOIN achats_animaux aa ON a.id = aa.animal_id
            WHERE m.date_vente <= ?
            GROUP BY e.id, e.nom
        ');
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }

    private function getProfitLoss($date) {
        $stmt = $this->db->prepare('
            SELECT 
                (SELECT COALESCE(SUM(prix_vente), 0) 
                 FROM ventes_animaux 
                 WHERE date_vente <= ?) as total_sales,
                (SELECT COALESCE(SUM(prix_achat), 0) 
                 FROM achats_animaux 
                 WHERE date_achat <= ?) as total_purchases,
                (SELECT COALESCE(SUM(n.quantite * a.prix), 0)
                 FROM nourritures n 
                 JOIN alimentations a ON n.alimentation_id = a.id
                 WHERE n.date_achat <= ?) as total_food_cost
        ');
        $stmt->execute([$date, $date, $date]);
        $data = $stmt->fetch();
        
        return [
            'total_revenue' => $data['total_sales'],
            'total_costs' => $data['total_purchases'] + $data['total_food_cost'],
            'net_profit' => $data['total_sales'] - ($data['total_purchases'] + $data['total_food_cost'])
        ];
    }

}
