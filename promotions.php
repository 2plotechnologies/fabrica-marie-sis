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
	<title>Promociones</title>
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
				<i class="zmdi zmdi-card-giftcard"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					Aqui puedes gestionar las promociones
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabNewPromotion" class="mdl-tabs__tab is-active">Nuevo</a>
				<a href="#tabListPromotion" class="mdl-tabs__tab">Listar</a>
			</div>
			<div class="mdl-tabs__panel is-active" id="tabNewPromotion">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Nueva Promoción
							</div>
							<div class="full-width panel-content">
								<form action = "backend/promociones.php" method = "POST">
									<input type = "hidden" name = "accion" value = "crear">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos Promoción</legend><br>
									    </div>
									    <div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield">
											<select id="producto" name="id_producto" class="mdl-textfield__input">
													<option value="">-- Seleccionar producto --</option>
													<?php
														require 'backend/conexion.php';

														// Buscar todos los roles en la base de datos
														$stmt = $pdo->prepare("SELECT * FROM productos WHERE Estado = '1'"); // Asegúrate de que la tabla tenga estos campos
														$stmt->execute();
														
														// Recorrer los resultados y agregarlos al select
														while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
															echo "<option value='" . htmlspecialchars($row['Id']) . "'>" . htmlspecialchars($row['Nombre'])."</option>";
														}
													?>
												</select>
											</div>
										</div>
                                        <div class="mdl-cell mdl-cell--12-col">
                                            <div class="mdl-textfield mdl-js-textfield">
                                                <select id="presentacion" name="id_presentacion" class="mdl-textfield__input">
                                                    <option value="">-- Seleccionar presentación --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" id="cantidadPromotion" name = "cantidad">
												<label class="mdl-textfield__label" for="descriptionPromotion">Cantidad</label>
												<span class="mdl-textfield__error">Invalid quantity</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="descriptionPromotion" name = "descripcion">
												<label class="mdl-textfield__label" for="descriptionPromotion">Descripción</label>
												<span class="mdl-textfield__error">Invalid description</span>
											</div>
									    </div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[0-9.]*(\.[0-9]+)?" id="Mount" name="precio">
												<label class="mdl-textfield__label" for="PriceProduct">Nuevo Precio (S/)</label>
												<span class="mdl-textfield__error">Invalid mount</span>
											</div>
										</div>
									</div>
									<p class="text-center">
										<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addPromotion">
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addPromotion">Add Promotion</div>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mdl-tabs__panel" id="tabListPromotion">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--8-col-desktop mdl-cell--2-offset-desktop">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-success text-center tittles">
								Listar Promociones
							</div>
							<div class="full-width panel-content">
								<form action="#">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
										<label class="mdl-button mdl-js-button mdl-button--icon" for="searchPromotion">
											<i class="zmdi zmdi-search"></i>
										</label>
										<div class="mdl-textfield__expandable-holder">
											<input class="mdl-textfield__input" type="text" id="searchPromotion">
											<label class="mdl-textfield__label"></label>
										</div>
									</div>
								</form>
								<div class="mdl-list">
								<?php
									require 'backend/conexion.php';

									// Buscar todos los usuarios en la base de datos
									$stmt = $pdo->prepare("SELECT * FROM promociones"); // Asegúrate de que la tabla tenga estos campos
									$stmt->execute();
														
									// Recorrer los resultados y agregarlos a la lista
									while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									?>
									<div class="mdl-list__item mdl-list__item--two-line">
										<span class="mdl-list__item-primary-content">
											<i class="zmdi zmdi-card mdl-list__item-avatar"></i>
											<span><?php echo $row['Descripcion'] ?></span>
											<span class="mdl-list__item-sub-title">S/ <?php echo $row['Nuevo_Precio'] ?></span>
										</span>
										<button class="mdl-list__item-secondary-action" onclick="mostrarOpciones(this, <?php echo htmlspecialchars($row['Id']);?>)">
											<i class="zmdi zmdi-more"></i>
										</button>
										<div id="opciones-flotantes<?php echo htmlspecialchars($row['Id']);?>" class = "hidden">
											<button class="boton boton-verde" onclick="verDetalles(<?php echo htmlspecialchars($row['Id']);?>)">Ver detalles</button>
											<?php if($row['Estado'] == 1){?>
												<button class="boton boton-rojo" onclick="desactivarPromocion(<?php echo htmlspecialchars($row['Id']);?>)">Desactivar</button>
											<?php }else{?>
												<button class="boton boton-verde" onclick="activarPromocion(<?php echo htmlspecialchars($row['Id']);?>)">Activar</button>
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
	<div id="modalPromocion" class="modal hidden">
		<div class="modal-content">
			<span class="close" onclick="cerrarModal()">&times;</span>
			<h4>Detalles del Promoción</h4>

			<form id="formPromocion">
				<input type="hidden" id="promocionId" name="promocionId">
				<input type="hidden" id="accion" name="accion" value="actualizar">
				
				<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos Promoción</legend><br>
									    </div>
									    <div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="cantidadPromocion" name="cantidadPromocion">
												<label class="mdl-textfield__label" for="cantidadPromocion">Cantidad</label>
												<span class="mdl-textfield__error">Invalid number</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="descripcionPromocion" name = "descripcionPromocion">
												<label class="mdl-textfield__label" for="descipcionPromocion">Descripción</label>
												<span class="mdl-textfield__error">Invalid description</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[0-9.]*(\.[0-9]+)?" id="precioPromocion" name="preciopromo">
												<label class="mdl-textfield__label" for="precioPromocion">Nuevo Precio (S/)</label>
												<span class="mdl-textfield__error">Invalid mount</span>
											</div>
										</div>
										<label for="estado">Estado:</label>
										<input type="text" id="estadoPromocion" name="estado" class="input-field" disabled>
									</div>
				<button type="button" class="btn" onclick="actualizarPromocion()">Actualizar</button>
			</form>
		</div>
	</div>
    <script>
        document.getElementById("producto").addEventListener("change", function() {
            let productoId = this.value;
            let presentacionSelect = document.getElementById("presentacion");

            // Limpiar opciones anteriores
            presentacionSelect.innerHTML = '<option value="">-- Seleccionar presentación --</option>';

            if (productoId) {
                fetch('backend/presentaciones.php?id_producto=' + productoId + '&accion=obtener')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(presentacion => {
                            let option = document.createElement("option");
                            option.value = presentacion.Id;
                            option.textContent = presentacion.Presentacion + " - S/" + presentacion.Precio_Unitario;
                            presentacionSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

		function mostrarOpciones(boton, promocionId) {
				let menu = document.getElementById("opciones-flotantes" + promocionId);

				// Pasar el ID del promocion a las funciones
				menu.dataset.promocionId = promocionId;
				
				// Mostrar el menú flotante
				menu.classList.remove("hidden");
			}
			// Función para desactivar promocion
			function desactivarPromocion(id) {
				let promocionId = document.getElementById("opciones-flotantes" + id).dataset.promocionId;
				let confirmar = confirm("¿Seguro que deseas desactivar el promocion ID " + promocionId + "?");
				
				if (confirmar) {
					fetch("backend/promociones.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${promocionId}&accion=desactivar`
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

			// Función para activar promocion
			function activarPromocion(id) {
				let promocionId = document.getElementById("opciones-flotantes" + id).dataset.promocionId;
				let confirmar = confirm("¿Seguro que deseas activar el promocion ID " + promocionId + "?");
				
				if (confirmar) {
					fetch("backend/promociones.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${promocionId}&accion=activar`
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

			function verDetalles(idpromocion) {
				fetch("backend/promociones.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${idpromocion}&accion=obtener`
					})
					.then(response => response.json())
					.then(data => {
						// Cargar datos generales del promocion
						document.getElementById("promocionId").value = data.promocion.Id;
						document.getElementById("descripcionPromocion").value = data.promocion.Descripcion;
						document.getElementById("cantidadPromocion").value = data.promocion.Cantidad;
						document.getElementById("precioPromocion").value = data.promocion.Nuevo_Precio;
						if(data.promocion.Estado === 1){
							document.getElementById("estadoPromocion").value = "Activo";
						}else{
							document.getElementById("estadoPromocion").value = "Inactivo";
						}

						// Mostrar el modal
						document.getElementById("modalPromocion").style.display = "block";
						document.getElementById("modalPromocion").classList.remove("hidden");
					})
					.catch(error => console.error("Error al obtener promocion:", error));
		}
		function actualizarPromocion() {
			let formData = new FormData(document.getElementById("formPromocion"));
			//formData.append("accion", "actualizar");

			fetch("backend/promociones.php", {
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
			document.getElementById("modalPromocion").style.display = "none";
		}
    </script>
</body>
</html>