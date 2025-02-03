<?php
$base_url = Flight::app()->get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= $base_url ?>/public/assets2/css/bootstrap.css">
    <link rel="stylesheet" href="<?= $base_url ?>/public/assets2/css/style.css">
    <script src="<?= $base_url ?>/public/assets2/js/jquery.min.js"></script>
    <script src="<?= $base_url ?>/public/assets2/js/bootstrap.min.js"></script>
    <title>Creer un compte</title>
</head>
<body>
    <div class="login">
        <div class="row">
            <div class="col-md-5">
                <div class="logo-image"></div>
            </div>
            <div class="col-md-7">
                <h2>Create your account to enjoy</h2>
                <h4>Begin your day with us</h4>
                <div class="sign-google">
                   
                </div>
                <form action="<?= $base_url ?>/register" method="POST">
                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="name" placeholder="Username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="password" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm your password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Capital</label>
                            <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Balance" name="balance">
                        </div>
                        
                        <button type="submit" class="btn btn-default" id="submit-login">Sign</button>
                        <p id="no-account">Do you already have account? <a href="<?= $base_url ?>/">Log in</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>