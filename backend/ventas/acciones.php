<?php
session_start();
require '../conexion.php'; // Importar la conexión

if (!isset($_SESSION['id_Usuario'])) {
    // Si no hay sesión activa, redirige al login
    echo "ERROR: Usuario no identificado";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $accion = $_POST['accion'];

    if($accion == 'eliminar'){
        $id = $_POST["id"] ?? "";
 
         try {
             $sql = "DELETE FROM detalle_venta WHERE id_Venta = :id";
             $stmt = $pdo->prepare($sql);
             if($stmt->execute([":id" => $id])){

                $sql2 = "DELETE FROM cobranzas WHERE Id_Venta = :id";
                $stmt2 = $pdo->prepare($sql2);
                
                if($stmt2->execute([":id" => $id])){
                    $sql3 = "DELETE FROM ventas WHERE Id = :id";
                    $stmt3 = $pdo->prepare($sql3);
                    $stmt3->execute([":id" => $id]);
                    echo json_encode(["mensaje" => "Venta eliminada con éxito"]);
                }
             }
 
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
    }
}