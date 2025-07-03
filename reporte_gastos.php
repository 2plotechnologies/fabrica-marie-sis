<?php session_start();
if (!isset($_SESSION['id_Usuario'])) {
    header("Location: index.html");
    exit();
}
require 'backend/conexion.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Reporte de Gastos</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/sweetalert2.css">
	<link rel="stylesheet" href="css/material.min.css">
	<link rel="stylesheet" href="css/material-design-iconic-font.min.css">
	<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="css/main.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery-1.11.2.min.js"><\/script>')</script>
	<script src="js/material.min.js"></script>
	<script src="js/sweetalert2.min.js"></script>
	<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="js/main.js"></script>
</head>
<body>
<?php include('menus/menu_superior.php'); ?>
<?php include('menus/menu_lateral.php'); ?>
<section class="full-width pageContent">
	<?php include('menus/menu_navbar.php'); ?>
	<section class="full-width header-well">
		<div class="full-width header-well-icon">
			<i class="zmdi zmdi-money"></i>
		</div>
		<div class="full-width header-well-text">
			<p class="text-condensedLight">Consulta reportes de gastos filtrando por fecha, proveedor y usuario.</p>
		</div>
	</section>

	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<div class="full-width panel mdl-shadow--2dp">
				<div class="full-width panel-tittle bg-primary text-center tittles">Ver reporte de gastos</div>
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
								<select class="mdl-textfield__input" id="documento">
									<option value="">-- Todos --</option>
									<option value="con">Con documento</option>
									<option value="sin">Sin documento</option>
								</select>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="proveedor">
									<option value="">-- Todos los proveedores --</option>
									<?php
									$stmt = $pdo->prepare("SELECT Id, Razon_Social FROM proveedores WHERE Estado = 1");
									$stmt->execute();
									while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value='{$row['Id']}'>" . htmlspecialchars($row['Razon_Social']) . "</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="usuario">
									<option value="">-- Todos los usuarios --</option>
									<?php
									$stmt = $pdo->prepare("SELECT Id, Nombre FROM usuarios WHERE Estado = 1");
									$stmt->execute();
									while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value='{$row['Id']}'>" . htmlspecialchars($row['Nombre']) . "</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width">
								<thead>
									<tr>
										<th>Fecha</th>
										<th>Proveedor</th>
										<th>Descripción</th>
										<th>Monto</th>
										<th>Documento</th>
										<th>Registrado por</th>
                                        <th>Fecha de Registro</th>
									</tr>
								</thead>
								<tbody id="tablaGastosBody"></tbody>
							</table>
						</div>
						<div class="mdl-cell mdl-cell--4-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input class="mdl-textfield__input" type="text" id="total_gastos" readonly>
								<label for="total_gastos">Total Gastos (S/)</label>
							</div>
						</div>
					</div>
					<p class="text-center">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bg-primary" id="exportarPDF">Exportar a PDF</button>
					</p>
					<p class="text-center">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent bg-primary" id="exportarExcel">Exportar a EXCEL</button>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
function actualizarGastos() {
	const data = {
		fecha_inicio: $('input[name=fecha_inicio]').val(),
		fecha_fin: $('input[name=fecha_fin]').val(),
		documento: $('#documento').val(),
		proveedor: $('#proveedor').val(),
		usuario: $('#usuario').val()
	};
	$.post('backend/filtrar_gastos.php', data, function(res) {
        console.log(res);
		const resultado = JSON.parse(JSON.stringify(res));
		const tabla = $('#tablaGastosBody');
		tabla.empty();

		let total = 0;
		resultado.gastos.forEach(g => {
			tabla.append(`
				<tr>
					<td>${g.Fecha}</td>
					<td>${g.Proveedor}</td>
					<td>${g.Descripcion}</td>
					<td>S/. ${parseFloat(g.Monto).toFixed(2)}</td>
					<td>${g.NumeroDocumento ? g.NumeroDocumento : 'Sin documento'}</td>
					<td>${g.Usuario}</td>
                    <td>${g.Fecha_Registro}</td>
				</tr>
			`);
			total += parseFloat(g.Monto);
		});
		$('#total_gastos').val('S/. ' + total.toFixed(2));
	});
}

$(document).ready(function() {
	actualizarGastos();
	$('#documento, #proveedor, #usuario, input[name=fecha_inicio], input[name=fecha_fin]').on('change', actualizarGastos);
});

$('#exportarPDF').on('click', function () {
	const filtros = {
		fecha_inicio: $('input[name=fecha_inicio]').val(),
		fecha_fin: $('input[name=fecha_fin]').val(),
		documento: $('#documento').val(),
		proveedor: $('#proveedor').val(),
		usuario: $('#usuario').val()
	};
	const query = $.param(filtros);
	window.open('backend/exportar_gastos_pdf.php?' + query, '_blank');
});

$('#exportarExcel').on('click', function () {
	const filtros = {
		fecha_inicio: $('input[name=fecha_inicio]').val(),
		fecha_fin: $('input[name=fecha_fin]').val(),
		documento: $('#documento').val(),
		proveedor: $('#proveedor').val(),
		usuario: $('#usuario').val()
	};
	const query = $.param(filtros);
	window.open('backend/exportar_gastos_excel.php?' + query, '_blank');
});
</script>

</body>
</html>
