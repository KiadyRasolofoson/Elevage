<?php

namespace app\models;

use PDO;
use Exception;
use Flight;

class Achat
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Récupère tous les achats disponibles (animaux non vendus).
     *
     * @return array
     */
    public function getAchatDisponible()
    {
        session_start();
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user']['id_user'])) {
            throw new Exception("Utilisateur non connecté.");
        }
        // Récupérer l'ID de l'utilisateur connecté
        $id_user = $_SESSION['user']['id_user'];

        $query = "
            SELECT 
                va.id AS id_vente, 
                va.date_vente, 
                va.prix_vente, 
                va.estVendu, 
                a.id AS id_animal, 
                a.nom AS nom_animal, 
                u.id_user AS id_vendeur, 
                u.nom AS nom_vendeur, 
                e.nom AS espece 
            FROM 
                ventes_animaux va 
            JOIN 
                animaux a ON va.animal_id = a.id 
            JOIN 
                espece e ON a.id_espece = e.id 
            JOIN 
                users u ON a.id_user = u.id_user
            WHERE 
                va.estVendu = 0 
                AND u.id_user != :id_user_connecte -- Exclure les ventes de l'utilisateur connecté
            ORDER BY 
                va.id;
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_user_connecte' => $id_user]); // Passer l'ID de l'utilisateur connecté
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Effectue l'achat d'un animal par un utilisateur.
     *
     * @param int $idAcheteur L'ID de l'acheteur.
     * @param int $id_animal_avendre L'ID de l'animal à vendre.
     * @return string JSON contenant le résultat de l'opération.
     */
    public function achat($idAcheteur, $id_animal_avendre)
    {
        // Vérifier si l'animal est disponible à la vente
        $query = "SELECT * FROM ventes_animaux WHERE animal_id = :id_animal_avendre AND estVendu = 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_animal_avendre' => $id_animal_avendre]);
        $vente = $stmt->fetch();

        // Si l'animal n'est pas disponible à la vente
        if (!$vente) {
            return json_encode([
                'success' => false,
                'message' => "L'animal n'est pas disponible à la vente ou a déjà été vendu."
            ]);
        }

        // Vérifier le capital de l'acheteur
        $capitalModel = new Capital($this->db);
        $capital = $capitalModel->getCapital($idAcheteur);
        $capital = json_decode($capital, true);

        // Si le capital est insuffisant
        if (!$capital['success'] || $capital['somme_capital'] < $vente['prix_vente']) {
            return json_encode([
                'success' => false,
                'message' => "Capital insuffisant pour acheter cet animal."
            ]);
        }

        // Mettre à jour l'ID de l'utilisateur (acheteur) de l'animal
        $query = "UPDATE animaux SET id_user = :idAcheteur WHERE id = :id_animal_avendre";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'idAcheteur' => $idAcheteur,
            'id_animal_avendre' => $id_animal_avendre
        ]);

        // Mettre à jour la table des ventes pour marquer que l'animal a été vendu
        $query = "UPDATE ventes_animaux SET estVendu = 1 WHERE animal_id = :id_animal_avendre";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_animal_avendre' => $id_animal_avendre]);

        // Ajouter l'achat à la table des achats d'animaux
        $query = "INSERT INTO achats_animaux (animal_id, date_achat, prix_achat) 
                  SELECT animal_id, NOW(), prix_vente FROM ventes_animaux WHERE animal_id = :id_animal_avendre";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id_animal_avendre' => $id_animal_avendre]);

        // Déduire le prix de l'animal du capital de l'acheteur
        $query = "UPDATE capital SET solde = solde - :prix_vente WHERE id_user = :idAcheteur";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'prix_vente' => $vente['prix_vente'],
            'idAcheteur' => $idAcheteur
        ]);

        return json_encode([
            'success' => true,
            'message' => "L'animal a été acheté avec succès.",
            'id_acheteur' => $idAcheteur,
            'id_animal' => $id_animal_avendre
        ]);
    }


    public function achatNourriture($id_alim, $quantite)
    {
        $Alim = new Alimentation($this->db);

        // Récupérer les informations de l'alimentation
        $aliment = $Alim->getAlimentaionById($id_alim);

        if (!$aliment) {
            return json_encode(["success" => false, "message" => "Aliment non trouvé."]);
        }

        $prix_unitaire = $aliment['prix'];
        $prix_total = $prix_unitaire * $quantite;

        // Démarrer la session
        session_start();

        // Vérifier si l'utilisateur est bien connecté
        if (!isset($_SESSION['user']['id_user'])) {
            return json_encode(["success" => false, "message" => "Utilisateur non connecté."]);
        }

        $capital = new Capital(Flight::db());

        // Vérifier si l'utilisateur a assez de capital
        $solde_actuel = $capital->getCapital($_SESSION['user']['id_user']);
        if ($solde_actuel < $prix_total) {
            return json_encode(["success" => false, "message" => "Fonds insuffisants."]);
        }
        // Déduire du capital
        $capital->modifierCapital($_SESSION['user']['id_user'], -$prix_total);

        // Insérer l'achat dans la table nourritures
        $stmt = $this->db->prepare("
        INSERT INTO nourritures (alimentation_id, quantite, date_achat, prix_achat) 
        VALUES (:alimentation_id, :quantite, NOW(), :prix_achat)
    ");

        $stmt->execute([
            'alimentation_id' => $id_alim,
            'quantite' => $quantite,
            'prix_achat' => $prix_total
        ]);

        return json_encode(["success" => true, "message" => "Achat enregistré avec succès.", "prix_total" => $prix_total]);
    }
}
