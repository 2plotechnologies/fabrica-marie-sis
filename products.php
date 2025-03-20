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
	</section>
	<!-- Modal -->
	<div id="modalProducto" class="modal hidden">
		<div class="modal-content">
			<span class="close" onclick="cerrarModal()">&times;</span>
			<h4>Detalles del Producto</h4>

			<form id="formProducto">
				<input type="hidden" id="productoId" name="productoId">
				<input type="hidden" id="accion" name="accion" value="actualizar">
				
				<label for="nombre">Nombre:</label>
				<input type="text" id="nombre" name="nombre" class="input-field">
				
				<label for="estado">Estado:</label>
				<input type="text" id="estado" name="estado" class="input-field" disabled>

				<button type="button" class="btn" onclick="actualizarProducto()">Actualizar</button>
			</form>

			<h5>Presentaciones</h5>
			<table class="styled-table">
				<thead>
					<tr>
						<th>Presentación</th>
						<th>Producción actual</th>
						<th>Precio Unitario</th>
						<th>Descuento</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="listaPresentaciones">
					<!-- Se llenará con JavaScript -->
				</tbody>
			</table>

			<h5>Asignar Nueva Presentación</h5>
			<form id="formPresentacion">
				<label for="selectPresentacion">Seleccionar Presentación:</label>
				<select id="selectPresentacion" name="id_presentacion" class="input-field">
					<!-- Se llenará con JavaScript -->
				</select>

				<label for="nuevoStock">Producción actual:</label>
				<input type="number" id="nuevoStock" name="produccion_actual" class="input-field">

				<label for="nuevoPrecio">Precio Unitario:</label>
				<input type="number" id="nuevoPrecio" name="precio_unitario" class="input-field">

				<label for="nuevoDescuento">Descuento:</label>
				<input type="number" id="nuevoDescuento" name="descuento" class="input-field">

				<button type="button" class="btn btn-secondary" onclick="asignarPresentacion()">Asignar Presentación</button>
			</form>
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
            
			function mostrarOpciones(boton, productoId) {
				let menu = document.getElementById("opciones-flotantes" + productoId);

				// Pasar el ID del producto a las funciones
				menu.dataset.productoId = productoId;
				
				// Mostrar el menú flotante
				menu.classList.remove("hidden");
			}
			// Función para desactivar producto
			function desactivarProducto(id) {
				let productoId = document.getElementById("opciones-flotantes" + id).dataset.productoId;
				let confirmar = confirm("¿Seguro que deseas desactivar el producto ID " + productoId + "?");
				
				if (confirmar) {
					fetch("backend/productos.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${productoId}&accion=desactivar`
					})
					.then(response => response.json()) // Convertir la respuesta en JSON
					.then(data => {
						alert(data.mensaje); // Mostrar el mensaje recibido
						document.getElementById("opciones-flotantes").classList.add("hidden");
					})
					.catch(error => console.error("Error:", error));
				}
			}

			// Función para activar producto
			function activarProducto(id) {
				let productoId = document.getElementById("opciones-flotantes" + id).dataset.productoId;
				let confirmar = confirm("¿Seguro que deseas activar el producto ID " + productoId + "?");
				
				if (confirmar) {
					fetch("backend/productos.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${productoId}&accion=activar`
					})
					.then(response => response.json()) // Convertir la respuesta en JSON
					.then(data => {
						alert(data.mensaje); // Mostrar el mensaje recibido
						document.getElementById("opciones-flotantes").classList.add("hidden");
					})
					.catch(error => console.error("Error:", error));
				}
			}

			// Ocultar menú flotante al hacer clic fuera
			document.addEventListener("click", function(event) {
				let menu = document.getElementById("opciones-flotantes" + productoId);
				if (!menu.contains(event.target) && !event.target.closest(".mdl-button")) {
					menu.classList.add("hidden");
				}
			});

			function verDetalles(idProducto) {
				fetch("backend/productos.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${idProducto}&accion=obtener`
					})
					.then(response => response.json())
					.then(data => {
						// Cargar datos generales del producto
						document.getElementById("productoId").value = data.producto.Id;
						document.getElementById("nombre").value = data.producto.Nombre;
						if(data.producto.Estado === 1){
							document.getElementById("estado").value = "Activo";
						}else{
							document.getElementById("estado").value = "Inactivo";
						}

						// Limpiar tabla de presentaciones
						let tabla = document.getElementById("listaPresentaciones");
						tabla.innerHTML = "";
						
						// Agregar las presentaciones
						data.presentaciones.forEach(presentacion => {
							let fila = `
								<tr>
									<td>${presentacion.Presentacion}</td>
									<td>${presentacion.Produccion_Actual}</td>
									<td>${presentacion.Precio_Unitario}</td>
									<td>${presentacion.Descuento}</td>
									<td><button class="boton boton-amarillo"><i class="zmdi zmdi-edit"></i></button> <button class="boton boton-rojo"><i class="zmdi zmdi-delete"></i></button></td>
								</tr>
							`;
							tabla.innerHTML += fila;
						});

						// Limpiar select de presentaciones
						let select = document.getElementById("selectPresentacion");
						select.innerHTML = "";
						
						// Agregar opciones al select
						data.opcionesPresentacion.forEach(option => {
							let opcion = `<option value="${option.Id}">${option.Presentacion}</option>`;
							select.innerHTML += opcion;
						});
						
						// Mostrar el modal
						document.getElementById("modalProducto").style.display = "block";
						document.getElementById("modalProducto").classList.remove("hidden");
					})
					.catch(error => console.error("Error al obtener producto:", error));
		}

		function cerrarModal() {
			document.getElementById("modalProducto").style.display = "none";
		}

		function asignarPresentacion() {
			let formData = new FormData(document.getElementById("formPresentacion"));
			formData.append("id_producto", document.getElementById("productoId").value);
			formData.append("accion", "asignar");

			fetch("backend/presentaciones.php", {
				method: "POST",
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				alert(data.mensaje);
				verDetalles(document.getElementById("productoId").value);
			})
			.catch(error => console.error("Error al asignar presentación:", error));
		}

		function actualizarProducto() {
			let formData = new FormData(document.getElementById("formProducto"));
			//formData.append("accion", "actualizar");

			fetch("backend/productos.php", {
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

			
		</script>
</body>
</html>