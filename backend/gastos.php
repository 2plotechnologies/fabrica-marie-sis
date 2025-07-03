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
        $documento = filter_input(INPUT_POST, "documento", FILTER_SANITIZE_STRING);
        $fecha = filter_input(INPUT_POST, "fecha", FILTER_SANITIZE_STRING);
        $id_proveedor = filter_input(INPUT_POST, "id_proveedor", FILTER_VALIDATE_INT);
        $id_usuario = filter_input(INPUT_POST, "usuario", FILTER_VALIDATE_INT);
        $descripcion = filter_input(INPUT_POST, "descripcion", FILTER_SANITIZE_STRING);
        $monto = filter_input(INPUT_POST, "monto", FILTER_SANITIZE_STRING);
        // Obtener la fecha actual (solo fecha)
        $fecha_registro = date('Y-m-d');

        // Verificar si los datos requeridos están presentes
        if (!$id_proveedor || !$fecha || !$id_usuario || !$descripcion || !$monto) {
            die("<script>alert('Error: Datos inválidos o incompletos'); window.history.back();</script>");
        }

        // Verificar si el documento ya existe
        if($documento != ''){
            $stmt = $pdo->prepare("SELECT Id FROM gastos WHERE NumeroDocumento = ?");
            $stmt->execute([$documento]);
            if ($stmt->fetch()) {
                echo "<script>
                        alert('Ya existe un gasto con ese Nro. de documento!');
                        window.location.href = '../payments.php';
                    </script>";
                exit;
            }
        }
        

        // Insertar proveedor en la base de datos
        $stmt = $pdo->prepare("INSERT INTO gastos (NumeroDocumento, Fecha, IdProveedor, Descripcion, Monto, Fecha_Registro, Id_Usuario) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$documento, $fecha, $id_proveedor, $descripcion, $monto, $fecha_registro, $id_usuario])) {
            echo "<script>
                    alert('Gasto registrado exitosamente.');
                    window.location.href = '../payments.php';
                </script>";
            exit;
        } else {
            echo "Error en el registro.";
        }
    }else if($accion == 'eliminar'){
        $id = $_POST["id"] ?? "";

         if (empty($id) || !is_numeric($id)) {
            die("<script>alert('Error: Datos no validos'); window.history.back();</script>");
        }
 
         try {
             $sql = "DELETE FROM gastos WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Gasto eliminado con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
    }
}
?>