<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vente</title>
</head>

<body>
    <?php include('app/views/layout/header.php'); ?>
    <div class="container">
        <h1>Vendre</h1>
        <?php if (isset($listeAnimaux)) {
            echo "aa";
            if (count($listeAnimaux) > 0) {
        ?>
            <table>
                <tr>
                    <td>Id</td>
                    <td>Nom</td>
                    <td>Espece</td>
                    <td>Action</td>
                </tr>
            </table>
        <?php
            }
        } ?>
    </div>
</body>

</html>