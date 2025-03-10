<?php
require 'conexion.php'; // Importamos la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST["nombre"] ?? "";
    $stock = $_POST["produccion"] ?? 0;
    $precio = $_POST["precio_unitario"] ?? 0;
    $descuento = $_POST["descuento"] ?? 0;
    $id_presentacion = $_POST["id_presentacion"] ?? null;
    $fecha = $_POST["fecha_creacion"] ?? date();
    $estado = $_POST["estado"] ?? 1; // 1 = Activo, 0 = Inactivo

    $carpeta_destino = "../assets/productos/"; // Carpeta donde se guardará la imagen

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $nombre_imagen = time() . "_" . basename($_FILES["imagen"]["name"]); // Evita nombres repetidos
        $ruta_final = $carpeta_destino . $nombre_imagen;

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_final)) {
            $imagen_ruta = "assets/productos/" . $nombre_imagen; // Ruta relativa para la base de datos
        } else {
            die("Error al mover la imagen a la carpeta destino.");
        }
    } else {
        die("Error en la subida de la imagen.");
    }


    // Insertar datos en la base de datos
    try {
        $sql = "INSERT INTO productos (Nombre, Precio_Unitario, Descuento, Produccion_Actual, Id_Presentacion, Fecha_Creacion, Estado, Imagen) 
                VALUES (:nombre, :precio, :descuento,:produccion, :id_presentacion, :fecha, :estado, :imagen)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":nombre" => $nombre,
            ":precio" => $precio,
            ":descuento" => $descuento,
            ":produccion" => $stock,
            ":id_presentacion" => $id_presentacion,
            ":fecha" => $fecha,
            ":estado" => $estado,
            ":imagen" => $imagen_ruta
        ]);

        echo "<script>alert('Producto registrado con éxito'); window.location.href = '../products.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>
