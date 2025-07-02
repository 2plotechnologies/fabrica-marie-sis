<?php
session_start();
require 'conexion.php';
require_once '../tcpdf/tcpdf.php';

if (!isset($_SESSION['id_Usuario'])) {
    // Si no hay sesión activa, redirige al login
    echo "ERROR: Usuario no identificado";
    die();
}

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

// Consultar ventas
$sql = "SELECT 
            v.Fecha,
            v.Fecha_Registro,
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

// Crear PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);
$pdf->Write(0, 'Reporte de Ventas', '', 0, 'C', true, 0, false, false, 0);
$pdf->Ln(5);

// Encabezado tabla
$html = '<table border="1" cellpadding="4">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th><b>Fecha de Venta</b></th>
            <th><b>Fecha de Registro</b></th>
            <th><b>Vendedor</b></th>
            <th><b>Producto/Promoción</b></th>
            <th><b>Presentación</b></th>
            <th><b>Cantidad</b></th>
            <th><b>Valor Unitario</b></th>
            <th><b>Tipo</b></th>
            <th><b>Total</b></th>
        </tr>
    </thead>
    <tbody>';

// Cuerpo tabla
$total_productos = 0;
$total_promociones = 0;
$total_ventas = 0;

foreach ($resultados as $row) {
    $html .= '<tr>
        <td>' . $row['Fecha'] . '</td>
        <td>' . $row['Fecha_Registro'] . '</td>
        <td>' . $row['Vendedor'] . '</td>
        <td>' . $row['Producto'] . '</td>
        <td>' . $row['Presentacion'] . '</td>
        <td>' . $row['Cantidad'] . '</td>
        <td>S/ ' . number_format($row['Precio_Unitario'], 2) . '</td>
        <td>' . $row['Tipo'] . '</td>
        <td>S/ ' . number_format($row['Total'], 2) . '</td>
    </tr>';

    if ($row['Tipo'] == 'Producto') {
        $total_productos += $row['Cantidad'];
    } else {
        $total_promociones += $row['Cantidad'];
    }
    $total_ventas += $row['Total'];
}

$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, false, false, '');

// Totales
$pdf->Ln(5);
$pdf->Write(0, "Total productos vendidos: $total_productos", '', 0, '', true);
$pdf->Write(0, "Total promociones vendidas: $total_promociones", '', 0, '', true);
$pdf->Write(0, "Total vendido: S/ " . number_format($total_ventas, 2), '', 0, '', true);

// Salida
$pdf->Output('reporte_ventas.pdf', 'I');
