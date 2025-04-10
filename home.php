<?php session_start();
require 'backend/conexion.php'; ?>

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
			<h3 class="text-center tittles">RESPONSIVE TIMELINE</h3>
			<!-- TimeLine -->
			<div id="timeline-c" class="timeline-c">
				<div class="timeline-c-box">
	                <div class="timeline-c-box-icon bg-info">
	                    <i class="zmdi zmdi-twitter"></i>
	                </div>
	                <div class="timeline-c-box-content">
	                    <h4 class="text-center text-condensedLight">Tittle timeline</h4>
	                    <p class="text-center">
	                    	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta nobis rerum iure nostrum dolor. Quo totam possimus, ex, sapiente rerum vel maxime fugiat, ipsam blanditiis veniam, suscipit labore excepturi veritatis.
	                    </p>
	                    <span class="timeline-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>05-04-2016</span>
	                </div>
	            </div>
				<div class="timeline-c-box">
	                <div class="timeline-c-box-icon bg-success">
	                    <i class="zmdi zmdi-whatsapp"></i>
	                </div>
	                <div class="timeline-c-box-content">
	                    <h4 class="text-center text-condensedLight">Tittle timeline</h4>
	                    <p class="text-center">
	                    	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta nobis rerum iure nostrum dolor. Quo totam possimus, ex, sapiente rerum vel maxime fugiat, ipsam blanditiis veniam, suscipit labore excepturi veritatis.
	                    </p>
	                    <span class="timeline-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>06-04-2016</span>
	                </div>
	            </div>
	            <div class="timeline-c-box">
	                <div class="timeline-c-box-icon bg-primary">
	                    <i class="zmdi zmdi-facebook"></i>
	                </div>
	                <div class="timeline-c-box-content">
	                    <h4 class="text-center text-condensedLight">Tittle timeline</h4>
	                    <p class="text-center">
	                    	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta nobis rerum iure nostrum dolor. Quo totam possimus, ex, sapiente rerum vel maxime fugiat, ipsam blanditiis veniam, suscipit labore excepturi veritatis.
	                    </p>
	                    <span class="timeline-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>07-04-2016</span>
	                </div>
	            </div>
	            <div class="timeline-c-box">
	                <div class="timeline-c-box-icon bg-danger">
	                    <i class="zmdi zmdi-youtube"></i>
	                </div>
	                <div class="timeline-c-box-content">
	                    <h4 class="text-center text-condensedLight">Tittle timeline</h4>
	                    <p class="text-center">
	                    	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta nobis rerum iure nostrum dolor. Quo totam possimus, ex, sapiente rerum vel maxime fugiat, ipsam blanditiis veniam, suscipit labore excepturi veritatis.
	                    </p>
	                    <span class="timeline-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>08-04-2016</span>
	                </div>
	            </div>
			</div>
		</section>
	</section>
</body>
</html>