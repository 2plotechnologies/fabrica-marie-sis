<?php
session_start();
require '../conexion.php'; // Importar la conexión

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
    $subtotal = filter_input(INPUT_POST, "subtotal", FILTER_SANITIZE_STRING);
    $igv = filter_input(INPUT_POST, "igv", FILTER_SANITIZE_STRING);
    $total = filter_input(INPUT_POST, "total", FILTER_SANITIZE_STRING);

    // Verificar si los datos requeridos están presentes
    if (!$fecha || !$id_cliente || !$id_vendedor || !$tipo_pago || !$region || !$metodo_pago || !$subtotal || !$igv || !$total) {
        die("<script>alert('Error: Datos inválidos o incompletos'); window.history.back();</script>");
    }

    // Insertar venta en la base de datos
    $stmt = $pdo->prepare("INSERT INTO ventas (Id_Vendedor, Id_Cliente, Fecha, Tipo_Pago, Metodo_Pago, Region_Distrito, Subtotal, IGV, Total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$id_vendedor, $id_cliente, $fecha, $tipo_pago, $metodo_pago, $region, $subtotal, $igv, $total])) {
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

            $stmt_detalle->execute([$id_venta, $nombre, $presentacion, $cantidad, $precio, $total, $tipo]);
        }

    } else {
        echo "Error en el registro.";
    }
}
?>