<?php
session_start();
require 'conexion.php';
require_once '../tcpdf/tcpdf.php';

// Verifica sesión
if (!isset($_SESSION['id_Usuario'])) {
    echo "ERROR: Usuario no identificado";
    exit;
}

// Filtros por GET
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';
$documento = $_GET['documento'] ?? '';
$proveedor = $_GET['proveedor'] ?? '';
$usuario = $_GET['usuario'] ?? '';

// Construir WHERE dinámico
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

// Crear PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);
$pdf->Write(0, 'Reporte de Gastos', '', 0, 'C', true, 0, false, false, 0);
$pdf->Ln(5);

// Encabezado tabla
$html = '<table border="1" cellpadding="4">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th><b>Fecha</b></th>
            <th><b>Nro. Documento</b></th>
            <th><b>Proveedor</b></th>
            <th><b>Descripción</b></th>
            <th><b>Monto (S/)</b></th>
            <th><b>Registrado por</b></th>
            <th><b>Fecha de Registro</b></th>
        </tr>
    </thead>
    <tbody>';

$total_gastos = 0;

foreach ($gastos as $g) {
    $html .= '<tr>
        <td>' . htmlspecialchars($g['Fecha']) . '</td>
        <td>' . htmlspecialchars($g['NumeroDocumento'] ?? '-') . '</td>
        <td>' . htmlspecialchars($g['Proveedor'] ?? '-') . '</td>
        <td>' . htmlspecialchars($g['Descripcion']) . '</td>
        <td>S/ ' . number_format($g['Monto'], 2) . '</td>
        <td>' . htmlspecialchars($g['Usuario']) . '</td>
        <td>' . htmlspecialchars($g['Fecha_Registro']) . '</td>
    </tr>';
    $total_gastos += $g['Monto'];
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Ln(5);
$pdf->Write(0, 'Total Gastos: S/ ' . number_format($total_gastos, 2), '', 0, '', true);

// Salida
$pdf->Output('reporte_gastos.pdf', 'I');
?>
