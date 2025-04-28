<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Nueva Venta</title>
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
            <i class="zmdi zmdi-shopping-cart"></i>
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
                                            <input class="mdl-textfield__input" type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="region">
                                            <option value="">-- Seleccionar Región--</option>
													<?php
														require 'backend/conexion.php';

														// Buscar todos los roles en la base de datos
														$stmt = $pdo->prepare("SELECT * FROM distritos_regiones WHERE Estado = 1"); // Asegúrate de que la tabla tenga estos campos
														$stmt->execute();
														
														// Recorrer los resultados y agregarlos al select
														while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
															echo "<option value='" . htmlspecialchars($row['Id']) . "'>" . htmlspecialchars($row['Region_Distrito']) . "</option>";
														}
													?>
                                            </select>
                                        </div>
                                    </div>
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
                                            <select class="mdl-textfield__input" id="tipo_pago">
                                                <option value="">-- Seleccionar Tipo Pago --</option>
                                                <option value="1">Contado</option>
                                                <option value="2">Credito</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="metodo">
                                                <option value="">-- Seleccionar Método Pago --</option>
                                                <option value="1">Efectivo</option>
                                                <option value="2">Tarjeta</option>
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
                                            <input class="mdl-textfield__input" type="text" id="totalfinal" readonly>
                                            <label for="totalfinal">Total</label>
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
<dialog id="creditoModal" class="mdl-dialog">
  <h4 class="mdl-dialog__title">Configuración de Crédito</h4>
  <div class="mdl-dialog__content">
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
      <input type="number" min="1" class="mdl-textfield__input" id="numCuotas" />
      <label class="mdl-textfield__label" for="numCuotas">Número de cuotas</label>
    </div>
    <div id="cuotasContainer"></div> <!-- Aquí se generan los campos dinámicamente -->
  </div>
  <div class="mdl-dialog__actions">
    <button type="button" class="mdl-button closeCredito">Cerrar</button>
  </div>
</dialog>

<script>
    let productosSeleccionados = [];

    document.addEventListener("DOMContentLoaded", function () {
        const openModalButton = document.getElementById("openModal");
        const modal = document.getElementById("productModal");
        const closeModalButton = modal.querySelector(".close");
        const productTableBody = document.getElementById("productTableBody");
        const tipoPagoSelect = document.getElementById("tipo_pago");
        const creditoModal = document.getElementById("creditoModal");
        const closeCreditoBtn = creditoModal.querySelector(".closeCredito");
        const numCuotasInput = document.getElementById("numCuotas");
        const cuotasContainer = document.getElementById("cuotasContainer");

        // Función para cargar productos y promociones
        function loadProductsAndPromotions() {
            fetch("backend/get_products_promotions.php") 
                .then(response => response.json())
                .then(data => {
                    productTableBody.innerHTML = ""; // Limpiar la tabla

                    data.forEach(item => {
                    
                        const row = document.createElement("tr");

                        row.dataset.descuento = item.descuento || 0;

                        row.innerHTML = `
                            <td class="mdl-data-table__cell--non-numeric">${item.nombre}</td>
                            <td>${item.tipo}</td>
                            <td>${item.presentacion || 'N/A'}</td>
                           <td data-original-price="${item.precio_unitario}">S/${item.precio_unitario}</td>
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
            const botonDescuento = event.target.closest(".apply-discount");
            const botonAgregar = event.target.closest(".add-product");

            // Aplicar descuento
            if (botonDescuento) {
                const row = botonDescuento.closest("tr");
                const precioCelda = row.children[3]; // Celda de precio
                const originalPrecioText = precioCelda.dataset.originalPrice; // Valor original
                const descuento = parseFloat(row.dataset.descuento || 0); // Descuento del dataset

                let originalPrecio = parseFloat(originalPrecioText || precioCelda.textContent.replace("S/", ""));
                let precioConDescuento = originalPrecio - descuento;

                precioCelda.textContent = `S/${precioConDescuento.toFixed(2)}`;
                botonDescuento.disabled = true;
                botonDescuento.textContent = "Aplicado";
            }

            // Agregar producto
            if (botonAgregar) {
                const row = botonAgregar.closest("tr");

                const nombre = row.children[0].textContent;
                const tipo = row.children[1].textContent;
                const presentacion = row.children[2].textContent;
                const precioTexto = row.children[3].textContent.replace("S/", "");
                const cantidad = parseInt(row.querySelector(".cantidad-input").value) || 1;

                const precio = parseFloat(precioTexto);
                const descuento = parseFloat(row.dataset.descuento || 0);
                const precioFinal = precio; // Ya está con descuento si fue aplicado

                const yaExiste = productosSeleccionados.some(p => p.nombre === nombre && p.presentacion === presentacion && p.tipo === tipo);
                if (yaExiste) {
                    alert("Este producto o promoción ya está en la lista");
                    return;
                }

                productosSeleccionados.push({
                    nombre,
                    tipo,
                    presentacion,
                    cantidad,
                    precio: precioFinal,
                    total: cantidad * precioFinal
                });

                actualizarTablaPrincipal();
                modal.close();
            }

        });

        function actualizarTablaPrincipal() {
            const tablaBody = document.getElementById("tablaVentasBody");
            tablaBody.innerHTML = "";

            let totalfinal = 0;

            productosSeleccionados.forEach((item, index) => {
                const row = document.createElement("tr");

                const total = item.cantidad * item.precio;
                totalfinal += total;

                row.innerHTML = `
                    <td class="mdl-data-table__cell--non-numeric">${item.nombre}</td>
                    <td>${item.presentacion}</td>
                    <td>${item.cantidad}</td>
                    <td>S/${item.precio.toFixed(2)}</td>
                    <td>${item.tipo}</td>
                    <td>S/${total.toFixed(2)}</td>
                    <td>
                        <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect btn-eliminar" data-index="${index}">
                            <i class="zmdi zmdi-delete"></i>
                        </button>
                    </td>

                `;
                tablaBody.appendChild(row);
            });

            document.getElementById("totalfinal").value = `S/${totalfinal.toFixed(2)}`;
        }

        document.getElementById("tablaVentasBody").addEventListener("click", function (event) {
            const botonEliminar = event.target.closest(".btn-eliminar");
            if (botonEliminar) {
                const index = parseInt(botonEliminar.dataset.index);
                eliminarProducto(index);
            }
        });

        function eliminarProducto(index) {
            productosSeleccionados.splice(index, 1);
            actualizarTablaPrincipal();
        }

        // Mostrar el modal si se selecciona Crédito
        tipoPagoSelect.addEventListener("change", function () {
            if (this.value === "2") { // Si selecciona "Crédito"
                creditoModal.showModal();
            } else {
                creditoModal.close();
                cuotasContainer.innerHTML = ""; // Limpiar cuotas si cambia de opción
            }
        });

        // Cerrar el modal
        closeCreditoBtn.addEventListener("click", function () {
            creditoModal.close();
        });

        // Generar campos automáticamente cuando escriba número de cuotas
        numCuotasInput.addEventListener("input", function () {
            const numCuotas = parseInt(this.value);
            cuotasContainer.innerHTML = "";

            if (numCuotas > 0) {
                const totalVenta = parseFloat(document.getElementById("totalfinal").value.replace("S/", "")) || 0;
                const montoPorCuota = totalVenta / numCuotas;

                for (let i = 1; i <= numCuotas; i++) {
                    const cuotaDiv = document.createElement("div");
                    cuotaDiv.classList.add("mdl-grid");
                    cuotaDiv.classList.add("cuota-item");
                    cuotaDiv.innerHTML = `
                        <div class="mdl-cell mdl-cell--6-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input type="text" class="mdl-textfield__input monto-cuota" value="${montoPorCuota.toFixed(2)}" readonly />
                                <label class="mdl-textfield__label">Monto cuota ${i}</label>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--6-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input type="date" class="mdl-textfield__input fecha-cuota" required />
                                <label class="mdl-textfield__label">Fecha límite ${i}</label>
                            </div>
                        </div>
                    `;
                    cuotasContainer.appendChild(cuotaDiv);
                }

                componentHandler.upgradeAllRegistered(); // Recargar estilos MDL
            }
        });

    });

    document.getElementById("btn-finalizarVenta").addEventListener("click", function () {
        const fecha = document.querySelector('input[name="fecha"]').value;
        const cliente = document.getElementById("cliente").value;
        const vendedor = document.getElementById("vendedor")?.value || null;
        const tipo_pago = document.getElementById("tipo_pago").value;
        const region = document.getElementById("region").value;
        const metodo = document.getElementById("metodo").value;
        const total = document.getElementById("totalfinal").value.replace("S/", "");

        if (!cliente || !tipo_pago || !region || !metodo || productosSeleccionados.length === 0) {
            alert("Por favor complete todos los campos y agregue al menos un producto o promoción.");
            return;
        }

        const formData = new FormData();
        formData.append("fecha", fecha);
        formData.append("cliente", cliente);
        formData.append("vendedor", vendedor);
        formData.append("tipo_pago", tipo_pago);
        formData.append("region", region);
        formData.append("metodo", metodo);
        formData.append("total", total);
        formData.append("detalles", JSON.stringify(productosSeleccionados));

        // NUEVO: agregar cuotas si es Crédito
        if (tipo_pago == 2) {
            const cuotas = [];
            document.querySelectorAll(".cuota-item").forEach(item => {
                const monto = item.querySelector(".monto-cuota").value;
                const fechaLimite = item.querySelector(".fecha-cuota").value;

                if (monto && fechaLimite) {
                    cuotas.push({
                        monto: parseFloat(monto),
                        fecha_limite: fechaLimite
                    });
                }
            });

            if (cuotas.length == 0) {
                alert("Debe ingresar al menos una cuota para el pago a crédito.");
                return;
            }

            formData.append("cuotas", JSON.stringify(cuotas));
        }


        fetch("backend/ventas/crear_venta.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(respuesta => {
            alert("Venta registrada con éxito");
            location.reload(); // Opcional: Recargar página para limpiar todo
        })
        .catch(error => {
            console.error("Error al registrar venta:", error);
            alert("Hubo un error al registrar la venta.");
        });
    });

    document.getElementById("region").addEventListener("change", function() {
            let regionId = this.value;
            let clienteSelect = document.getElementById("cliente");

            // Limpiar opciones anteriores
            clienteSelect.innerHTML = '<option value="">-- Seleccionar cliente --</option>';

            if (regionId) {
                fetch('backend/distritos_regiones.php?id_region=' + regionId + '&accion=obtener')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(cliente => {
                            let option = document.createElement("option");
                            option.value = cliente.Id;
                            option.textContent = cliente.NombreCliente + " - " + cliente.Numero_Documento;
                            clienteSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });


</script>
</body>
</html>