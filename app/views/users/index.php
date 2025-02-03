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

        .user-name {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
            position: relative;
            justify-content: center;
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
            margin-top: 20px;
        }

        .box {
            width: 100px;
            height: 100px;
            margin-top: 50px;
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
    <div class="container1">
        <div class="box"></div>
        <div class="box"></div>
        <div class="box"></div>
    </div>
</body>

</html>