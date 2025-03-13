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
        $stmt = $pdo->prepare("INSERT INTO clientes (TipoDocumento, Numero_Documento, NombreCliente, Direccion, Telefono, Correo, Estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$tipo, $documento, $nombre, $direccion, $telefono, $correo, $estado])) {
            echo "<script>
                    alert('Cliente creado exitosamente.');
                    window.location.href = '../client.php';
                </script>";
            exit;
        } else {
            echo "Error en la creación.";
        }
    }