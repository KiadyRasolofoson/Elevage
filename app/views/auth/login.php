<?php
$base_url = Flight::app()->get('flight.base_url');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= $base_url ?>public/assets2/css/bootstrap.css">
    <link rel="stylesheet" href="<?= $base_url ?>public/assets2/css/style.css">
    <script src="<?= $base_url ?>public/assets2/js/jquery.min.js"></script>
    <script src="<?= $base_url ?>public/assets2/js/bootstrap.min.js"></script>
    <title>Noel</title>
</head>

<body>
    <div class="login">
        <div class="row">
            <div class="col-md-5">
                <div class="logo-image"></div>
            </div>
            <div class="col-md-7">
                <h2>We are happy to see you</h2>
                <h4>Begin your day with us</h4>
                <div class="sign-google">

                </div>
                <form action="/login" method="post">
                    <?php if (isset($data['error'])) {
                        echo $data['error'];
                    }
                    ?>
                    <div class="form-group">
                        <label for="exampleInputEmail">Username</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                    </div>

                    <button type="submit" class="btn btn-default" id="submit-login">Login</button>
                    <p id="no-account">Don't have account? <a href="/register">Sign up</a></p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>