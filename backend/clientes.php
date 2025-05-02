<?php 
    require 'conexion.php'; // Importar la conexión
    $accion = $_POST['accion'];

    if($accion == 'crear'){
        $tipo = $_POST['tipo'];
        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $region = $_POST['id_region'];
        $estado = $_POST['estado'];

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
        // Insertar cliente en la base de datos
        $stmt = $pdo->prepare("INSERT INTO clientes (TipoDocumento, Numero_Documento, NombreCliente, Direccion, Telefono, Correo, Id_Region, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$tipo, $documento, $nombre, $direccion, $telefono, $correo, $region, $estado])) {
            echo "<script>
                    alert('Cliente creado exitosamente.');
                    window.location.href = '../client.php';
                </script>";
            exit;
        } else {
            echo "Error en la creación.";
        }
    }else if ($accion == 'desactivar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";
 
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