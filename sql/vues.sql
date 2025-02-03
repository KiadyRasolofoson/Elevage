CREATE
OR REPLACE VIEW animaux_avec_ventes AS
SELECT
    a.id AS animal_id,
    a.id_user as id_user,
    a.nom AS animal_name,
    e.nom AS espece_name,
    e.poids_minimal_vente AS poids_minimal_vente, -- Poids minimal de vente de l'espèce
    IFNULL (et.poids, 0) AS poids_actuel, -- Poids actuel de l'animal, si NULL mettre 0
    IF (va.id IS NOT NULL, 'Oui', 'Non') AS deja_dans_ventes -- Si l'animal est déjà dans la vente
FROM
    animaux a
    JOIN espece e ON a.id_espece = e.id
    LEFT JOIN ventes_animaux va ON a.id = va.animal_id
    LEFT JOIN etat et ON et.id_etat = (
        SELECT
            e2.id_etat
        FROM
            etat e2
        WHERE
            e2.id_animaux = a.id
        ORDER BY
            e2.date_etat DESC,
            e2.id_etat DESC
        LIMIT
            1
    )
WHERE
    va.estVendu != 1;