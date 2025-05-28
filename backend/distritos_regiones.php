<?php 
    session_start();
    require 'conexion.php'; // Importar la conexión

    if (!isset($_SESSION['id_Usuario'])) {
        // Si no hay sesión activa, redirige al login
        echo "ERROR: Usuario no identificado";
        die();
    }

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];

       if ($accion == 'crear') {
            // Sanitizar entradas
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_NUMBER_INT);

            // Validaciones
            $errores = [];
            if (empty($nombre)) $errores[] = "El nombre es obligatorio.";
            if (!in_array($estado, [0, 1])) $errores[] = "Estado inválido.";

            if (!empty($errores)) {
                echo "<script>alert('Error al crear registro:\\n" . implode("\\n", $errores) . "'); window.location.href = '../company.php';</script>";
                exit;
            }

            // Insertar en la base de datos
            $stmt = $pdo->prepare("INSERT INTO distritos_regiones (Region_Distrito, Estado) VALUES (?, ?)");
            if ($stmt->execute([$nombre, $estado])) {
                echo "<script>
                        alert('Registro creado exitosamente.');
                        window.location.href = '../company.php';
                    </script>";
                exit;
            } else {
                echo "<script>alert('Error en la creación.'); window.location.href = '../company.php';</script>";
            }
        }


         if ($accion === 'editar') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];

            $stmt = $pdo->prepare("UPDATE distritos_regiones SET Region_Distrito = ? WHERE Id = ?");
            $stmt->execute([$nombre, $id]);

            echo json_encode(["mensaje" => "Registro actualizado correctamente."]);
        }

        if ($accion === 'desactivar') {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("UPDATE distritos_regiones SET Estado = 0 WHERE Id = ?");
            $stmt->execute([$id]);
            echo json_encode(["mensaje" => "Registro desactivado correctamente."]);
        }

         if ($accion === 'activar') {
            $id = $_POST['id'];
            $stmt = $pdo->prepare("UPDATE distritos_regiones SET Estado = 1 WHERE Id = ?");
            $stmt->execute([$id]);
            echo json_encode(["mensaje" => "Registro activado correctamente."]);
        }
        exit;

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
        }else if ($_GET['accion'] === 'obtener_region') {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("SELECT * FROM distritos_regiones WHERE Id = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            exit;
        }
    }