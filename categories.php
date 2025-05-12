<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Presentaciones</title>
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
	<style>
		.opciones-flotantes {
			position: absolute;
			background: white;
			box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
			padding: 10px;
			border-radius: 5px;
			display: none;
		}
		.hidden {
			display: none;
		}

		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			justify-content: center;
			align-items: center;
			overflow-y: auto;
		}

		.modal-content {
			background: white;
			padding: 20px;
			width: 40%;
			max-width: 600px;
			margin: auto;
			border-radius: 10px;
			box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
			overflow-y: auto;
		}

		.close {
			float: right;
			font-size: 24px;
			cursor: pointer;
		}

		h2, h3 {
			text-align: center;
			color: #333;
		}

		.input-field {
			width: 90%;
			padding: 10px;
			margin: 5px 0;
			border: 1px solid #ccc;
			border-radius: 5px;
			font-size: 16px;
		}

		.btn {
			width: 100%;
			padding: 10px;
			margin-top: 10px;
			border: none;
			border-radius: 5px;
			background: #007BFF;
			color: white;
			font-size: 16px;
			cursor: pointer;
		}

		.btn:hover {
			background: #0056b3;
		}

		.btn-secondary {
			background: #28a745;
		}

		.btn-secondary:hover {
			background: #218838;
		}

		.styled-table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 10px;
			overflow-y: auto;
		}

		.styled-table th, .styled-table td {
			padding: 10px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		.styled-table th {
			background: #f4f4f4;
		}

	</style>
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
				<i class="zmdi zmdi-label"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					Aqui puedes administrar las diferentes presentaciones de cada producto
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabNewCategory" class="mdl-tabs__tab is-active">Nueva</a>
				<a href="#tabListCategory" class="mdl-tabs__tab">Listar</a>
			</div>
			<div class="mdl-tabs__panel is-active" id="tabNewCategory">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Nueva presentación
							</div>
							<div class="full-width panel-content">
								<form action = "backend/presentaciones.php" method = "POST">
									<input type = "hidden" name = "accion" value = "crear">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos de la presentación</legend><br>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="NameCategory" name = "nombre">
												<label class="mdl-textfield__label" for="NameCategory">Nombre</label>
												<span class="mdl-textfield__error">Invalid name</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="descriptionCategory" name = "descripcion" >
												<label class="mdl-textfield__label" for="descriptionCategory">Descripción</label>
												<span class="mdl-textfield__error">Invalid description</span>
											</div>
									    </div>
									</div>
									<p class="text-center">
										<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addCategory">
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addCategory">Add category</div>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mdl-tabs__panel" id="tabListCategory">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--8-col-desktop mdl-cell--2-offset-desktop">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-success text-center tittles">
								Listar presentaciones
							</div>
							<div class="full-width panel-content">
								<form action="#">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
										<label class="mdl-button mdl-js-button mdl-button--icon" for="searchCategory">
											<i class="zmdi zmdi-search"></i>
										</label>
										<div class="mdl-textfield__expandable-holder">
											<input class="mdl-textfield__input" type="text" id="searchCategory">
											<label class="mdl-textfield__label"></label>
										</div>
									</div>
								</form>
								<div class="mdl-list">
								<?php
									require 'backend/conexion.php';

									// Buscar todos los usuarios en la base de datos
									$stmt = $pdo->prepare("SELECT * FROM presentaciones"); // Asegúrate de que la tabla tenga estos campos
									$stmt->execute();
														
									// Recorrer los resultados y agregarlos a la lista
									while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									
								?>
									<div class="mdl-list__item mdl-list__item--two-line">
										<span class="mdl-list__item-primary-content">
											<i class="zmdi zmdi-label mdl-list__item-avatar"></i>
											<span><?php echo $row['Presentacion'] ?></span>
											<span class="mdl-list__item-sub-title"><?php echo $row['Descripcion'] ?></span>
										</span>
										<button class="mdl-list__item-secondary-action" onclick="mostrarOpciones(this, <?php echo htmlspecialchars($row['Id']);?>)">
											<i class="zmdi zmdi-more"></i>
										</button>
										<div id="opciones-flotantes<?php echo htmlspecialchars($row['Id']);?>" class = "hidden">
											<button class="boton boton-verde" onclick="verDetalles(<?php echo htmlspecialchars($row['Id']);?>)">Ver detalles</button>
												<button class="boton boton-rojo" onclick="eliminarPresentacion(<?php echo htmlspecialchars($row['Id']);?>)">Eliminar</button>
										</div>
									</div>
									<li class="full-width divider-menu-h"></li>
									<?php } ?>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</section>
	<div id="modalPresentacion" class="modal hidden">
		<div class="modal-content">
			<span class="close" onclick="cerrarModal()">&times;</span>
			<h4>Detalles de la Presentación</h4>

			<form id="formPresentacion">
				<input type="hidden" id="presentacionId" name="presentacionId">
				<input type="hidden" id="accion" name="accion" value="actualizar">
				
				<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos Presentación</legend><br>
									    </div>
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="NamePresentacion" name = "nombrePresentacion">
												<label class="mdl-textfield__label" for="NamePresentacion">Presentación</label>
												<span class="mdl-textfield__error">Invalid Presentación</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="DescripcionPresentacion" name = "descripcionPresentacion">
												<label class="mdl-textfield__label" for="DescripcionPresentacion">Descripción</label>
												<span class="mdl-textfield__error">Invalid Descripción</span>
											</div>
									    </div>
									</div>
				<button type="button" class="btn" onclick="actualizarPresentacion()">Actualizar</button>
			</form>
		</div>
	</div>
	<script>
		function mostrarOpciones(boton, presentacionId) {
				let menu = document.getElementById("opciones-flotantes" + presentacionId);

				// Pasar el ID del presentacion a las funciones
				menu.dataset.presentacionId = presentacionId;
				
				// Mostrar el menú flotante
				menu.classList.remove("hidden");
			}
			// Función para desactivar presentacion
			function eliminarPresentacion(id) {
				let presentacionId = document.getElementById("opciones-flotantes" + id).dataset.presentacionId;
				let confirmar = confirm("¿Seguro que deseas desactivar la presentacion ID " + presentacionId + "?");
				
				if (confirmar) {
					fetch("backend/presentaciones.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${presentacionId}&accion=eliminar`
					})
					.then(response => response.json()) // Convertir la respuesta en JSON
					.then(data => {
						alert(data.mensaje); // Mostrar el mensaje recibido
						//document.getElementById("opciones-flotantes").classList.add("hidden");
						window.location.reload();
					})
					.catch(error => console.error("Error:", error));
				}
			}

			function verDetalles(idpresentacion) {
				fetch("backend/presentaciones.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${idpresentacion}&accion=obtener`
					})
					.then(response => response.json())
					.then(data => {
						// Cargar datos generales del presentacion
						document.getElementById("presentacionId").value = data.presentacion.Id;
						document.getElementById("NamePresentacion").value = data.presentacion.Presentacion;
						document.getElementById("DescripcionPresentacion").value = data.presentacion.Descripcion;

						// Mostrar el modal
						document.getElementById("modalPresentacion").style.display = "block";
						document.getElementById("modalPresentacion").classList.remove("hidden");
					})
					.catch(error => console.error("Error al obtener presentacion:", error));
		}
		function actualizarPresentacion() {
			let formData = new FormData(document.getElementById("formPresentacion"));
			//formData.append("accion", "actualizar");

			fetch("backend/presentaciones.php", {
				method: "POST",
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				alert(data.mensaje);
				cerrarModal();
				location.reload(); // Recargar la página para ver los cambios
			})
			.catch(error => console.error("Error al actualizar:", error));
		}

		function cerrarModal() {
			document.getElementById("modalPresentacion").style.display = "none";
		}
	</script>
</body>
</html>