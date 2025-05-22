<?php session_start();
require 'backend/conexion.php';
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
	<title>Inicio</title>
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
		<section class="full-width text-center" style="padding: 40px 0;">
			<h3 class="text-center tittles">ESTADISTICAS GENERALES</h3>
			<!-- Tiles -->
			 <?php

			 // Buscar todos los roles en la base de datos
			 $stmt = $pdo->prepare("SELECT count(*) AS vendedores from usuarios where Id_Rol = 2;"); // Asegúrate de que la tabla tenga estos campos
			 $stmt->execute();
			 
			 // Recorrer los resultados y agregarlos al select
			 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				?>
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
					<?php echo $row['vendedores'] ?><br>
						<small>Vendedores</small>
					</span>
				</div>
				<i class="zmdi zmdi-account tile-icon"></i>
			</article>
			<?php } ?>
			<?php

			 // Buscar todos los roles en la base de datos
			 $stmt = $pdo->prepare("SELECT count(*) AS clientes from clientes where Estado = 1;"); // Asegúrate de que la tabla tenga estos campos
			 $stmt->execute();
			 
			 // Recorrer los resultados y agregarlos al select
			 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				?>
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
					<?php echo $row['clientes'] ?><br>
						<small>Clientes</small>
					</span>
				</div>
				<i class="zmdi zmdi-accounts tile-icon"></i>
			</article>
			<?php } ?>
			<?php

			 // Buscar todos los roles en la base de datos
			 $stmt = $pdo->prepare("SELECT count(*) AS prove from proveedores where Estado = 1;"); // Asegúrate de que la tabla tenga estos campos
			 $stmt->execute();
			 
			 // Recorrer los resultados y agregarlos al select
			 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				?>
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
					<?php echo $row['prove'] ?><br>
						<small>Proveedores</small>
					</span>
				</div>
				<i class="zmdi zmdi-truck tile-icon"></i>
			</article>
			<?php } ?>
			<?php

			 // Buscar todos los roles en la base de datos
			 $stmt = $pdo->prepare("SELECT count(*) AS presentaciones from presentaciones;"); // Asegúrate de que la tabla tenga estos campos
			 $stmt->execute();
			 
			 // Recorrer los resultados y agregarlos al select
			 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				?>
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
					<?php echo $row['presentaciones'] ?><br>
						<small>Presentaciones</small>
					</span>
				</div>
				<i class="zmdi zmdi-label tile-icon"></i>
			</article>
			<?php } ?>
			<?php

			 // Buscar todos los roles en la base de datos
			 $stmt = $pdo->prepare("SELECT count(*) AS prods from productos WHERE Estado = 1;"); // Asegúrate de que la tabla tenga estos campos
			 $stmt->execute();
			 
			 // Recorrer los resultados y agregarlos al select
			 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				?>
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
					<?php echo $row['prods'] ?><br>
						<small>Productos</small>
					</span>
				</div>
				<i class="zmdi zmdi-washing-machine tile-icon"></i>
			</article>
			<?php } ?>
			<?php

			 // Buscar todos los roles en la base de datos
			 $stmt = $pdo->prepare("SELECT count(*) AS ventas from ventas;"); // Asegúrate de que la tabla tenga estos campos
			 $stmt->execute();
			 
			 // Recorrer los resultados y agregarlos al select
			 while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				?>
			<article class="full-width tile">
				<div class="tile-text">
					<span class="text-condensedLight">
					<?php echo $row['ventas'] ?><br>
						<small>Ventas</small>
					</span>
				</div>
				<i class="zmdi zmdi-shopping-cart tile-icon"></i>
			</article>
			<?php } ?>
		</section>
		<section class="full-width" style="margin: 30px 0;">
			<h3 class="text-center tittles">Notificaciones de Pagos Pendientes</h3>
			<div id="timeline-c" class="timeline-c">
				<?php
				require 'backend/conexion.php';
				$hoy = new DateTime();

				$stmt = $pdo->prepare("
					SELECT co.*, v.Fecha AS fecha_venta, c.NombreCliente 
					FROM cobranzas co
					INNER JOIN ventas v ON co.Id_Venta = v.Id
					INNER JOIN clientes c ON v.Id_Cliente = c.Id
					WHERE co.pagado = 0
					ORDER BY co.fecha_pago ASC
				");
				$stmt->execute();

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$fecha_pago = new DateTime($row['fecha_pago']);
					$dias_restantes = (int)$hoy->diff($fecha_pago)->format('%r%a');
					
					if ($dias_restantes <= 5) {
						$estado = $dias_restantes < 0 ? 'Pago vencido' : 'Pago pendiente';
						$color = $dias_restantes < 0 ? 'bg-danger' : 'bg-warning';
						$icono = $dias_restantes < 0 ? 'zmdi-alert-circle' : 'zmdi-time-restore';

						echo '
						<div class="timeline-c-box">
							<div class="timeline-c-box-icon '.$color.'">
								<i class="zmdi '.$icono.'"></i>
							</div>
							<div class="timeline-c-box-content">
								<h4 class="text-center text-condensedLight">'.$estado.'</h4>
								<p class="text-center">
									Cliente: <strong>'.$row['NombreCliente'].'</strong><br>
									N° de cuota: <strong>'.$row['Numero_Cuota'].'</strong><br>
									Monto: <strong>S/'.$row['monto_cuota'].'</strong>
								</p>
								<span class="timeline-date">
									<i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> '.$fecha_pago->format('d-m-Y').'
								</span>
							</div>
						</div>';
					}
				}
				?>
			</div>
		</section>

	</section>
</body>
</html>