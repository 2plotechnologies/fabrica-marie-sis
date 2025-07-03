<?php
session_start();
require 'conexion.php';
require '../vendor/autoload.php'; // PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Verifica sesión
if (!isset($_SESSION['id_Usuario'])) {
    echo "ERROR: Usuario no identificado";
    exit;
}

// Filtros GET
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';
$documento = $_GET['documento'] ?? '';
$proveedor = $_GET['proveedor'] ?? '';
$usuario = $_GET['usuario'] ?? '';

// WHERE dinámico
$where = "WHERE g.Fecha BETWEEN :inicio AND :fin";
$params = [
    ':inicio' => $fecha_inicio,
    ':fin' => $fecha_fin
];

if ($documento === 'con') {
    $where .= " AND g.NumeroDocumento IS NOT NULL AND TRIM(g.NumeroDocumento) != ''";
} elseif ($documento === 'sin') {
    $where .= " AND (g.NumeroDocumento IS NULL OR TRIM(g.NumeroDocumento) = '')";
}

if (!empty($proveedor)) {
    $where .= " AND g.IdProveedor = :proveedor";
    $params[':proveedor'] = $proveedor;
}

if (!empty($usuario)) {
    $where .= " AND g.Id_Usuario = :usuario";
    $params[':usuario'] = $usuario;
}

// Consulta
$sql = "SELECT 
            g.Fecha,
            g.NumeroDocumento,
            p.Razon_Social AS Proveedor,
            g.Descripcion,
            g.Monto,
            g.Fecha_Registro,
            u.Nombre AS Usuario
        FROM gastos g
        LEFT JOIN proveedores p ON g.IdProveedor = p.Id
        LEFT JOIN usuarios u ON g.Id_Usuario = u.Id
        $where
        ORDER BY g.Fecha ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Reporte de Gastos');

// Encabezados
$sheet->setCellValue('A1', 'Fecha');
$sheet->setCellValue('B1', 'Nro. Documento');
$sheet->setCellValue('C1', 'Proveedor');
$sheet->setCellValue('D1', 'Descripción');
$sheet->setCellValue('E1', 'Monto (S/.)');
$sheet->setCellValue('F1', 'Registrado por');
$sheet->setCellValue('G1', 'Fecha de Registro');

// Cuerpo
$fila = 2;
$total_gastos = 0;

foreach ($gastos as $g) {
    $sheet->setCellValue('A' . $fila, $g['Fecha']);
    $sheet->setCellValue('B' . $fila, $g['NumeroDocumento'] ?? '-');
    $sheet->setCellValue('C' . $fila, $g['Proveedor'] ?? '-');
    $sheet->setCellValue('D' . $fila, $g['Descripcion']);
    $sheet->setCellValue('E' . $fila, number_format($g['Monto'], 2));
    $sheet->setCellValue('F' . $fila, $g['Usuario']);
    $sheet->setCellValue('G' . $fila, $g['Fecha_Registro']);
    $total_gastos += $g['Monto'];
    $fila++;
}

// Total
$sheet->setCellValue('D' . $fila, 'TOTAL:');
$sheet->setCellValue('E' . $fila, number_format($total_gastos, 2));

// Formato opcional
foreach (range('A', 'F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Enviar al navegador
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="reporte_gastos.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
