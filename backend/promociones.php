<?php
require 'conexion.php'; // Importar la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $accion = $_POST["accion"];

    if($accion == 'crear'){
         // Filtrar y sanitizar los datos
        $id_producto = filter_input(INPUT_POST, "id_producto", FILTER_SANITIZE_STRING);
        $id_presentacion = filter_input(INPUT_POST, "id_presentacion", FILTER_VALIDATE_INT);
        $descripcion = filter_input(INPUT_POST, "descripcion", FILTER_SANITIZE_STRING);
        $cantidad = filter_input(INPUT_POST, "cantidad", FILTER_VALIDATE_INT);
        $monto = filter_input(INPUT_POST, "precio", FILTER_SANITIZE_STRING);

        // Verificar si los datos requeridos están presentes
        if (!$id_producto || !$id_presentacion || !$descripcion || !$cantidad || !$monto) {
            die("<script>alert('Error: Datos inválidos o incompletos'); window.history.back();</script>");
        }
        // Insertar proveedor en la base de datos
        $stmt = $pdo->prepare("INSERT INTO promociones (Id_Producto, Id_Presentacion, Nuevo_Precio, Descripcion, Cantidad) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$id_producto, $id_presentacion, $monto, $descripcion, $cantidad])) {
            echo "<script>
                    alert('Promoción registrada exitosamente.');
                    window.location.href = '../promotions.php';
                </script>";
            exit;
        } else {
            echo "Error en el registro.";
        }
    }
}
?>