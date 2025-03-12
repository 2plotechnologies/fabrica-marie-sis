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
        // Insertar usuario en la base de datos
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