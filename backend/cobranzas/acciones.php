<?php
session_start();
require '../conexion.php';

if (!isset($_SESSION['id_Usuario'])) {
    echo "ERROR: Usuario no identificado";
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $id = $_POST['id'] ?? '';

    // Validar que el ID no esté vacío y sea numérico
    if ($accion === 'marcar_pagado' && !empty($id) && is_numeric($id)) {
        try {
            $stmt = $pdo->prepare("UPDATE cobranzas SET pagado = 1 WHERE Id = :id");
            $stmt->execute([':id' => $id]);
            echo json_encode(['mensaje' => 'Cuota marcada como pagada.']);
        } catch (PDOException $e) {
            echo json_encode(['mensaje' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['mensaje' => 'Acción inválida o ID faltante o no válido.']);
    }
}
?>
