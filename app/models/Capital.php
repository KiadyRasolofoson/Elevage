<?php

namespace app\models;

use Flight;

class Capital
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCapital()
    {
        $query = "SELECT SUM(solde) AS somme_capital FROM capital";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!$result) {
            return json_encode([
                'success' => false,
                'message' => "Impossible de récupérer la somme des capitaux."
            ]);
        }

        return json_encode([
            'success' => true,
            'somme_capital' => $result['somme_capital']
        ]);
    }


    public function modifierCapital($id_user, $montant)
    {
        $query = "INSERT INTO capital (id_user, solde, date_creation) VALUES (:id_user, :solde, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_user' => $id_user,
            'solde' => $montant
        ]);
    }
}
