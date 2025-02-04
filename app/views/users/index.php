<?php
// session_start();
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <style>
        .user-container {
            display: flex;
            justify-content: center;
            /* Centre horizontalement */
            align-items: center;
            /* Centre verticalement */
            height: 10vh;
            /* Ajustez la hauteur selon vos besoins */
        }

        .user-name {
            font-size: 2rem;
            font-weight: bold;
            position: relative;
        }

        .user-name::after {
            content: '';
            display: block;
            width: 100%;
            height: 2px;
            background-color: #333;
            position: absolute;
            bottom: -5px;
            left: 0;
        }

        .container1 {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 5%;
        }

        .box {
            width: 30%;
            height: 200px;
            margin-top: 50px;
            background-color: #3498db;
            border-radius: 20px;
            padding: 20px;
            /* Ajoute un espace intérieur */
            color: white;
            /* Couleur du texte */
            text-align: center;
            /* Centre le texte */
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Centre verticalement */
            align-items: center;
            /* Centre horizontalement */
            transition: all 0.3s ease-in-out;
        }

        .box:hover {
            animation: float 1s infinite ease-in-out;
            border: 1px solid #3498db;

        }

        .box:hover h2 {
            color: #3498db;
        }

        .box:hover p {
            color: black;
        }

        .box:nth-child(2) {
            background-color: #e74c3c;
            border: 1px solid #FF4742;
        }

        .box:nth-child(2):hover h2 {
            color: #e74c3c;
        }

        .box:nth-child(3) {
            background-color: #2ecc71;
            border: 1px solid #2ecc71;
        }

        .box:nth-child(3):hover h2 {
            color: #2ecc71;
        }

        .box h2 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 20px;
            /* Espace entre le titre et la description */
        }

        .box p {
            font-size: 1rem;
            color: white;
        }


        .box {
            border-radius: 6px;
            box-shadow: rgba(0, 0, 0, 0.1) 1px 2px 4px;
            box-sizing: border-box;
            color: #FFFFFF;
            cursor: pointer;
            display: inline-block;
            font-family: nunito, roboto, proxima-nova, "proxima nova", sans-serif;
            font-weight: 800;
            line-height: 16px;
            min-height: 40px;
            outline: 0;
            padding: 12px 14px;
            text-align: center;
            text-rendering: geometricprecision;
            text-transform: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: middle;
        }

        .box:hover,
        .box:active {
            background-color: initial;
            background-position: 0 0;
        }

        .button-24:active {
            opacity: .5;
        }

        .container1 {
            display: flex;
            justify-content: center;
            /* Centre horizontalement */
            gap: 20px;
            /* Ajoute un espacement entre les boîtes */
            width: 100%;
            margin-top: 5%;
            flex-wrap: wrap;
            /* Permet de s'adapter aux petits écrans */
        }

        .box {
            width: 30%;
            max-width: 350px;
            /* Empêche les boîtes de devenir trop larges */
            min-height: 200px;
            /* Garde une hauteur minimale */
            background-color: #3498db;
            border-radius: 20px;
            padding: 20px;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .box h2,
        .box p {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container mt-4">
        <div class="user-container">
        <div class="user-name"><?php echo $_SESSION['user']['nom']; ?></div>
    </div>
    <div class="container1">
        <a class="box" href="<?php echo $base_url; ?>" style="">
            <h2>Capital</h2>
            <p>Voici votre balance actuel :
                <?php if (isset($capital)) {
                    echo $capital;
                } else { ?>
                <?php echo "0";
                } ?>
                AR
            </p>
        </a>

        <a class="box" href="<?php echo $base_url; ?>/animal?indice=1">
            <h2>Mes Animaux</h2>
            <p>Regarder l'etat de vos animaux.</p>
        </a>
        <a class="box" href="<?php echo $base_url; ?>/dashboard?indice=4">
            <h2>Voir Dashboard</h2>
            <p>Regarder les status de votre compte.</p>
        </a>
    </div>
    </div>
    
    <?php include('app/views/layout/footer.php'); ?>
</body>

</html>