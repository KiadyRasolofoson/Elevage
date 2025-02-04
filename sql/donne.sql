-- Insertion des utilisateurs
INSERT INTO
    users (nom, password)
VALUES
    ('Alice', 'alice123'),
    ('Bob', 'bob456'),
    ('Charlie', 'charlie789');

-- Insertion des espèces d'animaux
INSERT INTO
    espece (
        nom,
        poids_minimal_vente,
        prix_kg,
        poids_maximal,
        jours_sans_manger,
        perte_poids_par_jour
    )
VALUES
    ('Vache', 500.00, 2.50, 1000.00, 7, 1.50),
    ('Mouton', 50.00, 5.00, 150.00, 5, 2.00),
    ('Poulet', 2.00, 3.00, 5.00, 3, 3.00);

-- Insertion des animaux
INSERT INTO
    animaux (id_espece, id_user, nom)
VALUES
    (1, 1, 'Bella'),
    (2, 2, 'Dolly'),
    (3, 3, 'Coco');

-- Insertion des états des animaux (au 4 février 2025)
INSERT INTO
    etat (id_animaux, date_etat, poids)
VALUES
    (5, '2025-02-04', 600.00),
    (2, '2025-02-04', 60.00),
    (3, '2025-02-04', 3.00);

-- Insertion des aliments
INSERT INTO
    alimentations (nom, pourcentage_gain)
VALUES
    ('Foin', 0.50),
    ('Grains', 1.00),
    ('Maïs', 1.50);

-- Insertion des achats d'animaux (quelques jours avant le 4 février 2025)
INSERT INTO
    achats_animaux (animal_id, date_achat, prix_achat)
VALUES
    (1, '2025-01-30', 1500.00),
    (2, '2025-01-31', 300.00),
    (3, '2025-02-01', 15.00);

-- Insertion des ventes d'animaux (quelques jours après le 4 février 2025)
INSERT INTO
    ventes_animaux (animal_id, date_vente, prix_vente, estVendu)
VALUES
    (1, '2025-02-10', 2000.00, 1),
    (2, '2025-02-11', 400.00, 1),
    (3, '2025-02-12', 20.00, 1);

-- Insertion des achats de nourriture (quelques jours avant le 4 février 2025)
INSERT INTO
    nourritures (alimentation_id, quantite, date_achat, prix_achat)
VALUES
    (1, 1000.00, '2025-01-28', 200.00),
    (2, 500.00, '2025-01-29', 300.00),
    (3, 300.00, '2025-01-30', 150.00);

-- Insertion des actions de nourrir les animaux (au 4 février 2025)
INSERT INTO
    nourrir_animaux (
        animal_id,
        alimentation_id,
        date_nourriture,
        quantite_nourriture
    )
VALUES
    (1, 1, '2025-02-04', 10.00),
    (2, 2, '2025-02-04', 5.00),
    (3, 3, '2025-02-04', 1.00);

-- Insertion du capital initial (au 4 février 2025)
INSERT INTO
    capital (id_user, solde, date_creation)
VALUES
    (1, 10000.00, '2025-02-04'),
    (2, 5000.00, '2025-02-04'),
    (3, 2000.00, '2025-02-04');