<?php
require 'conexion.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Obtener filtros desde GET
$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];
$cliente = $_GET['cliente'];
$vendedor = $_GET['vendedor'];
$tipo_pago = $_GET['tipo_pago'];
$region = $_GET['region'];
$metodo = $_GET['metodo'];

$where = "WHERE v.Fecha BETWEEN :inicio AND :fin";
$params = [
    ':inicio' => $fecha_inicio,
    ':fin' => $fecha_fin
];

if ($cliente != 'todos') {
    $where .= " AND v.Id_Cliente = :cliente";
    $params[':cliente'] = $cliente;
}
if (!empty($vendedor)) {
    $where .= " AND v.Id_Vendedor = :vendedor";
    $params[':vendedor'] = $vendedor;
}
if (!empty($tipo_pago)) {
    $where .= " AND v.Tipo_Pago = :tipo_pago";
    $params[':tipo_pago'] = $tipo_pago;
}
if (!empty($region)) {
    $where .= " AND v.Region_Distrito = :region";
    $params[':region'] = $region;
}
if (!empty($metodo)) {
    $where .= " AND v.Metodo_Pago = :metodo";
    $params[':metodo'] = $metodo;
}

// Consulta
$sql = "SELECT 
            v.Fecha,
            u.Nombre AS Vendedor,
            d.Producto_Promocion AS Producto,
            d.Presentacion,
            d.Cantidad,
            d.Valor_Unitario AS Precio_Unitario,
            d.Tipo,
            d.Subtotal AS Total
        FROM detalle_venta d
        JOIN ventas v ON d.id_Venta = v.Id
        JOIN usuarios u ON v.Id_Vendedor = u.Id
        $where";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Reporte de Ventas");

// Encabezados
$encabezados = ['Fecha', 'Vendedor', 'Producto/Promoción', 'Presentación', 'Cantidad', 'Valor Unitario', 'Tipo', 'Total'];
$col = 'A';
foreach ($encabezados as $titulo) {
    $sheet->setCellValue($col . '1', $titulo);
    $col++;
}

// Llenar datos
$fila = 2;
$total_productos = 0;
$total_promociones = 0;
$total_ventas = 0;

foreach ($resultados as $row) {
    $sheet->setCellValue("A$fila", $row['Fecha']);
    $sheet->setCellValue("B$fila", $row['Vendedor']);
    $sheet->setCellValue("C$fila", $row['Producto']);
    $sheet->setCellValue("D$fila", $row['Presentacion']);
    $sheet->setCellValue("E$fila", $row['Cantidad']);
    $sheet->setCellValue("F$fila", $row['Precio_Unitario']);
    $sheet->setCellValue("G$fila", $row['Tipo']);
    $sheet->setCellValue("H$fila", $row['Total']);

    if ($row['Tipo'] == 'Producto') {
        $total_productos += $row['Cantidad'];
    } else {
        $total_promociones += $row['Cantidad'];
    }
    $total_ventas += $row['Total'];
    $fila++;
}

// Agregar totales al final
$sheet->setCellValue("G$fila", 'Total productos:');
$sheet->setCellValue("H$fila", $total_productos);
$fila++;

$sheet->setCellValue("G$fila", 'Total promociones:');
$sheet->setCellValue("H$fila", $total_promociones);
$fila++;

$sheet->setCellValue("G$fila", 'Total vendido:');
$sheet->setCellValue("H$fila", $total_ventas);

// Establecer encabezados para descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_ventas.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
