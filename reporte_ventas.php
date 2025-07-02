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
	<title>Reporte de Ventas</title>
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
				Conuslta reportes de ventas por vendedor, fecha, y mas.
				</p>
			</div>
		</section>
        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar">
                <a href="#tabNewSale" class="mdl-tabs__tab is-active">Reporte de ventas</a>
            </div>
            <div class="mdl-tabs__panel is-active" id="tabNewSale">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="full-width panel mdl-shadow--2dp">
                            <div class="full-width panel-tittle bg-primary text-center tittles">
                                Ver reporte de ventas
                            </div>
                            <div class="full-width panel-content">
                                <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="date" name="fecha_inicio" value="<?php echo date('Y-m-d'); ?>">
                                            <label for="fecha_inicio">Fecha de inicio</label>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="date" name="fecha_fin" value="<?php echo date('Y-m-d'); ?>">
                                            <label for="fecha_fin">Fecha fin</label>
                                        </div>
                                    </div>
                                     <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="region">
                                                <option value="">-- Todas las regiones --</option>
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
                                                <option value="todos">-- Todos los clientes --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if($_SESSION["rol"] == 1){ ?>
                                        <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="vendedor">
                                                <option value="">-- Todos los vendedores --</option>
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
                                                <option value="">-- Todos los tipos de Pago --</option>
                                                <option value="1">Contado</option>
                                                <option value="2">Credito</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <select class="mdl-textfield__input" id="metodo">
                                                <option value="">-- Todos los Métodos Pago --</option>
                                                <option value="1">Efectivo</option>
                                                <option value="2">Tarjeta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--12-col">
                                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width">
                                            <thead>
                                                <tr>
                                                    <th>Fecha de Venta</th>
                                                    <th>Fecha de Registro</th>
                                                    <th>Vendedor</th>
                                                    <th class="mdl-data-table__cell--non-numeric">Producto/Promoción</th>
                                                    <th>Presentación</th>
                                                    <th>Cantidad</th>
                                                    <th>Valor unitario</th>
                                                    <th>Tipo</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablaVentasBody">
                                                <!-- Aquí se agregarán los productos dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mdl-cell mdl-cell--4-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" id="total_productos" readonly>
                                            <label for="total_productos">Cantidad de productos vendidos</label>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--4-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" id="total_promociones" readonly>
                                            <label for="igv">Cantidad de Promociones vendidas</label>
                                        </div>
                                    </div>
                                    <div class="mdl-cell mdl-cell--4-col">
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" id="total" readonly>
                                            <label for="total">Total vendido(S/)</label>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-center">
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bg-primary" id="exportarPDF">
                                        Exportar a PDF
                                    </button>
                                </p>
                                <p class="text-center">
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bg-primary" id="exportarExcel">
                                        Exportar a EXCEL
                                    </button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script>
    function actualizarReporte() {
        const data = {
            fecha_inicio: $('input[name=fecha_inicio]').val(),
            fecha_fin: $('input[name=fecha_fin]').val(),
            cliente: $('#cliente').val(),
            vendedor: $('#vendedor').val(),
            tipo_pago: $('#tipo_pago').val(),
            region: $('#region').val(),
            metodo: $('#metodo').val(),
        };

        $.post('backend/filtrar_reportes.php', data, function(res) {
            const resultado = JSON.parse(res);
            const tabla = $('#tablaVentasBody');
            tabla.empty();

            resultado.ventas.forEach(v => {
                tabla.append(`
                    <tr>
                        <td>${v.Fecha}</td>
                        <td>${v.Fecha_Registro}</td>
                        <td>${v.Vendedor}</td>
                        <td class="mdl-data-table__cell--non-numeric">${v.Producto}</td>
                        <td>${v.Presentacion}</td>
                        <td>${v.Cantidad}</td>
                        <td>S/. ${parseFloat(v.Precio_Unitario).toFixed(2)}</td>
                        <td>${v.Tipo}</td>
                        <td>S/. ${parseFloat(v.Total).toFixed(2)}</td>
                    </tr>
                `);
            });

            $('#total_productos').val(resultado.total_productos);
            $('#total_promociones').val(resultado.total_promociones);
            $('#total').val('S/. ' + parseFloat(resultado.total_ventas).toFixed(2));
        });
    }

    // Ejecutar al cargar y cada vez que cambie un filtro
    $(document).ready(function() {
        actualizarReporte();
        $('#cliente, #vendedor, #tipo_pago, #region, #metodo, input[name=fecha_inicio], input[name=fecha_fin]')
            .on('change', actualizarReporte);
    });

    function obtenerFiltros() {
        return {
            fecha_inicio: $('input[name=fecha_inicio]').val(),
            fecha_fin: $('input[name=fecha_fin]').val(),
            cliente: $('#cliente').val(),
            vendedor: $('#vendedor').val(),
            tipo_pago: $('#tipo_pago').val(),
            region: $('#region').val(),
            metodo: $('#metodo').val()
        };
    }

    $('#exportarPDF').on('click', function () {
        const filtros = obtenerFiltros();
        const query = $.param(filtros);
        window.open('backend/exportar_pdf.php?' + query, '_blank');
    });

    $('#exportarExcel').on('click', function () {
        const filtros = obtenerFiltros();
        const query = $.param(filtros);
        window.open('backend/exportar_excel.php?' + query, '_blank');
    });

    document.getElementById("region").addEventListener("change", function() {
            let regionId = this.value;
            let clienteSelect = document.getElementById("cliente");

            // Limpiar opciones anteriores
            clienteSelect.innerHTML = '<option value="todos">-- Todos los clientes --</option>';

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