<?php

namespace app\models;

use app\models\Fonction;
use Flight;
use Exception;

class Vente
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        // Démarrer la session
        session_start();
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user']['id_user'])) {
            throw new Exception("Utilisateur non connecté.");
        }
        // Récupérer l'ID de l'utilisateur connecté
        $id_user = $_SESSION['user']['id_user'];
        // Créer une instance de la classe Fonction
        $fonction = new Fonction($this->db);
        // Récupérer tous les animaux de la vue
        $animaux = $fonction->getAll('animaux_avec_ventes');
        // Appliquer un filtre supplémentaire sur les résultats
        $animaux_filtres = array_filter($animaux, function ($animal) use ($id_user) {
            // Filtrer les animaux pour ne retourner que ceux de l'utilisateur connecté
            return $animal['id_user'] == $id_user && $animal['auto_vente'] == 0 ;
        });
        // Retourner les résultats filtrés
        return $animaux_filtres;
    }

    public function vendre($id_animal, $date_ventes)
    {
        // Vérifier si l'animal est vendable
        // $animalModel = new Animal($this->db);
        // if (!$animalModel->estVendable($id_animal, $date_ventes)) {
        //     return json_encode([
        //         'success' => false,
        //         'message' => "L'animal n'est pas vendable cause poids insuffisant"
        //     ]);
        // }
        // Récupérer les informations nécessaires pour le prix de vente
        // Sélectionner le dernier état de l'animal
        $query = "SELECT e.prix_kg, et.poids 
              FROM animaux a
              JOIN espece e ON a.id_espece = e.id
              JOIN etat et ON et.id_animaux = a.id
              WHERE a.id = :id_animal
              ORDER BY et.date_etat DESC LIMIT 1";  // Prendre le dernier état

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal
        ]);
        $animal = $stmt->fetch();

        if (!$animal) {
            return json_encode([
                'success' => false,
                'message' => "Impossible de récupérer les informations de l'animal."
            ]);
        }

        // Calculer le prix de vente (poids * prix_kg)
        $prix_vente = $animal['poids'] * $animal['prix_kg'];

        $query = "INSERT INTO capital (id_user, solde, date_creation) 
          VALUES (:id_user, :prix_vente, :date_creation)";

        session_start();
        $id_user = $_SESSION['user']['id_user'];
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_user' => $id_user, // L'utilisateur qui vend l'animal
            'prix_vente' => $prix_vente, // Montant de la vente
            'date_creation' => $date_ventes
        ]);

        // Insérer la vente dans la table ventes_animaux
        $query = "INSERT INTO ventes_animaux (animal_id, date_vente, prix_vente) 
              VALUES (:id_animal, :date_ventes, :prix_vente)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal,
            'date_ventes' => $date_ventes,
            'prix_vente' => $prix_vente
        ]);

        return json_encode([
            'success' => true,
            'message' => "L'animal a été vendu avec succès.",
            'prix_vente' => $prix_vente,
            'data' => [
                'id_animal' => $id_animal,
                'date_vente' => $date_ventes,
                'prix_vente' => $prix_vente
            ]
        ]);
    }
}
