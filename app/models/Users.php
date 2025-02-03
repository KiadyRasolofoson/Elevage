<?php

namespace app\models;

use Flight;
use app\models\Capital;

class Users {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function getUsers(){
        
    }
    public function verify_login($usr,$psw){
        $stmt = $this->db->prepare('SELECT * FROM users WHERE nom = :username');
        $stmt->execute(['username' => $usr]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user && $psw == $user['password']) {
            return true;
        }
        return false;
    }
    public function getIdByUsername($username)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE nom = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user) {
            return $user['id_user'];
        }
        return null;
    }
    public function register($username,$password,$capital) {
        
        // Ajouter l'utilisateur dans la base de données
        $db = Flight::db();
        $stmt = $db->prepare('INSERT INTO users (nom, password) VALUES (:username, :password)');
        $stmt->execute([
            'username' => $username,
            'password' => $password,
        ]);
        $capi= new Capital(Flight::db());
        $id_user=$this->getIdByUsername($username);
        $capi->modifierCapital($id_user, $capital);

  
    }
    public function getUserByUsername($username)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE nom = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if ($user) {
            return $user;
        }
        return null;
    }
}