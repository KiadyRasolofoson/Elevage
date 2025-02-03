<?php

namespace app\models;

use flight\Engine;

class AdminModel
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function verifierLogin($email, $mdp)
    {
        $sql = "SELECT * FROM admin WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($admin && $mdp == $admin['password']) {
            return true;
        }
        return false;
    }
}
