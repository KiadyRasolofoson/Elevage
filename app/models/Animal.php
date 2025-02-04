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
              WHERE a.id = :id_animal AND et.date_etat = :date
              ORDER BY et.id_etat DESC LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'id_animal' => $id_animal,
            'date' => $date
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

    public function add($id_espece, $nom, $poids)
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
        }
    }
}
