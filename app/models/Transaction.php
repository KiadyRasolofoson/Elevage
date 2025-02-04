<?php
namespace app\models;

use app\models\Etat;
use app\models\Food;

use Flight;

use Exception;

class Transaction {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getCapital($userId) {
        $stmt = $this->db->prepare('
            SELECT solde FROM capital 
            WHERE id_user = ? 
            ORDER BY date_creation DESC 
            LIMIT 1
        ');
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    public function updateCapital($userId, $amount) {
        $stmt = $this->db->prepare('
            INSERT INTO capital (id_user, solde, date_creation) 
            VALUES (?, ?, CURRENT_DATE)
        ');
        return $stmt->execute([$userId, $amount]);
    }

    public function recordAnimalPurchase($data) {
        $stmt = $this->db->prepare('
            INSERT INTO achats_animaux (animal_id, date_achat, prix_achat) 
            VALUES (?, ?, ?)
        ');
        return $stmt->execute([
            $data['animal_id'],
            $data['date_achat'],
            $data['prix_achat']
        ]);
    }

    public function recordAnimalSale($data) {
        $stmt = $this->db->prepare('
            INSERT INTO ventes_animaux (animal_id, date_vente, prix_vente, estVendu) 
            VALUES (?, ?, ?, ?)
        ');
        return $stmt->execute([
            $data['animal_id'],
            $data['date_vente'],
            $data['prix_vente'],
            $data['estVendu']
        ]);
    }
}