<?php session_start();
if (!isset($_SESSION['id_Usuario'])) {
    // Si no hay sesión activa, redirige al login
    header("Location: index.html");
    exit(); // Importante: detener el script después de redirigir
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inventory</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/sweetalert2.css">
	<link rel="stylesheet" href="css/material.min.css">
	<link rel="stylesheet" href="css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="css/main.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>
	<script src="js/material.min.js" ></script>
	<script src="js/sweetalert2.min.js" ></script>
	<script src="js/jquery.mCustomScrollbar.concat.min.js" ></script>
	<script src="js/main.js" ></script>
</head>
<body>
	<!-- Notifications area -->
	<?php include('menus/menu_superior.php'); ?>
	<!-- navLateral -->
	<?php include('menus/menu_lateral.php'); ?>
	<!-- pageContent -->
	<section class="full-width pageContent">
		<!-- navBar -->
		<?php include('menus/menu_navbar.php'); ?>
		<section class="full-width header-well">
			<div class="full-width header-well-icon">
				<i class="zmdi zmdi-store"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde aut nulla accusantium minus corporis accusamus fuga harum natus molestias necessitatibus.
				</p>
			</div>
		</section>
		<div class="full-width divider-menu-h"></div>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
				<div class="table-responsive">
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
						<thead>
							<tr>
								<th class="mdl-data-table__cell--non-numeric">Name</th>
								<th>Code</th>
								<th>Stock</th>
								<th>Price</th>
								<th>Options</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">Product Name</td>
								<td>Product Code</td>
								<td>7</td>
								<td>$77</td>
								<td><button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect"><i class="zmdi zmdi-more"></i></button></td>
							</tr>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">Product Name</td>
								<td>Product Code</td>
								<td>7</td>
								<td>$77</td>
								<td><button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect"><i class="zmdi zmdi-more"></i></button></td>
							</tr>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">Product Name</td>
								<td>Product Code</td>
								<td>7</td>
								<td>$77</td>
								<td><button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect"><i class="zmdi zmdi-more"></i></button></td>
							</tr>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">Product Name</td>
								<td>Product Code</td>
								<td>7</td>
								<td>$77</td>
								<td><button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect"><i class="zmdi zmdi-more"></i></button></td>
							</tr>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">Product Name</td>
								<td>Product Code</td>
								<td>7</td>
								<td>$77</td>
								<td><button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect"><i class="zmdi zmdi-more"></i></button></td>
							</tr>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">Product Name</td>
								<td>Product Code</td>
								<td>7</td>
								<td>$77</td>
								<td><button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect"><i class="zmdi zmdi-more"></i></button></td>
							</tr>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">Product Name</td>
								<td>Product Code</td>
								<td>7</td>
								<td>$77</td>
								<td><button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect"><i class="zmdi zmdi-more"></i></button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</body>
</html>