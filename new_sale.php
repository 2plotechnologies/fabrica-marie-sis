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
                                                <?php
														require 'backend/conexion.php';

														// Buscar todos los usuarios vendedores en la base de datos
														$stmt = $pdo->prepare("SELECT * FROM clientes WHERE Estado = 1"); // Asegúrate de que la tabla tenga estos campos
														$stmt->execute();
														
														// Recorrer los resultados y agregarlos al select
														while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
															echo "<option value='" . htmlspecialchars($row['Id']) . "'>" . htmlspecialchars($row['NombreCliente']) . " - " . htmlspecialchars($row['Numero_Documento']) . "</option>";
														}
													?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($_SESSION["rol"] == 1){ ?>
                                        <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="vendedor">
                                                <option value="">-- Seleccionar Vendedor --</option>
                                                <?php
														require 'backend/conexion.php';

														// Buscar todos los usuarios vendedores en la base de datos
														$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE Id_Rol = 2 AND Estado = 1"); // Asegúrate de que la tabla tenga estos campos
														$stmt->execute();
														
														// Recorrer los resultados y agregarlos al select
														while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
															echo "<option value='" . htmlspecialchars($row['Id']) . "'>" . htmlspecialchars($row['Nombre']) . "</option>";
														}
													?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="cliente">
                                                <option value="">-- Seleccionar Tipo Pago --</option>
                                                <option value="co">Contado</option>
                                                <option value="cr">Credito</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="cliente">
                                                <option value="">-- Seleccionar Región --</option>
                                                <option value="co">Huancayo</option>
                                                <option value="cr">Selva Central</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--12-col">
                                        <button id="openModal" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored bg-primary">
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
<!-- Modal -->
<dialog id="productModal" class="mdl-dialog" style = "width:80%!important;">
    <h4 class="mdl-dialog__title">Seleccionar Producto o Promoción</h4>
    <div class="mdl-dialog__content">
        <div class="table-responsive">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric">Nombre</th>
                        <th>Tipo</th>
                        <th>Presentación</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Descuento</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <!-- Aquí se cargarán los productos y promociones -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button close">Cerrar</button>
    </div>
</dialog>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openModalButton = document.getElementById("openModal");
        const modal = document.getElementById("productModal");
        const closeModalButton = modal.querySelector(".close");
        const productTableBody = document.getElementById("productTableBody");

        // Función para cargar productos y promociones
        function loadProductsAndPromotions() {
            fetch("backend/get_products_promotions.php") 
                .then(response => response.json())
                .then(data => {
                    productTableBody.innerHTML = ""; // Limpiar la tabla

                    data.forEach(item => {
                        const row = document.createElement("tr");

                        row.innerHTML = `
                            <td class="mdl-data-table__cell--non-numeric">${item.nombre}</td>
                            <td>${item.tipo}</td>
                            <td>${item.presentacion || 'N/A'}</td>
                            <td>S/${item.precio_unitario}</td>
                            <td>
                                <input type="number" class="mdl-textfield__input cantidad-input" min="1" value="${item.cantidad || 1}">
                            </td>
                            <td>
                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent apply-discount">
                                    Aplicar Descuento
                                </button>
                            </td>
                            <td>
                                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect add-product">
                                    <i class="zmdi zmdi-plus"></i>
                                </button>
                            </td>
                        `;

                        productTableBody.appendChild(row);
                    });

                    componentHandler.upgradeAllRegistered(); // Recargar estilos de MDL
                })
                .catch(error => console.error("Error al cargar productos:", error));
        }

        // Evento para abrir el modal
        openModalButton.addEventListener("click", function () {
            loadProductsAndPromotions();
            modal.showModal();
        });

        // Evento para cerrar el modal
        closeModalButton.addEventListener("click", function () {
            modal.close();
        });

        // Evento para aplicar descuento
        productTableBody.addEventListener("click", function (event) {
            if (event.target.classList.contains("apply-discount")) {
                const row = event.target.closest("tr");
                const nombre = row.children[0].textContent;
                alert(`Aplicando descuento a ${nombre}`);
            }
        });
    });

</script>
</body>
</html>