<?php 

    require 'conexion.php'; // Importar la conexión
    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];

        if($accion == 'crear'){
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
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
    }

    if(isset($_GET['accion'])){
        if($_GET['accion'] == 'obtener'){
            if (isset($_GET['id_producto'])) {
                $id_producto = intval($_GET['id_producto']);
            
                $stmt = $pdo->prepare("
                    SELECT pr.Id, pr.Presentacion, pp.Precio_Unitario
                    FROM Producto_Presentacion pp
                    INNER JOIN Presentaciones pr ON pp.Id_Presentacion = pr.Id
                    WHERE pp.Id_Producto = ?
                ");
                $stmt->execute([$id_producto]);
            
                $presentaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($presentaciones);
            }
        }
    }