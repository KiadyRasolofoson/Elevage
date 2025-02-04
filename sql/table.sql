CREATE DATABASE if NOT EXISTS elevage;

use elevage;

CREATE TABLE
    users (
        id_user INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL
    );

-- Table pour stocker les animaux
CREATE TABLE
    espece (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        poids_minimal_vente DECIMAL(10, 2) NOT NULL, -- Poids minimal pour la vente
        prix_kg DECIMAL(10, 2) NOT NULL, -- Prix de vente au kg
        poids_maximal DECIMAL(10, 2) NOT NULL, -- Poids maximal de l'animal
        jours_sans_manger INT NOT NULL, -- Nombre de jours sans manger avant de mourir
        perte_poids_par_jour DECIMAL(5, 2) NOT NULL -- % de perte de poids par jour sans manger
    );

ALTER TABLE espece
ADD COLUMN quota_nourriture_journalier DECIMAL(10, 2) NOT NULL;

CREATE TABLE
    animaux (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_espece INT,
        id_user INT,
        nom VARCHAR(100) NOT NULL,
        FOREIGN KEY (id_espece) REFERENCES espece (id),
        FOREIGN KEY (id_user) REFERENCES users (id_user)
    );

CREATE TABLE
    etat (
        id_etat INT AUTO_INCREMENT PRIMARY KEY,
        id_animaux INT,
        date_etat DATE,
        poids DECIMAL(5, 2) NOT NULL,
        FOREIGN KEY (id_animaux) REFERENCES animaux (id)
    );

-- Table pour stocker les aliments
CREATE TABLE
    alimentations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        pourcentage_gain DECIMAL(5, 2) NOT NULL -- % de gain de poids par jour avec cet aliment
    );

ALTER TABLE alimentations
ADD COLUMN prix INT;

-- Table pour stocker les achats d'animaux
CREATE TABLE
    achats_animaux (
        id INT AUTO_INCREMENT PRIMARY KEY,
        animal_id INT NOT NULL,
        date_achat DATE NOT NULL,
        prix_achat DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (animal_id) REFERENCES animaux (id) ON DELETE CASCADE
    );

-- Table pour stocker les ventes d'animaux
CREATE TABLE
    ventes_animaux (
        id INT AUTO_INCREMENT PRIMARY KEY,
        animal_id INT NOT NULL,
        date_vente DATE NOT NULL,
        prix_vente DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (animal_id) REFERENCES animaux (id) ON DELETE CASCADE
    );

ALTER TABLE ventes_animaux
ADD COLUMN estVendu INT NOT NULL DEFAULT 0;

-- Table pour stocker les achats de nourriture
CREATE TABLE
    nourritures (
        id INT AUTO_INCREMENT PRIMARY KEY,
        alimentation_id INT NOT NULL,
        quantite DECIMAL(10, 2) NOT NULL, -- Quantité de nourriture achetée
        date_achat DATE NOT NULL,
        prix_achat DECIMAL(10, 2) NOT NULL, -- Prix total de l'achat
        FOREIGN KEY (alimentation_id) REFERENCES alimentations (id) ON DELETE CASCADE
    );

-- Table pour stocker les actions de nourrir les animaux
CREATE TABLE
    nourrir_animaux (
        id INT AUTO_INCREMENT PRIMARY KEY,
        animal_id INT NOT NULL,
        alimentation_id INT NOT NULL,
        date_nourriture DATE NOT NULL,
        quantite_nourriture DECIMAL(10, 2) NOT NULL, -- Quantité de nourriture donnée
        FOREIGN KEY (animal_id) REFERENCES animaux (id) ON DELETE CASCADE,
        FOREIGN KEY (alimentation_id) REFERENCES alimentations (id) ON DELETE CASCADE
    );

-- Table pour stocker le capital initial et les transactions
CREATE TABLE
    capital (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT,
        montant_initial DECIMAL(15, 2) NOT NULL, -- Capital initial
        date_creation DATE NOT NULL,
        FOREIGN KEY (id_user) REFERENCES users (id_user)
    );

ALTER TABLE capital CHANGE montant_initial solde DECIMAL(15, 2) NOT NULL;