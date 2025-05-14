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
        $ruc = filter_input(INPUT_POST, "ruc", FILTER_SANITIZE_STRING);
        $razon_social = filter_input(INPUT_POST, "razon_social", FILTER_SANITIZE_STRING);
        $direccion = filter_input(INPUT_POST, "direccion", FILTER_SANITIZE_STRING);
        //$telefono = $_POST['telefono'];
        //$correo = $_POST['correo'];
        $correo = filter_input(INPUT_POST, "correo", FILTER_VALIDATE_EMAIL);
        $telefono = filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_NUMBER_INT);
        $web = filter_input(INPUT_POST, "web", FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, "estado", FILTER_VALIDATE_INT);

        // Verificar si los datos requeridos están presentes
        if (!$ruc || !$razon_social || !$direccion || !$correo || !$telefono || $estado === false) {
            die("<script>alert('Error: Datos inválidos o incompletos'); window.history.back();</script>");
        }

        // Verificar si el proveedor ya existe
        $stmt = $pdo->prepare("SELECT Id FROM proveedores WHERE RUC = ?");
        $stmt->execute([$ruc]);
        if ($stmt->fetch()) {
            echo "<script>
                    alert('Ya existe un proveedor con ese Nro. de RUC!');
                    window.location.href = '../providers.php';
                </script>";
            exit;
        }

        // Insertar proveedor en la base de datos
        $stmt = $pdo->prepare("INSERT INTO proveedores (RUC, Razon_Social, Direccion, Telefono, Correo, Web, Estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$ruc, $razon_social, $direccion, $telefono, $correo, $web, $estado])) {
            echo "<script>
                    alert('Proveedor creado exitosamente.');
                    window.location.href = '../providers.php';
                </script>";
            exit;
        } else {
            echo "Error en el registro.";
        }
    }else if ($accion == 'desactivar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";
 
         try {
             $sql = "UPDATE proveedores SET Estado = '0' WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Proveedor desactivado con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
     }else if ($accion == 'activar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";
 
         try {
             $sql = "UPDATE proveedores SET Estado = '1' WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Proveedor activado con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
    }else if ($accion == 'actualizar'){
        $id = $_POST["proveedorId"] ?? "";
        $doc = $_POST["nruc"] ?? "";
        $nombre = $_POST["nombreProveedor"] ?? "";
        $direccion = $_POST["direccionProveedor"] ?? "";
        $telefono = $_POST["telefonoProveedor"] ?? "";
        $correo = $_POST["correoProveedor"] ?? "";
        $web = $_POST["webProveedor"] ?? "";

        try {
            $sql = "UPDATE proveedores SET RUC = :doc, Razon_Social = :nombre, Direccion = :direccion, Telefono = :telefono, Correo = :correo, Web = :web
                    WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":doc" => $doc,
                ":nombre" => $nombre,
                ":direccion" => $direccion,
                ":telefono" => $telefono,
                ":correo" => $correo,
                ":web" => $web,
                ":id" => $id
            ]);

            echo json_encode(["mensaje" => "Proveedor actualizado con éxito"]);
        } catch (PDOException $e) {
            echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
        }
    }else if ($accion == 'obtener'){
        $id = $_POST["id"] ?? "";
        
        if ($id > 0) {
             // Obtener datos del producto
             $stmt = $pdo->prepare("SELECT * FROM proveedores WHERE Id = ?");
             $stmt->execute([$id]);
             $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
             echo json_encode(["proveedor" => $proveedor]);
        }
    }
}
?>