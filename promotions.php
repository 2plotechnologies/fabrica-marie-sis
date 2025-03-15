<?php session_start(); ?>

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
									        <legend class="text-condensedLight"><i class="zmdi zmdi-border-color"></i> &nbsp; Datos promoción</legend><br>
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
    </script>
</body>
</html>