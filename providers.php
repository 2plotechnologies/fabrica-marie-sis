<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Proveedores</title>
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
				<i class="zmdi zmdi-truck"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					Gestión de proveedores
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabNewProvider" class="mdl-tabs__tab is-active">Nuevo</a>
				<a href="#tabListProvider" class="mdl-tabs__tab">Listar</a>
			</div>
			<div class="mdl-tabs__panel is-active" id="tabNewProvider">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Nuevo proveedor
							</div>
							<div class="full-width panel-content">
								<form action = "backend/proveedores.php" method = "POST">
									<input type = "hidden" name = "accion" value = "crear">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos proveedor</legend><br>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="DNIProvider" name = "ruc">
												<label class="mdl-textfield__label" for="DNIProvider">RUC</label>
												<span class="mdl-textfield__error">Invalid number</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-z0-9 ]*(\.[0-9]+)?" id="NameProvider" name = "razon_social">
												<label class="mdl-textfield__label" for="NameProvider">Razón Social</label>
												<span class="mdl-textfield__error">Invalid Razón Social</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="addressProvider" name = "direccion">
												<label class="mdl-textfield__label" for="addressProvider">Dirección</label>
												<span class="mdl-textfield__error">Invalid address</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="tel" pattern="-?[0-9+()- ]*(\.[0-9]+)?" id="phoneProvider" name = "telefono">
												<label class="mdl-textfield__label" for="phoneProvider">Telefono</label>
												<span class="mdl-textfield__error">Invalid phone number</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="email" id="emailProvider" name = "correo">
												<label class="mdl-textfield__label" for="emailProvider">Correo</label>
												<span class="mdl-textfield__error">Invalid E-mail</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="webProvider" name = "web">
												<label class="mdl-textfield__label" for="webProvider">Web (Opcional)</label>
												<span class="mdl-textfield__error">Invalid web address</span>
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
									</div>
									<p class="text-center">
										<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addProvider">
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addProvider">Add provider</div>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mdl-tabs__panel" id="tabListProvider">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--8-col-desktop mdl-cell--2-offset-desktop">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-success text-center tittles">
								Listar Proveedores
							</div>
							<div class="full-width panel-content">
								<form action="#">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
										<label class="mdl-button mdl-js-button mdl-button--icon" for="searchProvider">
											<i class="zmdi zmdi-search"></i>
										</label>
										<div class="mdl-textfield__expandable-holder">
											<input class="mdl-textfield__input" type="text" id="searchProvider">
											<label class="mdl-textfield__label"></label>
										</div>
									</div>
								</form>
								<div class="mdl-list">
								<?php
									require 'backend/conexion.php';

									// Buscar todos los usuarios en la base de datos
									$stmt = $pdo->prepare("SELECT * FROM proveedores"); // Asegúrate de que la tabla tenga estos campos
									$stmt->execute();
														
									// Recorrer los resultados y agregarlos a la lista
									while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									?>
									<div class="mdl-list__item mdl-list__item--two-line">
										<span class="mdl-list__item-primary-content">
											<i class="zmdi zmdi-truck mdl-list__item-avatar"></i>
											<span><?php echo $row['Razon_Social'] ?></span>
											<span class="mdl-list__item-sub-title"><?php echo $row['RUC'] ?></span>
										</span>
										<button class="mdl-list__item-secondary-action" onclick="mostrarOpciones(this, <?php echo htmlspecialchars($row['Id']);?>)">
											<i class="zmdi zmdi-more"></i>
										</button>
										<div id="opciones-flotantes<?php echo htmlspecialchars($row['Id']);?>" class = "hidden">
											<button class="boton boton-verde" onclick="verDetalles(<?php echo htmlspecialchars($row['Id']);?>)">Ver detalles</button>
											<?php if($row['Estado'] == 1){?>
												<button class="boton boton-rojo" onclick="desactivarProveedor(<?php echo htmlspecialchars($row['Id']);?>)">Desactivar</button>
											<?php }else{?>
												<button class="boton boton-verde" onclick="activarProveedor(<?php echo htmlspecialchars($row['Id']);?>)">Activar</button>
											<?php } ?>
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
	<div id="modalProveedor" class="modal hidden">
		<div class="modal-content">
			<span class="close" onclick="cerrarModal()">&times;</span>
			<h4>Detalles del Proveedor</h4>

			<form id="formProveedor">
				<input type="hidden" id="proveedorId" name="proveedorId">
				<input type="hidden" id="accion" name="accion" value="actualizar">
				
				<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos Proveedor</legend><br>
									    </div>
									    <div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="RUCProveedor" name="nruc">
												<label class="mdl-textfield__label" for="RUCProveedor">RUC</label>
												<span class="mdl-textfield__error">Invalid RUC</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="NameProveedor" name = "nombreProveedor">
												<label class="mdl-textfield__label" for="NameProveedor">Razón Social</label>
												<span class="mdl-textfield__error">Invalid name</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="addressProveedor" name = "direccionProveedor">
												<label class="mdl-textfield__label" for="addressProveedor">Direccion</label>
												<span class="mdl-textfield__error">Invalid address</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="tel" pattern="-?[0-9+()- ]*(\.[0-9]+)?" id="phoneProveedor" name = "telefonoProveedor">
												<label class="mdl-textfield__label" for="phoneProveedor">Telefono</label>
												<span class="mdl-textfield__error">Invalid phone number</span>
											</div>
									    </div>
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="webProveedor" name = "webProveedor">
												<label class="mdl-textfield__label" for="webProveedor">WEB</label>
												<span class="mdl-textfield__error">Invalid web</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="email" id="emailProveedor" name = "correoProveedor">
												<label class="mdl-textfield__label" for="emailProveedor">E-mail</label>
												<span class="mdl-textfield__error">Invalid E-mail</span>
											</div>
									    </div>
										<label for="estado">Estado:</label>
										<input type="text" id="estadoProveedor" name="estado" class="input-field" disabled>
									</div>
				<button type="button" class="btn" onclick="actualizarProveedor()">Actualizar</button>
			</form>
		</div>
	</div>
	<script>
		function mostrarOpciones(boton, proveedorId) {
				let menu = document.getElementById("opciones-flotantes" + proveedorId);

				// Pasar el ID del proveedor a las funciones
				menu.dataset.proveedorId = proveedorId;
				
				// Mostrar el menú flotante
				menu.classList.remove("hidden");
			}
			// Función para desactivar proveedor
			function desactivarProveedor(id) {
				let proveedorId = document.getElementById("opciones-flotantes" + id).dataset.proveedorId;
				let confirmar = confirm("¿Seguro que deseas desactivar el proveedor ID " + proveedorId + "?");
				
				if (confirmar) {
					fetch("backend/proveedores.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${proveedorId}&accion=desactivar`
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

			// Función para activar proveedor
			function activarProveedor(id) {
				let proveedorId = document.getElementById("opciones-flotantes" + id).dataset.proveedorId;
				let confirmar = confirm("¿Seguro que deseas activar el proveedor ID " + proveedorId + "?");
				
				if (confirmar) {
					fetch("backend/proveedores.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${proveedorId}&accion=activar`
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

			function verDetalles(idproveedor) {
				fetch("backend/proveedores.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${idproveedor}&accion=obtener`
					})
					.then(response => response.json())
					.then(data => {
						// Cargar datos generales del proveedor
						document.getElementById("proveedorId").value = data.proveedor.Id;
						document.getElementById("RUCProveedor").value = data.proveedor.RUC;
						document.getElementById("NameProveedor").value = data.proveedor.Razon_Social;
						document.getElementById("addressProveedor").value = data.proveedor.Direccion;
						document.getElementById("phoneProveedor").value = data.proveedor.Telefono;
						document.getElementById("emailProveedor").value = data.proveedor.Correo;
						document.getElementById("webProveedor").value = data.proveedor.Web;
						if(data.proveedor.Estado === 1){
							document.getElementById("estadoProveedor").value = "Activo";
						}else{
							document.getElementById("estadoProveedor").value = "Inactivo";
						}

						// Mostrar el modal
						document.getElementById("modalProveedor").style.display = "block";
						document.getElementById("modalProveedor").classList.remove("hidden");
					})
					.catch(error => console.error("Error al obtener proveedor:", error));
		}
		function actualizarProveedor() {
			let formData = new FormData(document.getElementById("formProveedor"));
			//formData.append("accion", "actualizar");

			fetch("backend/proveedores.php", {
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
			document.getElementById("modalproveedor").style.display = "none";
		}
	</script>
</body>
</html>