<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['id_Usuario'])) {
    // Si no hay sesión activa, redirige al login
    echo "ERROR: Usuario no identificado";
    die();
}

// Obtener el ID de presentación enviado por AJAX
$id_presentacion = isset($_POST["id_presentacion"]) ? intval($_POST["id_presentacion"]) : 0;

$sql = "
    SELECT p.Id, p.Nombre, p.Imagen, p.Estado, pp.Produccion_Actual, pr.Presentacion, pp.Precio_Unitario 
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
            "Id" => $id_producto,
            "Nombre" => $row['Nombre'],
            "Imagen" => $row['Imagen'],
            "Estado" => $row['Estado'],
            "Presentaciones" => []
        ];
    }

    // Agregar presentaciones y precios
    $productos[$id_producto]["Presentaciones"][] = [
        "Presentacion" => $row['Presentacion'],
        "Precio_Unitario" => $row['Precio_Unitario'],
        "Produccion_Actual" => $row['Produccion_Actual'],
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
                    <strong>Presentaciones y Precios:</strong><br>';

    foreach ($producto["Presentaciones"] as $presentacion) {
        $html .= '<small>' . htmlspecialchars($presentacion["Presentacion"]) . ': S/' . htmlspecialchars($presentacion["Precio_Unitario"]) . '</small><br>';
        $html .= '<small>Producción Actual: ' . htmlspecialchars($presentacion['Produccion_Actual']) . '</small><br>';
    }

    $html .= '</div>
                <div class="mdl-card__actions mdl-card--border">
                    ' . htmlspecialchars($producto['Nombre']) . '
                    <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" onclick="mostrarOpciones(this, '. htmlspecialchars($producto['Id']) . ')">
                        <i class="zmdi zmdi-more"></i>
                    </button>
                    <div id="opciones-flotantes'. htmlspecialchars($producto['Id']) . '" class = "hidden">
							<button class="boton boton-verde" onclick="verDetalles('. htmlspecialchars($producto['Id']) . ')">Ver detalles</button>';
    if($producto["Estado"] == 1){
        $html.= '<button class="boton boton-rojo" onclick="desactivarProducto('. htmlspecialchars($producto['Id']) .')">Desactivar</button>
						</div>
                </div>
            </div>';
    }else{
        $html.= '<button class="boton boton-verde" onclick="activarProducto('. htmlspecialchars($producto['Id']) .')">Activar</button>
						</div>
                </div>
            </div>';
    }
}

// Devolver el HTML completo en una sola salida
echo $html;
?>