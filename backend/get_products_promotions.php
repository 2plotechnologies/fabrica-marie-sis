<?php
    require 'conexion.php';

    // Obtener productos con presentaciones y precios
    $queryProductos = "
        SELECT 
            p.Id AS id_producto, 
            p.Nombre AS nombre, 
            pr.Presentacion AS presentacion, 
            pp.Precio_Unitario AS precio_unitario,
            'Producto' AS tipo
        FROM productos p
        INNER JOIN producto_presentacion pp ON p.Id = pp.Id_Producto
        INNER JOIN presentaciones pr ON pp.Id_Presentacion = pr.Id
        WHERE p.Estado = 1
    ";
    $stmtProductos = $pdo->query($queryProductos);
    $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

    // Obtener promociones activas con sus precios y cantidades
    $queryPromociones = "
        SELECT 
            promo.Id AS id_promocion,
            p.Nombre AS nombre, 
            pr.Presentacion AS presentacion, 
            promo.Nuevo_Precio AS precio_unitario,
            promo.Cantidad AS cantidad,
            'Promoción' AS tipo
        FROM promociones promo
        INNER JOIN productos p ON promo.Id_Producto = p.Id
        INNER JOIN presentaciones pr ON promo.Id_Presentacion = pr.Id
    ";
    $stmtPromociones = $pdo->query($queryPromociones);
    $promociones = $stmtPromociones->fetchAll(PDO::FETCH_ASSOC);

    // Combinar productos y promociones
    $resultado = array_merge($productos, $promociones);

    // Enviar respuesta en JSON
    header('Content-Type: application/json');
    echo json_encode($resultado);
?>
