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
    <title>Login</title>
</head>

<body>
    <?php
    $_GET['indice']=100;
    include('app/views/layout/header.php');
    ?>
    <section class="welcome">
    <div class="container text-center">
        <h1>Bienvenue sur <b>StockFarm</b></h1>
        <p>Pour accéder à toutes les fonctionnalités, veuillez vous connecter ou créer un compte.</p>
        
    </div>
</section>

    <section class="home">
      <div class="form_container">
        <i class="uil uil-times form_close"></i>
        <!-- Login From -->
        <div class="form login_form">
          <form action="<?= $base_url ?>/login" method="post">
            <h2>Login</h2>

            <div class="input_box">
              <input type="username" placeholder="Enter your username" name="username" required />
              <i class="uil uil-username username"></i>
            </div>
            <div class="input_box">
              <input type="password" placeholder="Enter your password" name="password" required />
              <i class="uil uil-lock password"></i>
              <i class="uil uil-eye-slash pw_hide"></i>
            </div>

            <button type="submit" class="button">Login Now</button>

            <div class="login_signup">Don't have an account? <a href="#" id="signup">Signup</a></div>
          </form>
        </div>

        <!-- Signup From -->
        <div class="form signup_form">
          <form action="<?= $base_url ?>/register" method="POST">
            <h2>Signup</h2>

            <div class="input_box">
              <input type="username" placeholder="Enter your username" name="username" required />
              <i class="uil uil-username username"></i>
            </div>
            <div class="input_box">
              <input type="password" placeholder="Create password"  required />
              <i class="uil uil-lock password"></i>
              <i class="uil uil-eye-slash pw_hide"></i>
            </div>
            <div class="input_box">
              <input type="password" placeholder="Confirm password" name="password" required />
              <i class="uil uil-lock password"></i>
              <i class="uil uil-eye-slash pw_hide"></i>
            </div>
            <div class="input_box">
              <input type="number" placeholder="Entrer votre Capital" name="balance" required />
              <i class="uil uil-number number"></i>
            </div>

            <button class="button" type="submit">Signup Now</button>

            <div class="login_signup">Already have an account? <a href="#" id="login">Login</a></div>
          </form>
        </div>
      </div>
    </section>
    <?php include('app/views/layout/footer.php'); ?>
    <script src="<?= $base_url; ?>/public/assets2/header/script.js"></script>
</body>

</html>