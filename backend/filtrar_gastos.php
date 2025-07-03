<?php
session_start();
require 'conexion.php';

header('Content-Type: application/json');

// Validar sesión
if (!isset($_SESSION['id_Usuario'])) {
    echo json_encode(['error' => 'Usuario no autorizado']);
    exit;
}

// Recibir filtros
$fecha_inicio = $_POST['fecha_inicio'] ?? null;
$fecha_fin = $_POST['fecha_fin'] ?? null;
$documento = $_POST['documento'] ?? '';
$proveedor = $_POST['proveedor'] ?? '';
$usuario = $_POST['usuario'] ?? '';

// Base de consulta
$sql = "SELECT 
            g.Fecha, 
            p.Razon_Social AS Proveedor, 
            g.Descripcion, 
            g.Monto, 
            g.NumeroDocumento, 
            g.Fecha_Registro,
            u.Nombre AS Usuario
        FROM gastos g
        LEFT JOIN proveedores p ON g.IdProveedor = p.Id
        LEFT JOIN usuarios u ON g.Id_Usuario = u.Id
        WHERE 1=1";  // 1=1 permite añadir AND dinámicos

$params = [];

// Filtros dinámicos
if ($fecha_inicio && $fecha_fin) {
    $sql .= " AND g.Fecha BETWEEN :fecha_inicio AND :fecha_fin";
    $params[':fecha_inicio'] = $fecha_inicio;
    $params[':fecha_fin'] = $fecha_fin;
}

if ($documento === 'con') {
    $sql .= " AND g.NumeroDocumento IS NOT NULL AND TRIM(g.NumeroDocumento) != ''";
} elseif ($documento === 'sin') {
    $sql .= " AND (g.NumeroDocumento IS NULL OR TRIM(g.NumeroDocumento) = '')";
}

if ($proveedor) {
    $sql .= " AND g.IdProveedor = :proveedor";
    $params[':proveedor'] = $proveedor;
}

if ($usuario) {
    $sql .= " AND g.Id_Usuario = :usuario";
    $params[':usuario'] = $usuario;
}

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['gastos' => $gastos]);
    exit;

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error SQL: ' . $e->getMessage()]);
    exit;
}
?>
