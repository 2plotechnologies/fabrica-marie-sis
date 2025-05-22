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
	<title>Distritos y Regiones</title>
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
				<i class="zmdi zmdi-globe"></i>
			</div>
			<div class="full-width header-well-text">
				<p class="text-condensedLight">
					Aquí puedes gestionar los distritos y las regiones donde se realizan ventas.
				</p>
			</div>
		</section>
		<div class="full-width divider-menu-h"></div>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--12-col">
				<div class="full-width panel mdl-shadow--2dp">
					<div class="full-width panel-tittle bg-primary text-center tittles">
						Nueva región/distrito
					</div>
					<div class="full-width panel-content">
						<form action="backend/distritos_regiones.php" method="POST">
						<input type = "hidden" name = "accion" value = "crear">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--12-col">
		                            <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos de la región o el distrito</legend><br>
		                        </div>
								<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" pattern="-?[A-Za-z0-9áéíóúÁÉÍÓÚ ]*(\.[0-9]+)?" id="NameCompany" name="nombre">
										<label class="mdl-textfield__label" for="NameCompany">Nombre de la región o el distrito</label>
										<span class="mdl-textfield__error">Invalid name</span>
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
								<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addCompany">
									<i class="zmdi zmdi-plus"></i>
								</button>
								<div class="mdl-tooltip" for="btn-addCompany">Agregar</div>
							</p>
						</form>
						<!-- Agregar debajo del formulario de creación -->
						<div class="mdl-grid">
							<div class="mdl-cell mdl-cell--12-col">
								<div class="full-width panel mdl-shadow--2dp">
									<div class="full-width panel-tittle bg-primary text-center tittles">
										Lista de Distritos y Regiones
									</div>
									<div class="full-width panel-content">
										<div class="table-responsive">
											<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width">
												<thead>
													<tr>
														<th class="mdl-data-table__cell--non-numeric">Nombre</th>
														<th>Estado</th>
														<th>Acciones</th>
													</tr>
												</thead>
												<tbody>
												<?php
												require 'backend/conexion.php';
												$stmt = $pdo->prepare("SELECT * FROM distritos_regiones ORDER BY Region_Distrito ASC");
												$stmt->execute();

												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													$estadoTexto = $row['Estado'] == 1 ? "Activo" : "Inactivo";
													?>
													<tr>
														<td class="mdl-data-table__cell--non-numeric"><?php echo htmlspecialchars($row['Region_Distrito']); ?></td>
														<td><?php echo $estadoTexto; ?></td>
														<td>
															<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" onclick="editarDistrito(<?php echo $row['Id']; ?>)">
																<i class="zmdi zmdi-edit"></i>
															</button>
															<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" onclick="desactivarDistrito(<?php echo $row['Id']; ?>)">
																<i class="zmdi zmdi-close"></i>
															</button>
														</td>
													</tr>
												<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Modal para editar distrito/región -->
	<dialog id="modalEditar" class="mdl-dialog">
		<h4 class="mdl-dialog__title">Editar Distrito/Región</h4>
		<div class="mdl-dialog__content">
			<form id="formEditarDistrito">
				<input type="hidden" name="id" id="edit-id">
				<input type="hidden" name="accion" value="editar">

				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" type="text" name="nombre" id="edit-nombre" required>
					<label class="mdl-textfield__label" for="edit-nombre">Nombre</label>
				</div>
			</form>
		</div>
		<div class="mdl-dialog__actions">
			<button type="button" class="mdl-button" onclick="guardarEdicion()">Guardar</button>
			<button type="button" class="mdl-button close">Cancelar</button>
		</div>
	</dialog>
<script>
	const modalEditar = document.querySelector('#modalEditar');
	const dialogPolyfillLoaded = () => {
		if (!modalEditar.showModal) {
			dialogPolyfill.registerDialog(modalEditar);
		}
	};
	dialogPolyfillLoaded();

	function editarDistrito(id) {
		fetch(`backend/distritos_regiones.php?accion=obtener_region&id=${id}`)
			.then(res => res.json())
			.then(data => {
				document.getElementById('edit-id').value = data.Id;
				document.getElementById('edit-nombre').value = data.Region_Distrito;
				modalEditar.showModal();
			});
	}

	document.querySelector('#modalEditar .close').addEventListener('click', () => {
		modalEditar.close();
	});

	function guardarEdicion() {
		const formData = new FormData(document.getElementById('formEditarDistrito'));
		fetch('backend/distritos_regiones.php', {
			method: 'POST',
			body: new URLSearchParams(formData)
		})
		.then(res => res.json())
		.then(data => {
			alert(data.mensaje);
			modalEditar.close();
			location.reload();
		})
		.catch(err => {
			console.error(err);
			alert("Error al guardar");
		});
	}

	function desactivarDistrito(id) {
		if (confirm("¿Estás seguro de que deseas desactivar este distrito o región?")) {
			fetch("backend/distritos_regiones.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded",
				},
				body: `accion=desactivar&id=${id}`
			})
			.then(response => response.json())
			.then(data => {
				alert(data.mensaje);
				window.location.reload();
			})
			.catch(error => console.error("Error:", error));
		}
	}
</script>

</body>
</html>