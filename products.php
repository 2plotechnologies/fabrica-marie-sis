<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Products</title>
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
				<i class="zmdi zmdi-washing-machine"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
				Gestión de productos
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabNewProduct" class="mdl-tabs__tab is-active">Crear</a>
				<a href="#tabListProducts" class="mdl-tabs__tab">Listar</a>
			</div>
			<div class="mdl-tabs__panel is-active" id="tabNewProduct">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Nuevo producto
							</div>
							<div class="full-width panel-content">
								<form action = "backend/productos.php" method = "POST" enctype= multipart/form-data>
								<input type = "hidden" name = "accion" value = "crear">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Información basica</legend><br>
									    </div>
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="NameProduct" name="nombre">
												<label class="mdl-textfield__label" for="NameProduct">Nombre</label>
												<span class="mdl-textfield__error">Invalid name</span>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="StrockProduct" name="produccion">
												<label class="mdl-textfield__label" for="StrockProduct">Producción actual</label>
												<span class="mdl-textfield__error">Invalid number</span>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[0-9.]*(\.[0-9]+)?" id="PriceProduct" name="precio_unitario">
												<label class="mdl-textfield__label" for="PriceProduct">Precio Unitario</label>
												<span class="mdl-textfield__error">Invalid price</span>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[0-9.]*(\.[0-9]+)?" id="discountProduct" name="descuento">
												<label class="mdl-textfield__label" for="discountProduct">Descuento</label>
												<span class="mdl-textfield__error">Invalid discount</span>
											</div>	
										</div>
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Presentación</legend><br>
									    </div>
										<div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield">
											<select id="presentacion" name="id_presentacion" class="mdl-textfield__input">
													<option value="">-- Seleccionar --</option>
													<?php
														require 'backend/conexion.php';

														// Buscar todos los roles en la base de datos
														$stmt = $pdo->prepare("SELECT * FROM presentaciones"); // Asegúrate de que la tabla tenga estos campos
														$stmt->execute();
														
														// Recorrer los resultados y agregarlos al select
														while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
															echo "<option value='" . htmlspecialchars($row['Id']) . "'>" . htmlspecialchars($row['Presentacion']) . "</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos extra</legend><br>
									    </div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield">
												<input type="date" class="mdl-textfield__input" name="fecha_creacion">
											</div>
										</div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield">
												<select class="mdl-textfield__input" name="estado">
													<option value="" disabled="" selected="">Estado</option>
													<option value="1">Activo</option>
													<option value="0">Inactivo</option>
												</select>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield">
												<input type="file" name="imagen">
											</div>
										</div>
									</div>
									<p class="text-center">
										<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addProduct">
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addProduct">Add Product</div>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mdl-tabs__panel" id="tabListProducts">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
						<form action="#">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
								<label class="mdl-button mdl-js-button mdl-button--icon" for="searchProduct">
									<i class="zmdi zmdi-search"></i>
								</label>
								<div class="mdl-textfield__expandable-holder">
									<input class="mdl-textfield__input" type="text" id="searchProduct">
									<label class="mdl-textfield__label"></label>
								</div>
							</div>
						</form>
						<nav class="full-width menu-categories">
							<ul class="list-unstyle text-center">
								<li><a href="#" class="filter-presentacion" data-id="0">Todos</a></li>
								<?php
									require 'backend/conexion.php';
									$stmt1 = $pdo->prepare("SELECT * FROM presentaciones");
									$stmt1->execute();
									while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
								?>
								<li><a href="#" class="filter-presentacion" data-id="<?php echo $row1['Id']; ?>">
									<?php echo htmlspecialchars($row1['Presentacion']); ?>
								</a></li>
								<?php } ?>
							</ul>
						</nav>

						<div class="full-width text-center" style="padding: 30px 0;" id="productos-lista">
							<!-- Aquí se cargarán los productos filtrados -->
						</div>

					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$(".filter-presentacion").click(function(e){
					e.preventDefault(); // Evita la navegación predeterminada
					var idPresentacion = $(this).data("id");

					$.ajax({
						url: "backend/filtrar_productos.php",
						method: "POST",
						data: { id_presentacion: idPresentacion },
						success: function(response) {
							$("#productos-lista").html(response);
						},
						error: function() {
							alert("Error al cargar los productos.");
						}
					});
				});
			});
		</script>
	</section>
</body>
</html>