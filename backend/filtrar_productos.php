<?php
require 'conexion.php';

// Obtener el ID de presentación enviado por AJAX
$id_presentacion = isset($_POST["id_presentacion"]) ? intval($_POST["id_presentacion"]) : 0;

if ($id_presentacion > 0) {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE Id_Presentacion = ?");
    $stmt->execute([$id_presentacion]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM productos");
    $stmt->execute();
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="mdl-card mdl-shadow--2dp full-width product-card">
            <div class="mdl-card__title">
                <img src="' . htmlspecialchars($row['Imagen']) . '" alt="product" class="img-responsive">
            </div>
            <div class="mdl-card__supporting-text">
                <small>' . htmlspecialchars($row['Produccion_Actual']) . '</small><br>
                <small>' . htmlspecialchars($row['Precio_Unitario']) . '</small>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                ' . htmlspecialchars($row['Nombre']) . '
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="zmdi zmdi-more"></i>
                </button>
            </div>
        </div>';
}
?>
