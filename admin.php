<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Usuarios</title>
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
				<i class="zmdi zmdi-account"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
				Gestión de usuarios del sistema
				</p>
			</div>
		</section>
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
			<div class="mdl-tabs__tab-bar">
				<a href="#tabNewAdmin" class="mdl-tabs__tab is-active">NEW</a>
				<a href="#tabListAdmin" class="mdl-tabs__tab">LIST</a>
			</div>
			<div class="mdl-tabs__panel is-active" id="tabNewAdmin">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-primary text-center tittles">
								Crear usuario
							</div>
							<div class="full-width panel-content">
								<form action = "backend/guardar_usuario.php" method = "POST">
									<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos del usuario</legend><br>
									    </div>
									    <div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="DNIAdmin" name="dni">
												<label class="mdl-textfield__label" for="DNIAdmin">DNI</label>
												<span class="mdl-textfield__error">Invalid number</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-záéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="NameAdmin" name="nombre">
												<label class="mdl-textfield__label" for="NameAdmin">Nombre</label>
												<span class="mdl-textfield__error">Invalid name</span>
											</div>
									    </div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="tel" pattern="-?[0-9+()- ]*(\.[0-9]+)?" id="phoneAdmin" name="telefono">
												<label class="mdl-textfield__label" for="phoneAdmin">Telefono</label>
												<span class="mdl-textfield__error">Invalid phone number</span>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="email" id="emailAdmin" name="correo">
												<label class="mdl-textfield__label" for="emailAdmin">Correo</label>
												<span class="mdl-textfield__error">Invalid E-mail</span>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Detalles del usuario</legend><br>
									    </div>
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<select id="rol" name="id_rol" class="mdl-textfield__input">
													<option value="">-- Seleccionar --</option>
													<?php
														require 'backend/conexion.php';

														// Buscar todos los roles en la base de datos
														$stmt = $pdo->prepare("SELECT * FROM roles"); // Asegúrate de que la tabla tenga estos campos
														$stmt->execute();
														
														// Recorrer los resultados y agregarlos al select
														while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
															echo "<option value='" . htmlspecialchars($row['Id']) . "'>" . htmlspecialchars($row['Descripcion']) . "</option>";
														}
													?>
												</select>
												<label class="mdl-textfield__label">Selecciona un rol:</label>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="password" id="passwordAdmin" name = "password">
												<label class="mdl-textfield__label" for="passwordAdmin">Password</label>
												<span class="mdl-textfield__error">Invalid password</span>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<select class="mdl-textfield__input" id="estadoAdmin" name="estado">
													<option value="1">
														Activo
													</option>
													<option value="0">
														Inactivo
													</option>
												</select>
												<label class="mdl-textfield__label">Estado</label>
											</div>
										</div>
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Escoger foto</legend><br>
									    </div>
										<div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet">
											<div class="mdl-grid">
												<div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone">
													<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
														<input type="radio" id="option-1" class="mdl-radio__button" name="options" value="avatar-male.png">
														<img src="assets/img/avatar-male.png" alt="avatar" style="height: 45px; width="45px;" ">
														<span class="mdl-radio__label">Avatar 1</span>
													</label>
											    </div>
											    <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone">
													<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
														<input type="radio" id="option-2" class="mdl-radio__button" name="options" value="avatar-female.png">
														<img src="assets/img/avatar-female.png" alt="avatar" style="height: 45px; width="45px;" ">
														<span class="mdl-radio__label">Avatar 2</span>
													</label>
											    </div>
											    <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone">
													<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-3">
														<input type="radio" id="option-3" class="mdl-radio__button" name="options" value="avatar-male2.png">
														<img src="assets/img/avatar-male2.png" alt="avatar" style="height: 45px; width="45px;" ">
														<span class="mdl-radio__label">Avatar 3</span>
													</label>
											    </div>
											    <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone">
													<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-4">
														<input type="radio" id="option-4" class="mdl-radio__button" name="options" value="avatar-female2.png">
														<img src="assets/img/avatar-female2.png" alt="avatar" style="height: 45px; width="45px;" ">
														<span class="mdl-radio__label">Avatar 4</span>
													</label>
											    </div>
											</div>
										</div>
									</div>
									<p class="text-center">
										<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addAdmin">
											<i class="zmdi zmdi-plus"></i>
										</button>
										<div class="mdl-tooltip" for="btn-addAdmin">Add Administrator</div>
									</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="mdl-tabs__panel" id="tabListAdmin">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--8-col-desktop mdl-cell--2-offset-desktop">
						<div class="full-width panel mdl-shadow--2dp">
							<div class="full-width panel-tittle bg-success text-center tittles">
								Lista de usuarios
							</div>
							<div class="full-width panel-content">
								<form action="#">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
										<label class="mdl-button mdl-js-button mdl-button--icon" for="searchAdmin">
											<i class="zmdi zmdi-search"></i>
										</label>
										<div class="mdl-textfield__expandable-holder">
											<input class="mdl-textfield__input" type="text" id="searchAdmin">
											<label class="mdl-textfield__label"></label>
										</div>
									</div>
								</form>
								<div class="mdl-list">
								<?php
									require 'backend/conexion.php';

									// Buscar todos los usuarios en la base de datos
									$stmt = $pdo->prepare("SELECT * FROM usuarios"); // Asegúrate de que la tabla tenga estos campos
									$stmt->execute();
														
									// Recorrer los resultados y agregarlos a la lista
									while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									
								?>
									<div class="mdl-list__item mdl-list__item--two-line">
										<span class="mdl-list__item-primary-content">
											<img src = "assets/img/<?php echo $row['Avatar'] ?>" style = "width: 50px;">
											<span><?php echo $row['Nombre'] ?></span>
											<span class="mdl-list__item-sub-title"><?php echo $row['DNI'] ?></span>
										</span>
										<button class="mdl-list__item-secondary-action" onclick="mostrarOpciones(this, <?php echo htmlspecialchars($row['Id']);?>)">
											<i class="zmdi zmdi-more"></i>
										</button>
										<div id="opciones-flotantes<?php echo htmlspecialchars($row['Id']);?>" class = "hidden">
											<button class="boton boton-verde" onclick="verDetalles(<?php echo htmlspecialchars($row['Id']);?>)">Ver detalles</button>
											<?php if($row['Estado'] == 1){?>
												<button class="boton boton-rojo" onclick="desactivarUsuario(<?php echo htmlspecialchars($row['Id']);?>)">Desactivar</button>
											<?php }else{?>
												<button class="boton boton-verde" onclick="activarUsuario(<?php echo htmlspecialchars($row['Id']);?>)">Activar</button>
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
	<div id="modalusuario" class="modal hidden">
		<div class="modal-content">
			<span class="close" onclick="cerrarModal()">&times;</span>
			<h4>Detalles del usuario</h4>

			<form id="formusuario">
				<input type="hidden" id="usuarioId" name="usuarioId">
				<input type="hidden" id="accion" name="accion" value="actualizar">
				
				<div class="mdl-grid">
										<div class="mdl-cell mdl-cell--12-col">
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos Usuario</legend><br>
									    </div>
									    <div class="mdl-cell mdl-cell--12-col">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="number" id="DNIusuario" name="dni">
												<label class="mdl-textfield__label" for="DNIusuario">DNI</label>
												<span class="mdl-textfield__error">Invalid DNI</span>
											</div>
									    </div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="text" id="Nameusuario" name = "nombreusuario">
												<label class="mdl-textfield__label" for="Nameusuario">Nombre</label>
												<span class="mdl-textfield__error">Invalid name</span>
											</div>
									    </div>
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="password" id="password" name = "passowordusuario">
												<label class="mdl-textfield__label" for="password">Password</label>
												<span class="mdl-textfield__error">Invalid password</span>
											</div>
										</div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="tel" id="phoneusuario" name = "telefonousuario">
												<label class="mdl-textfield__label" for="phoneusuario">Telefono</label>
												<span class="mdl-textfield__error">Invalid phone number</span>
											</div>
									    </div>
										<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<select id="rol_usuario" name="id_rol" class="mdl-textfield__input">
													<option value="">-- Seleccionar --</option>
													<?php
														require 'backend/conexion.php';

														// Buscar todos los roles en la base de datos
														$stmt = $pdo->prepare("SELECT * FROM roles"); // Asegúrate de que la tabla tenga estos campos
														$stmt->execute();
														
														// Recorrer los resultados y agregarlos al select
														while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
															echo "<option value='" . htmlspecialchars($row['Id']) . "'>" . htmlspecialchars($row['Descripcion']) . "</option>";
														}
													?>
												</select>
												<label class="mdl-textfield__label">Selecciona un rol:</label>
											</div>
										</div>
									    <div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
											<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
												<input class="mdl-textfield__input" type="email" id="emailusuario" name = "correousuario">
												<label class="mdl-textfield__label" for="emailusuario">E-mail</label>
												<span class="mdl-textfield__error">Invalid E-mail</span>
											</div>
									    </div>
										<label for="estado">Estado:</label>
										<input type="text" id="estadousuario" name="estado" class="input-field" disabled>
									</div>
				<button type="button" class="btn" onclick="actualizarUsuario()">Actualizar</button>
			</form>
		</div>
	</div>
	<script>
		function mostrarOpciones(boton, usuarioId) {
				let menu = document.getElementById("opciones-flotantes" + usuarioId);

				// Pasar el ID del usuario a las funciones
				menu.dataset.usuarioId = usuarioId;
				
				// Mostrar el menú flotante
				menu.classList.remove("hidden");
			}
			// Función para desactivar usuario
			function desactivarUsuario(id) {
				let usuarioId = document.getElementById("opciones-flotantes" + id).dataset.usuarioId;
				let confirmar = confirm("¿Seguro que deseas desactivar el usuario ID " + usuarioId + "?");
				
				if (confirmar) {
					fetch("backend/acciones_usuario.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${usuarioId}&accion=desactivar`
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

			// Función para activar usuario
			function activarUsuario(id) {
				let usuarioId = document.getElementById("opciones-flotantes" + id).dataset.usuarioId;
				let confirmar = confirm("¿Seguro que deseas activar el usuario ID " + usuarioId + "?");
				
				if (confirmar) {
					fetch("backend/acciones_usuario.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${usuarioId}&accion=activar`
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

			function verDetalles(idusuario) {
				fetch("backend/acciones_usuario.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `id=${idusuario}&accion=obtener`
					})
					.then(response => response.json())
					.then(data => {
						// Cargar datos generales del usuario
						document.getElementById("usuarioId").value = data.usuario.Id;
						document.getElementById("DNIusuario").value = data.usuario.DNI;
						document.getElementById("Nameusuario").value = data.usuario.Nombre;
						document.getElementById("phoneusuario").value = data.usuario.Telefono;
						document.getElementById("emailusuario").value = data.usuario.Email;
						if(data.usuario.Estado === 1){
							document.getElementById("estadousuario").value = "Activo";
						}else{
							document.getElementById("estadousuario").value = "Inactivo";
						}

						// Mostrar el modal
						document.getElementById("modalusuario").style.display = "block";
						document.getElementById("modalusuario").classList.remove("hidden");
					})
					.catch(error => console.error("Error al obtener usuario:", error));
		}
		function actualizarUsuario() {
			let formData = new FormData(document.getElementById("formusuario"));
			//formData.append("accion", "actualizar");

			fetch("backend/acciones_usuario.php", {
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
			document.getElementById("modalusuario").style.display = "none";
		}
	</script>
</body>
</html>