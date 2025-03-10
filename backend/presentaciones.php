<?php 
    require 'conexion.php'; // Importar la conexión
    $accion = $_POST['accion'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    if($accion == 'crear'){
        // Insertar usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO presentaciones (Presentacion, Descripcion) VALUES (?, ?)");
        if ($stmt->execute([$nombre, $descripcion])) {
            echo "<script>
                    alert('Presentación creada exitosamente.');
                    window.location.href = '../categories.php';
                </script>";
            exit;
        } else {
            echo "Error en la creación.";
        }
    }