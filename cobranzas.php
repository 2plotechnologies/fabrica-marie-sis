<?php session_start();
if (!isset($_SESSION['id_Usuario'])) {
    header("Location: index.html");
    exit();
}
require 'backend/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cobranzas</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/sweetalert2.css">
	<link rel="stylesheet" href="css/material.min.css">
	<link rel="stylesheet" href="css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="css/main.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>
	<script src="js/material.min.js"></script>
	<script src="js/sweetalert2.min.js"></script>
	<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="js/main.js"></script>
</head>
<body>
	<?php include('menus/menu_superior.php'); ?>
	<?php include('menus/menu_lateral.php'); ?>

	<section class="full-width pageContent">
		<?php include('menus/menu_navbar.php'); ?>

		<section class="full-width header-well">
			<div class="full-width header-well-icon">
				<i class="zmdi zmdi-money"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					Gestión de Cobranzas: aquí puedes ver y marcar las cuotas como pagadas.
				</p>
			</div>
		</section>

		<div class="full-width divider-menu-h"></div>

		<!-- Cobranzas pendientes -->
		<h4>Cobranzas Pendientes</h4>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--12-col">
				<div class="table-responsive">
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width">
						<thead>
							<tr>
								<th class="mdl-data-table__cell--non-numeric">Fecha de Venta</th>
								<th>N° Cuota</th>
								<th>Monto</th>
								<th>Fecha de Pago</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = "SELECT c.Id, v.Fecha AS FechaVenta, c.Numero_Cuota, c.monto_cuota, c.fecha_pago
									FROM cobranzas c
									JOIN ventas v ON c.Id_Venta = v.Id
									WHERE c.pagado = 0
									ORDER BY v.Fecha DESC";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();

							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								echo "<tr>
										<td class='mdl-data-table__cell--non-numeric'>{$row['FechaVenta']}</td>
										<td>{$row['Numero_Cuota']}</td>
										<td>S/{$row['monto_cuota']}</td>
										<td>{$row['fecha_pago']}</td>
										<td>
											<button onclick='marcarPagado({$row['Id']})' class='mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect'>
												<i class='zmdi zmdi-check'></i>
											</button>
										</td>
									</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Cobranzas pagadas -->
		<h4>Cobranzas Pagadas</h4>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--12-col">
				<div class="table-responsive">
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width">
						<thead>
							<tr>
								<th class="mdl-data-table__cell--non-numeric">Fecha de Venta</th>
								<th>N° Cuota</th>
								<th>Monto</th>
								<th>Fecha de Pago</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = "SELECT v.Fecha AS FechaVenta, c.Numero_Cuota, c.monto_cuota, c.fecha_pago
									FROM cobranzas c
									JOIN ventas v ON c.Id_Venta = v.Id
									WHERE c.pagado = 1
									ORDER BY c.fecha_pago DESC";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();

							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								echo "<tr>
										<td class='mdl-data-table__cell--non-numeric'>{$row['FechaVenta']}</td>
										<td>{$row['Numero_Cuota']}</td>
										<td>S/{$row['monto_cuota']}</td>
										<td>{$row['fecha_pago']}</td>
									</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<script>
		function marcarPagado(id) {
			if (confirm("¿Marcar esta cuota como pagada?")) {
				fetch("backend/cobranzas/acciones.php", {
					method: "POST",
					headers: {
						"Content-Type": "application/x-www-form-urlencoded",
					},
					body: `accion=marcar_pagado&id=${id}`
				})
				.then(res => res.json())
				.then(data => {
					alert(data.mensaje);
					location.reload();
				})
				.catch(err => console.error("Error:", err));
			}
		}
	</script>
</body>
</html>
