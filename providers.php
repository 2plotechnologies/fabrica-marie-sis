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
										<a class="mdl-list__item-secondary-action" href="#!"><i class="zmdi zmdi-more"></i></a>
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
</body>
</html>