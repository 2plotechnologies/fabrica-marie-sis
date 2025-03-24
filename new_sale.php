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
				Aqui puedes crear una venta nueva
				</p>
			</div>
		</section>
        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar">
                <a href="#tabNewSale" class="mdl-tabs__tab is-active">Nueva Venta</a>
            </div>
            <div class="mdl-tabs__panel is-active" id="tabNewSale">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="full-width panel mdl-shadow--2dp">
                            <div class="full-width panel-tittle bg-primary text-center tittles">
                                Nueva Venta
                            </div>
                            <div class="full-width panel-content">
                                <div class="mdl-grid">
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="cliente">
                                                <option value="">-- Seleccionar Cliente --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($_SESSION["rol"] == 1){ ?>
                                        <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="vendedor">
                                                <option value="">-- Seleccionar Vendedor --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="mdl-cell mdl-cell--12-col">
                                        <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary" id="btn-addItem">
                                            <i class="zmdi zmdi-plus"></i>
                                        </button>
                                        <div class="mdl-tooltip" for="btn-addItem">Agregar Producto o Promoción</div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--12-col">
                                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width">
                                            <thead>
                                                <tr>
                                                    <th class="mdl-data-table__cell--non-numeric">Producto/Promoción</th>
                                                    <th>Presentación</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Tipo</th>
                                                    <th>Total</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablaVentasBody">
                                                <!-- Aquí se agregarán los productos dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mdl-cell mdl-cell--4-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" id="subtotal" readonly>
                                            <label class="mdl-textfield__label" for="subtotal">Subtotal</label>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--4-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" id="igv" readonly>
                                            <label class="mdl-textfield__label" for="igv">IGV</label>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--4-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" id="total" readonly>
                                            <label class="mdl-textfield__label" for="total">Total</label>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-center">
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bg-primary" id="btn-finalizarVenta">
                                        Finalizar Venta
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
</body>
</html>