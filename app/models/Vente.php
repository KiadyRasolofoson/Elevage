<?php

namespace app\models;

use Flight;

class Vente {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function vendre ($id_animal, $date_ventes) {
        
    }
}