<?php 

    require 'conexion.php'; // Importar la conexión
    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];

        if($accion == 'crear'){
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'];
            // Insertar usuario en la base de datos
            $stmt = $pdo->prepare("INSERT INTO distritos_regiones(Region_Distrito, Estado) VALUES (?, ?)");
            if ($stmt->execute([$nombre, $estado])) {
                echo "<script>
                        alert('Registro creado exitosamente.');
                        window.location.href = '../company.php';
                    </script>";
                exit;
            } else {
                echo "Error en la creación.";
            }
        }
    }

    if(isset($_GET['accion'])){
        if($_GET['accion'] == 'obtener'){
            if (isset($_GET['id_region'])) {
                $id_region = intval($_GET['id_region']);
            
                $stmt = $pdo->prepare("
                    SELECT * from clientes
                    WHERE Id_Region = ?
                ");
                $stmt->execute([$id_region]);
            
                $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($clientes);
            }
        }
    }