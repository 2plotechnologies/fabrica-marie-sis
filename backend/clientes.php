<?php 
    session_start();
    require 'conexion.php'; // Importar la conexión

    if (!isset($_SESSION['id_Usuario'])) {
        // Si no hay sesión activa, redirige al login
        echo "ERROR: Usuario no identificado";
        die();
    }
    
    $accion = $_POST['accion'];

    if ($accion == 'crear') {
        // Sanitizar entradas
        $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
        $documento = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $region = filter_input(INPUT_POST, 'id_region', FILTER_SANITIZE_NUMBER_INT);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_NUMBER_INT);

        // Validaciones básicas
        $errores = [];
        if (empty($tipo)) $errores[] = "Tipo de documento requerido.";
        if (empty($documento)) $errores[] = "Número de documento requerido.";
        if (empty($nombre)) $errores[] = "Nombre requerido.";
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "Correo inválido.";
        if (!is_numeric($telefono)) $errores[] = "Teléfono inválido.";
        if (!is_numeric($region)) $errores[] = "Región inválida.";
        if (!in_array($estado, [0, 1])) $errores[] = "Estado inválido.";

        if (!empty($errores)) {
            echo "<script>alert('Error al crear cliente:\\n" . implode("\\n", $errores) . "'); window.location.href = '../client.php';</script>";
            exit;
        }

        // Verificar si el cliente ya existe
        $stmt = $pdo->prepare("SELECT Id FROM clientes WHERE Numero_Documento = ?");
        $stmt->execute([$documento]);
        if ($stmt->fetch()) {
            echo "<script>
                    alert('Ya existe un cliente con ese Nro. de documento!');
                    window.location.href = '../client.php';
                </script>";
            exit;
        }

        // Insertar cliente
        $stmt = $pdo->prepare("INSERT INTO clientes (TipoDocumento, Numero_Documento, NombreCliente, Direccion, Telefono, Correo, Id_Region, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$tipo, $documento, $nombre, $direccion, $telefono, $correo, $region, $estado])) {
            echo "<script>
                    alert('Cliente creado exitosamente.');
                    window.location.href = '../client.php';
                </script>";
            exit;
        } else {
            echo "<script>alert('Error en la creación.'); window.location.href = '../client.php';</script>";
        }
    }else if ($accion == 'desactivar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";

         if (empty($id) || !is_numeric($id)) {
            die("<script>alert('Error: Datos no validos'); window.history.back();</script>");
        }
 
         try {
             $sql = "UPDATE clientes SET Estado = '0' WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Cliente desactivado con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
     }else if ($accion == 'activar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";

         if (empty($id) || !is_numeric($id)) {
            die("<script>alert('Error: Datos no validos'); window.history.back();</script>");
        }
 
         try {
             $sql = "UPDATE clientes SET Estado = '1' WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Cliente activado con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
    }else if ($accion == 'actualizar'){
        $id = $_POST["clienteId"] ?? "";
        $doc = $_POST["ndocumento"] ?? "";
        $nombre = $_POST["nombrecliente"] ?? "";
        $direccion = $_POST["direccioncliente"] ?? "";
        $telefono = $_POST["telefonocliente"] ?? "";
        $correo = $_POST["correocliente"] ?? "";

        // Verificar si el cliente ya existe
        $stmt = $pdo->prepare("SELECT Id FROM clientes WHERE Numero_Documento = :doc AND Id != :id");
        $stmt->execute([
                ":doc" => $doc,
                ":id" => $id
            ]);
        if ($stmt->fetch()) {
            echo json_encode(["mensaje" => "Ya existe un cliente con ese Nro. de documento!"]);
            exit;
        }

        try {
            $sql = "UPDATE clientes SET Numero_Documento = :doc, NombreCliente = :nombre, Direccion = :direccion, Telefono = :telefono, Correo = :correo
                    WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":doc" => $doc,
                ":nombre" => $nombre,
                ":direccion" => $direccion,
                ":telefono" => $telefono,
                ":correo" => $correo,
                ":id" => $id
            ]);

            echo json_encode(["mensaje" => "Cliente actualizado con éxito"]);
        } catch (PDOException $e) {
            echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
        }
    }else if ($accion == 'obtener'){
        $id = $_POST["id"] ?? "";
        
        if ($id > 0) {
             // Obtener datos del producto
             $stmt = $pdo->prepare("SELECT * FROM clientes WHERE Id = ?");
             $stmt->execute([$id]);
             $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
             echo json_encode(["cliente" => $cliente]);
        }
    }