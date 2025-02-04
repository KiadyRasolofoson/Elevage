CREATE OR REPLACE VIEW animaux_avec_ventes AS
SELECT
    a.id AS animal_id,
    a.id_user AS id_user,
    a.auto_vente AS auto_vente,
    a.nom AS animal_name,
    e.nom AS espece_name,
    e.poids_minimal_vente AS poids_minimal_vente, -- Poids minimal de vente de l'espèce
    et.poids AS poids_actuel -- Poids actuel de l'animal (dernier enregistrement)
FROM
    animaux a
JOIN
    espece e ON a.id_espece = e.id
LEFT JOIN
    etat et ON et.id_animaux = a.id AND et.id_etat = (
        SELECT
            e2.id_etat
        FROM
            etat e2
        WHERE
            e2.id_animaux = a.id
        ORDER BY
            e2.date_etat DESC,
            e2.id_etat DESC
        LIMIT 1
    )
WHERE
    a.id NOT IN (
        SELECT animal_id
        FROM ventes_animaux
    )
    AND a.id NOT IN (
        SELECT id_animal
        FROM mort
    );
