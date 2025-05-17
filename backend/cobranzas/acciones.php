<?php
require '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $id = $_POST['id'] ?? '';

    if ($accion === 'marcar_pagado' && $id) {
        try {
            $stmt = $pdo->prepare("UPDATE cobranzas SET pagado = 1 WHERE Id = :id");
            $stmt->execute([':id' => $id]);
            echo json_encode(['mensaje' => 'Cuota marcada como pagada.']);
        } catch (PDOException $e) {
            echo json_encode(['mensaje' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['mensaje' => 'Acción inválida o ID faltante.']);
    }
}
?>
