<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .user-name {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
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

        .container {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 20px;
        }

        .box {
            width: 100px;
            height: 100px;
            background-color: #3498db;
            animation: float 3s infinite ease-in-out;
        }

        .box:nth-child(2) {
            background-color: #e74c3c;
            animation-delay: 1s;
        }

        .box:nth-child(3) {
            background-color: #2ecc71;
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="user-name">Nom de l'utilisateur</div>
    <div class="container">
        <div class="box"></div>
        <div class="box"></div>
        <div class="box"></div>
    </div>
</body>

</html>