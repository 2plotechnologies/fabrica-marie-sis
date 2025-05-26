<?php
session_start();
require '../conexion.php'; // Importar la conexión

if (!isset($_SESSION['id_Usuario'])) {
    echo "ERROR: Usuario no identificado";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];

    if ($accion == 'eliminar') {
        $id = $_POST["id"] ?? "";

        try {
            // 1. Obtener los detalles de la venta
            $sqlDetalles = "SELECT Cantidad, Producto_Promocion, Presentacion 
                            FROM detalle_venta 
                            WHERE id_Venta = :id";
            $stmtDetalles = $pdo->prepare($sqlDetalles);
            $stmtDetalles->execute([':id' => $id]);
            $detalles = $stmtDetalles->fetchAll(PDO::FETCH_ASSOC);

            // 2. Restaurar stock por cada producto-presentación
            foreach ($detalles as $detalle) {
                $cantidad = $detalle['Cantidad'];
                $nombreProducto = $detalle['Producto_Promocion'];
                $nombrePresentacion = $detalle['Presentacion'];

                // Obtener Id del producto
                $stmtProd = $pdo->prepare("SELECT Id FROM productos WHERE Nombre = :nombre LIMIT 1");
                $stmtProd->execute([':nombre' => $nombreProducto]);
                $producto = $stmtProd->fetch(PDO::FETCH_ASSOC);

                // Obtener Id de la presentación
                $stmtPres = $pdo->prepare("SELECT Id FROM presentaciones WHERE Presentacion = :presentacion LIMIT 1");
                $stmtPres->execute([':presentacion' => $nombrePresentacion]);
                $presentacion = $stmtPres->fetch(PDO::FETCH_ASSOC);

                if ($producto && $presentacion) {
                    $idProducto = $producto['Id'];
                    $idPresentacion = $presentacion['Id'];

                    // Sumar la cantidad a Produccion_Actual
                    $stmtUpdate = $pdo->prepare("
                        UPDATE producto_presentacion 
                        SET Produccion_Actual = Produccion_Actual + :cantidad 
                        WHERE Id_Producto = :idProd AND Id_Presentacion = :idPres
                    ");
                    $stmtUpdate->execute([
                        ':cantidad' => $cantidad,
                        ':idProd' => $idProducto,
                        ':idPres' => $idPresentacion
                    ]);
                }
            }

            // 3. Eliminar los registros en orden
            $sql1 = "DELETE FROM detalle_venta WHERE id_Venta = :id";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute([':id' => $id]);

            $sql2 = "DELETE FROM cobranzas WHERE Id_Venta = :id";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([':id' => $id]);

            $sql3 = "DELETE FROM ventas WHERE Id = :id";
            $stmt3 = $pdo->prepare($sql3);
            $stmt3->execute([':id' => $id]);

            echo json_encode(["mensaje" => "Venta eliminada con éxito"]);
        } catch (PDOException $e) {
            echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
        }
    }
}
