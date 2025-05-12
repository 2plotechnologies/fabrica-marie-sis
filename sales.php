<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sales</title>
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
				<i class="zmdi zmdi-shopping-cart"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					En este apartado puedes gestionar las ventas
				</p>
			</div>
		</section>
		<div class="full-width divider-menu-h"></div>
		<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" href="new_sale.php">
				Nueva Venta
			</a>
		</div>
			<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
				<div class="table-responsive">
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width table-responsive">
						<thead>
							<tr>
								<th class="mdl-data-table__cell--non-numeric">Fecha</th>
								<th>Cliente</th>
								<th>Tipo Pago</th>
								<th>Total</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
						<?php
								require 'backend/conexion.php';

								// Buscar todos los usuarios en la base de datos
								$stmt = $pdo->prepare("SELECT v.Id, v.Fecha, c.NombreCliente AS Cliente, v.Tipo_Pago, v.Total
									FROM ventas v
									JOIN clientes c ON v.Id_Cliente = c.Id
									ORDER BY v.Fecha DESC"); // Asegúrate de que la tabla tenga estos campos
								$stmt->execute();
														
								// Recorrer los resultados y agregarlos a la lista
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								?>
							<tr>
								<td class="mdl-data-table__cell--non-numeric"><?php echo $row['Fecha'] ?></td>
								<td><?php echo $row['Cliente'] ?></td>
								<td><?php if($row['Tipo_Pago'] == '1'){echo "Efectivo";}else{echo "Tarjeta";}  ?></td>
								<td>S/<?php echo $row['Total'] ?></td>
								<td><button onclick="eliminarVenta(<?php echo $row['Id'] ?>)" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect"><i class="zmdi zmdi-delete"></i></button></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<script>
		function eliminarVenta(id) {
					let confirmar = confirm("¿Seguro que deseas eliminar la venta ID " + id + "?");
					
					if (confirmar) {
						fetch("backend/ventas/acciones.php", {
							method: "POST",
							headers: {
								"Content-Type": "application/x-www-form-urlencoded",
							},
							body: `id=${id}&accion=eliminar`
						})
						.then(response => response.json()) // Convertir la respuesta en JSON
						.then(data => {
							alert(data.mensaje); // Mostrar el mensaje recibido
							window.location.reload();
						})
						.catch(error => console.error("Error:", error));
					}
				}
	</script>
</body>
</html>