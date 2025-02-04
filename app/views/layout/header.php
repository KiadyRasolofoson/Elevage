<?php
$indice = 0;
$nav = ['Home', 'Animals', 'Alimentation', 'Vendre', 'Dashboard', 'Acheter', 'Nourir'];
$nav_link = ['/user', '/animal', '/alimentation', '/vente', '/dashboard', '/achat', '/nourrir'];
$base_url = Flight::app()->get('flight.base_url');
if (!empty($_GET['indice'])) {
	$indice = $_GET['indice'];
}
?>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= $base_url; ?>/public/assets2/header/style.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
</head>


	<header class="header">
      <nav class="nav">
        <a href="#" class="nav_logo">StockFarm</a>

        <ul class="nav_items">
          <li class="nav_item">

			<?php
				for ($i = 0; $i < count($nav); $i++) {
					if ($i == $indice) {
			?>
			<a href="<?php echo $base_url . $nav_link[$i] . '?indice=' . $i; ?>" class="nav-link active" style="font-size:larger;"><?php echo $nav[$i]; ?></a>
			<?php } else { ?>
				<a href="<?php echo $base_url . $nav_link[$i] . '?indice=' . $i; ?>" class="nav-link" style="font-size:larger; " ><?php echo $nav[$i]; ?></a>
			<?php } ?>
			<?php } ?>
          </li>
        </ul>

        <button class="button" id="form-open">Login</button>
      </nav>
    </header>


	<script src="/Elevage/public/assets/css/header/js/jquery.min.js"></script>
	<script src="/Elevage/public/assets/css/header/js/popper.js"></script>
	<script src="/Elevage/public/assets/css/header/js/bootstrap.min.js"></script>
	<script src="/Elevage/public/assets/css/header/js/main.js"></script>
	
