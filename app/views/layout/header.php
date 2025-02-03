<?php
$indice = 0;
$nav = ['Home', 'Animals', 'Alimentation', 'Vendre', 'Dashboard', 'Acheter', 'Nourir'];
$nav_link = ['/user', '/animal', '/alimentation', '/vente', '/dashboard', '/acheter', '/nourrir'];
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
	<link rel="stylesheet" href="/Elevage/public/assets/css/header/css/style.css">
</head>

<body>
	<section class="ftco-section">
		<div class="container">
			<nav class="navbar navbar-expand-lg ftco_navbar ftco-navbar-light" id="ftco-navbar">
				<div class="container">
					<a class="navbar-brand" href="<?php echo $base_url . $nav_link[0] . '?indice=' . 0; ?>">StockFarm</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="fa fa-bars"></span> Menu
					</button>
					<div class="collapse navbar-collapse" id="ftco-nav">
						<ul class="navbar-nav ml-auto mr-md-3">
							<?php
							for ($i = 0; $i < count($nav); $i++) {
								if ($i == $indice) {
							?>
									<li class="nav-item active"><a href="<?php echo $base_url . $nav_link[$i] . '?indice=' . $i; ?>" class="nav-link" style="font-size:larger;"><?php echo $nav[$i]; ?></a></li>
								<?php } else { ?>
									<li class="nav-item"><a href="<?php echo $base_url . $nav_link[$i] . '?indice=' . $i; ?>" class="nav-link" style="font-size:larger;"><?php echo $nav[$i]; ?></a></li>
								<?php } ?>
							<?php } ?>
						</ul>
					</div>
				</div>
			</nav>
		</div>

	</section>

	<script src="/Elevage/public/assets/css/header/js/jquery.min.js"></script>
	<script src="/Elevage/public/assets/css/header/js/popper.js"></script>
	<script src="/Elevage/public/assets/css/header/js/bootstrap.min.js"></script>
	<script src="/Elevage/public/assets/css/header/js/main.js"></script>

</body>