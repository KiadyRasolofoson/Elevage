<?php

namespace app\models;
use app\models\Etat;

use Flight;

class Animal
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAnimal() {}
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

    public function estVendable($id_animal, $date)
    {
        // Récupérer le poids minimal requis pour la vente et le poids actuel de l'animal
        $query = "SELECT e.poids_minimal_vente, et.poids 
              FROM animaux a
              JOIN espece e ON a.id_espece = e.id
              JOIN etat et ON et.id_animaux = a.id
              WHERE a.id = :id_animal AND et.date_etat = :date
              ORDER BY et.id_etat DESC LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal,
            'date' => $date
        ]);

        $animal = $stmt->fetch();

        // Vérifier si la requête a retourné des résultats
        if (!$animal) {
            // Si aucun résultat n'est trouvé, retourner false
            return false;
        }

        // Si l'animal existe, vérifier s'il est vendable
        return $animal['poids'] >= $animal['poids_minimal_vente'];
    }

    public function getAllAnimal()
    {
        $stmt = $this->db->query('SELECT * FROM animaux');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function add($id_espece,$nom,$poids)
    {
        session_start();
         try {
            // Préparation de la requête SQL pour insérer un enregistrement dans la table nourrir_animaux
            $stmt = $this->db->prepare('INSERT INTO animaux (id_espece, nom,id_user) 
                                        VALUES (:id_espece, :nom,:id_user)');

            // Exécution de la requête avec les paramètres fournis
            $stmt->execute([
                'id_espece' => $id_espece,
                'nom' => $nom,
                'id_user' => $_SESSION['user']['id_user']
            ]);
            $animal=$this->getAnimalByNom($nom);
            $etat=new Etat(Flight::db());
            $etat->addEtat($animal['id'], $poids);
         
            return true;
        } catch (\PDOException $e) {
            // En cas d'erreur, afficher l'erreur
            return 'Erreur lors de l\'ajout : ' . $e->getMessage();
        }
    }
}
