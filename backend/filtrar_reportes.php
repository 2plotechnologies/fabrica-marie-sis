<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['id_Usuario'])) {
    // Si no hay sesión activa, redirige al login
    echo "ERROR: Usuario no identificado";
    die();
}

// Obtener filtros
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$cliente = $_POST['cliente'];
$vendedor = $_POST['vendedor'];
$tipo_pago = $_POST['tipo_pago'];
$region = $_POST['region'];
$metodo = $_POST['metodo'];

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

// Consulta principal
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

// Totales
$total_productos = 0;
$total_promociones = 0;
$total_ventas = 0;

foreach ($resultados as $row) {
    if ($row['Tipo'] == 'Producto') {
        $total_productos += $row['Cantidad'];
    } else {
        $total_promociones += $row['Cantidad'];
    }
    $total_ventas += $row['Total'];
}

// Respuesta JSON
echo json_encode([
    'ventas' => $resultados,
    'total_productos' => $total_productos,
    'total_promociones' => $total_promociones,
    'total_ventas' => $total_ventas
]);
?>
