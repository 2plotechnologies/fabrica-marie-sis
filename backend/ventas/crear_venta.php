<?php
session_start();
require '../conexion.php'; // Importar la conexión

if (!isset($_SESSION['id_Usuario'])) {
    // Si no hay sesión activa, redirige al login
    echo "ERROR: Usuario no identificado";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Filtrar y sanitizar los datos
    $fecha = filter_input(INPUT_POST, "fecha", FILTER_SANITIZE_STRING);
    $id_cliente = filter_input(INPUT_POST, "cliente", FILTER_VALIDATE_INT);
    if(isset($_POST['vendedor'])){
        $id_vendedor = filter_input(INPUT_POST, "vendedor", FILTER_VALIDATE_INT);
    }else{
        $id_vendedor = $_SESSION["Id_Usuario"];
    }
    $tipo_pago = filter_input(INPUT_POST, "tipo_pago", FILTER_VALIDATE_INT);
    $region = filter_input(INPUT_POST, "region", FILTER_VALIDATE_INT);
    $metodo_pago = filter_input(INPUT_POST, "metodo", FILTER_VALIDATE_INT);
    $total = filter_input(INPUT_POST, "total", FILTER_SANITIZE_STRING);

    // Verificar si los datos requeridos están presentes
    if (!$fecha || !$id_cliente || !$id_vendedor || !$tipo_pago || !$region || !$metodo_pago || !$total) {
        die("<script>alert('Error: Datos inválidos o incompletos'); window.history.back();</script>");
    }

    // Insertar venta en la base de datos
    $stmt = $pdo->prepare("INSERT INTO ventas (Id_Vendedor, Id_Cliente, Fecha, Tipo_Pago, Metodo_Pago, Region_Distrito, Total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$id_vendedor, $id_cliente, $fecha, $tipo_pago, $metodo_pago, $region, $total])) {
        $id_venta = $pdo->lastInsertId(); // Obtener el ID de la venta recién creada

        // Decodificar los productos enviados desde JavaScript
        $detalles = json_decode($_POST['detalles'], true);

        if (!$detalles || !is_array($detalles)) {
            die("<script>alert('Error: No se recibieron productos o promociones'); window.history.back();</script>");
        }

        // Insertar cada detalle de venta
        $stmt_detalle = $pdo->prepare("INSERT INTO detalle_venta (Id_Venta, Producto_Promocion, Presentacion, Cantidad, Valor_Unitario, Subtotal, Tipo) VALUES (?, ?, ?, ?, ?, ?, ?)");

        foreach ($detalles as $detalle) {
            $nombre = $detalle['nombre'];
            $presentacion = $detalle['presentacion'];
            $cantidad = $detalle['cantidad'];
            $precio = $detalle['precio'];
            $total = $detalle['total'];
            $tipo = $detalle['tipo']; // 'Producto' o 'Promoción'

            if($stmt_detalle->execute([$id_venta, $nombre, $presentacion, $cantidad, $precio, $total, $tipo])){
                 // Obtener los IDs reales del producto y presentación
                $stmt_ids = $pdo->prepare("SELECT p.Id AS IdProducto, pr.Id AS IdPresentacion 
                 FROM productos p 
                 JOIN presentaciones pr ON pr.Presentacion = ? 
                 WHERE p.Nombre = ? 
                 LIMIT 1;");
                $stmt_ids->execute([$presentacion, $nombre]);

                $ids = $stmt_ids->fetch(PDO::FETCH_ASSOC);

                if ($ids) {
                    $id_producto = $ids['IdProducto'];
                    $id_presentacion = $ids['IdPresentacion'];

                    // Actualizar la producción actual restando la cantidad vendida
                    $stmt_update = $pdo->prepare("UPDATE producto_presentacion 
                                            SET Produccion_Actual = Produccion_Actual - :cantidad 
                                            WHERE Id_Producto = :id_prod AND Id_Presentacion = :id_pres");
                    $stmt_update->execute([
                        ':cantidad' => $cantidad,
                        ':id_prod' => $id_producto,
                        ':id_pres' => $id_presentacion
                    ]);
                }
            }
        }

        // NUEVO: Insertar cuotas si el tipo de pago es Crédito
        if ($tipo_pago == 2 && isset($_POST['cuotas'])) {
            $cuotas = json_decode($_POST['cuotas'], true);

            if (is_array($cuotas)) {
                $stmt_cuota = $pdo->prepare("INSERT INTO cobranzas (Id_Venta, Numero_Cuota, monto_cuota, fecha_pago, pagado) VALUES (?, ?, ?, ?, '0')");

                $numCuota = 1;
                foreach ($cuotas as $cuota) {
                    $monto = $cuota['monto'];
                    $fechaLimite = $cuota['fecha_limite'];

                    $stmt_cuota->execute([$id_venta, $numCuota, $monto, $fechaLimite]);
                    $numCuota++;
                }
            }
        }

    } else {
        echo "Error en el registro.";
    }
}
?>