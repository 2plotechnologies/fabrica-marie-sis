<?php
session_start();
require 'conexion.php'; // Importar la conexión

if (!isset($_SESSION['id_Usuario'])) {
    // Si no hay sesión activa, redirige al login
    echo "ERROR: Usuario no identificado";
    die();
}

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
        // Insertar promocion en la base de datos
        $stmt = $pdo->prepare("INSERT INTO promociones (Id_Producto, Id_Presentacion, Nuevo_Precio, Descripcion, Cantidad, Estado) VALUES (?, ?, ?, ?, ?, '1')");
        if ($stmt->execute([$id_producto, $id_presentacion, $monto, $descripcion, $cantidad])) {
            echo "<script>
                    alert('Promoción registrada exitosamente.');
                    window.location.href = '../promotions.php';
                </script>";
            exit;
        } else {
            echo "Error en el registro.";
        }
    }else if ($accion == 'desactivar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";
 
         try {
             $sql = "UPDATE promociones SET Estado = '0' WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Promoción desactivada con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
     }else if ($accion == 'activar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";
 
         try {
             $sql = "UPDATE promociones SET Estado = '1' WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Promoción activada con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
    }else if ($accion == 'actualizar'){
        $id = $_POST["promocionId"] ?? "";
        $cantidad = $_POST["cantidadPromocion"] ?? "";
        $descripcion = $_POST["descripcionPromocion"] ?? "";
        $precio = $_POST["preciopromo"] ?? "";

        try {
            $sql = "UPDATE promociones SET Cantidad = :cantidad, Descripcion = :descripcion, Nuevo_Precio = :precio
                    WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":cantidad" => $cantidad,
                ":descripcion" => $descripcion,
                ":precio" => $precio,
                ":id" => $id
            ]);

            echo json_encode(["mensaje" => "Promocion actualizada con éxito"]);
        } catch (PDOException $e) {
            echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
        }
    }else if ($accion == 'obtener'){
        $id = $_POST["id"] ?? "";
        
        if ($id > 0) {
             // Obtener datos del producto
             $stmt = $pdo->prepare("SELECT * FROM promociones WHERE Id = ?");
             $stmt->execute([$id]);
             $promocion = $stmt->fetch(PDO::FETCH_ASSOC);
             echo json_encode(["promocion" => $promocion]);
        }
    }

}
?>