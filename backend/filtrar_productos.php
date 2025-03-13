<?php
require 'conexion.php';

// Obtener el ID de presentación enviado por AJAX
$id_presentacion = isset($_POST["id_presentacion"]) ? intval($_POST["id_presentacion"]) : 0;

$sql = "
    SELECT p.Id, p.Nombre, p.Imagen, p.Produccion_Actual, pr.Presentacion, pp.Precio_Unitario 
    FROM productos p
    INNER JOIN Producto_Presentacion pp ON p.Id = pp.Id_Producto
    INNER JOIN Presentaciones pr ON pp.Id_Presentacion = pr.Id
";

// Si se seleccionó una presentación específica, filtramos por ella
if ($id_presentacion > 0) {
    $sql .= " WHERE pp.Id_Presentacion = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_presentacion]);
} else {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

// Almacenar los productos agrupados por su ID
$productos = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id_producto = $row['Id'];

    if (!isset($productos[$id_producto])) {
        $productos[$id_producto] = [
            "Nombre" => $row['Nombre'],
            "Imagen" => $row['Imagen'],
            "Produccion_Actual" => $row['Produccion_Actual'],
            "Presentaciones" => []
        ];
    }

    // Agregar presentaciones y precios
    $productos[$id_producto]["Presentaciones"][] = [
        "Presentacion" => $row['Presentacion'],
        "Precio_Unitario" => $row['Precio_Unitario']
    ];
}

// Generar el HTML en una sola salida
$html = '';
foreach ($productos as $producto) {
    $html .= '<div class="mdl-card mdl-shadow--2dp full-width product-card">
                <div class="mdl-card__title">
                    <img src="' . htmlspecialchars($producto['Imagen']) . '" alt="product" class="img-responsive">
                </div>
                <div class="mdl-card__supporting-text">
                    <small>Producción Actual: ' . htmlspecialchars($producto['Produccion_Actual']) . '</small><br>
                    <strong>Presentaciones y Precios:</strong><br>';

    foreach ($producto["Presentaciones"] as $presentacion) {
        $html .= '<small>' . htmlspecialchars($presentacion["Presentacion"]) . ': S/' . htmlspecialchars($presentacion["Precio_Unitario"]) . '</small><br>';
    }

    $html .= '</div>
                <div class="mdl-card__actions mdl-card--border">
                    ' . htmlspecialchars($producto['Nombre']) . '
                    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                        <i class="zmdi zmdi-more"></i>
                    </button>
                </div>
            </div>';
}

// Devolver el HTML completo en una sola salida
echo $html;
?>