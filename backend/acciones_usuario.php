<?php
require 'conexion.php'; // Importar la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $accion = $_POST["accion"];

    if ($accion == 'desactivar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";
 
         try {
             $sql = "UPDATE usuarios SET Estado = '0' WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Usuario desactivado con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
     }else if ($accion == 'activar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";
 
         try {
             $sql = "UPDATE usuarios SET Estado = '1' WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Usuario activado con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
    }else if ($accion == 'actualizar') {
        $id = $_POST["usuarioId"] ?? "";
        $dni = $_POST["dni"] ?? "";
        $nombre = $_POST["nombreusuario"] ?? "";
        $password = $_POST["passowordusuario"] ?? "";
        $telefono = $_POST["telefonousuario"] ?? "";
        $correo = $_POST["correousuario"] ?? "";
        $id_rol = $_POST["id_rol"] ?? "";

        if (!$id || !$dni || !$nombre || !$correo || !$telefono) {
            die("<script>alert('Error: Datos obligatorios incompletos'); window.history.back();</script>");
        }

        try {
            $campos = [
                "DNI = :dni",
                "Nombre = :nombre",
                "Telefono = :telefono",
                "Email = :correo"
            ];
            $parametros = [
                ":dni" => $dni,
                ":nombre" => $nombre,
                ":telefono" => $telefono,
                ":correo" => $correo,
                ":id" => $id
            ];

            // Solo actualizar contraseña si se proporcionó
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $campos[] = "Password = :password";
                $parametros[":password"] = $hashed_password;
            }

            // Solo actualizar rol si se seleccionó
            if (!empty($id_rol)) {
                $campos[] = "Id_Rol = :id_rol";
                $parametros[":id_rol"] = $id_rol;
            }

            // Construir la consulta con solo los campos necesarios
            $sql = "UPDATE usuarios SET " . implode(", ", $campos) . " WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($parametros);

            echo json_encode(["mensaje" => "Usuario actualizado con éxito"]);
        } catch (PDOException $e) {
            echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
        }
}else if ($accion == 'obtener'){
        $id = $_POST["id"] ?? "";
        
        if ($id > 0) {
             // Obtener datos del producto
             $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE Id = ?");
             $stmt->execute([$id]);
             $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
             echo json_encode(["usuario" => $usuario]);
        }
    }
}