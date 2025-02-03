-- Inserting test data into users table
INSERT INTO users (id_user,nom, password) VALUES
(1,'John Doe', 'password123'),
(2,'Jane Smith', 'securepass456');

-- Inserting test data into espece table
INSERT INTO espece (nom, poids_minimal_vente, prix_kg, poids_maximal, jours_sans_manger, perte_poids_par_jour) VALUES
('Chien', 5.00, 10.00, 30.00, 5, 1.5),
('Chat', 2.00, 15.00, 10.00, 7, 1.0),
('Vache', 50.00, 7.50, 500.00, 10, 2.0);

-- Inserting test data into animaux table
INSERT INTO animaux (id_espece, id_user, nom) VALUES
(1, 1, 'Rex'),
(2, 1, 'Mittens'),
(3, 2, 'Bessie');

-- Inserting test data into etat table
INSERT INTO etat (id_animaux, date_etat, poids) VALUES
(1, '2025-02-01', 8.50),
(2, '2025-02-01', 3.50),
(3, '2025-02-01', 200.00);

-- Inserting test data into alimentations table
INSERT INTO alimentations (nom, pourcentage_gain) VALUES
('Croquettes Chien', 2.00),
('Croquettes Chat', 3.00),
('Foin', 1.00);

-- Inserting test data into achats_animaux table
INSERT INTO achats_animaux (animal_id, date_achat, prix_achat) VALUES
(1, '2025-02-01', 50.00),
(2, '2025-02-01', 30.00),
(3, '2025-02-01', 200.00);

-- Inserting test data into ventes_animaux table
INSERT INTO ventes_animaux (animal_id, date_vente, prix_vente, estVendu) VALUES
(1, '2025-02-02', 60.00, 1),
(2, '2025-02-02', 40.00, 0),
(3, '2025-02-02', 250.00, 0);

-- Inserting test data into nourritures table
INSERT INTO nourritures (alimentation_id, quantite, date_achat, prix_achat) VALUES
(1, 100.00, '2025-02-01', 20.00),
(2, 50.00, '2025-02-01', 15.00),
(3, 200.00, '2025-02-01', 10.00);

-- Inserting test data into nourrir_animaux table
INSERT INTO nourrir_animaux (animal_id, alimentation_id, date_nourriture, quantite_nourriture) VALUES
(1, 1, '2025-02-02', 10.00),
(2, 2, '2025-02-02', 5.00),
(3, 3, '2025-02-02', 20.00);

-- Inserting test data into capital table
INSERT INTO capital (id_user, solde, date_creation) VALUES
(1, 500.00, '2025-01-01'),
(2, 1000.00, '2025-01-01');

-- Verify the changes
SELECT * FROM users;
SELECT * FROM espece;
SELECT * FROM animaux;
SELECT * FROM etat;
SELECT * FROM alimentations;
SELECT * FROM achats_animaux;
SELECT * FROM ventes_animaux;
SELECT * FROM nourritures;
SELECT * FROM nourrir_animaux;
SELECT * FROM capital;

CREATE OR REPLACE VIEW animaux_avec_ventes AS
SELECT 
    a.id AS animal_id,
    a.nom AS animal_name,
    e.nom AS espece_name,
    e.poids_minimal_vente AS poids_minimal_vente,  -- Poids minimal de vente de l'espèce
    IFNULL(et.poids, 0) AS poids_actuel,  -- Poids actuel de l'animal, si NULL mettre 0
    IF(va.id IS NOT NULL, 'Oui', 'Non') AS deja_dans_ventes  -- Si l'animal est déjà dans la vente
FROM 
    animaux a
JOIN 
    espece e ON a.id_espece = e.id
LEFT JOIN 
    ventes_animaux va ON a.id = va.animal_id
LEFT JOIN 
    etat et ON et.id_animaux = a.id 
    AND et.date_etat = (SELECT MAX(e2.date_etat) 
                        FROM etat e2 
                        WHERE e2.id_animaux = a.id);


