<?php
session_start();
require 'conexion.php'; // Importamos la conexión a la base de datos

if (!isset($_SESSION['id_Usuario'])) {
    // Si no hay sesión activa, redirige al login
    echo "ERROR: Usuario no identificado";
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $accion = $_POST["accion"];
    
    if ($accion == 'crear') {
        // Sanitización de entradas
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $stock = filter_input(INPUT_POST, 'produccion', FILTER_VALIDATE_INT);
        $precio = filter_input(INPUT_POST, 'precio_unitario', FILTER_VALIDATE_FLOAT);
        $descuento = filter_input(INPUT_POST, 'descuento', FILTER_VALIDATE_FLOAT);
        $id_presentacion = filter_input(INPUT_POST, 'id_presentacion', FILTER_VALIDATE_INT);
        $fecha = filter_input(INPUT_POST, 'fecha_creacion', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_VALIDATE_INT);

        $errores = [];

        // Validaciones básicas
        if (!$nombre) $errores[] = "El nombre del producto es obligatorio.";
        if ($stock === false || $stock < 0) $errores[] = "Stock inválido.";
        if ($precio === false || $precio < 0) $errores[] = "Precio inválido.";
        if ($descuento === false || $descuento < 0) $errores[] = "Descuento inválido.";
        if (!$id_presentacion) $errores[] = "Presentación inválida.";
        if (!$estado) $estado = 1; // Valor por defecto si no se proporciona
        if (!$fecha) $fecha = date('Y-m-d');

        // Validar imagen
        $carpeta_destino = "../assets/productos/";
        $imagen_ruta = "";
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            $tipo_archivo = mime_content_type($_FILES["imagen"]["tmp_name"]);
            $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($tipo_archivo, $permitidos)) {
                $errores[] = "El tipo de imagen no es válido. Solo se permiten JPG, PNG y WEBP.";
            } else {
                $nombre_imagen = time() . "_" . basename($_FILES["imagen"]["name"]);
                $ruta_final = $carpeta_destino . $nombre_imagen;

                if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_final)) {
                    $errores[] = "Error al mover la imagen a la carpeta destino.";
                } else {
                    $imagen_ruta = "assets/productos/" . $nombre_imagen;
                }
            }
        } else {
            $errores[] = "Debe subir una imagen válida.";
        }

        // Mostrar errores si existen
        if (!empty($errores)) {
            echo "<script>alert('Errores al registrar el producto:\\n" . implode("\\n", $errores) . "'); window.history.back();</script>";
            exit;
        }

        try {
            // Verificar duplicado
            $stmt = $pdo->prepare("SELECT Id FROM productos WHERE Nombre = ?");
            $stmt->execute([$nombre]);
            if ($stmt->fetch()) {
                echo "<script>
                        alert('Ya existe un producto con ese Nombre!');
                        window.location.href = '../products.php';
                    </script>";
                exit;
            }

            // Insertar producto
            $stmt = $pdo->prepare("INSERT INTO productos (Nombre, Fecha_Creacion, Estado, Imagen) 
                                VALUES (:nombre, :fecha, :estado, :imagen)");
            $stmt->execute([
                ":nombre" => $nombre,
                ":fecha" => $fecha,
                ":estado" => $estado,
                ":imagen" => $imagen_ruta
            ]);

            $producto_id = $pdo->lastInsertId();

            // Insertar presentación del producto
            $stmt = $pdo->prepare("INSERT INTO Producto_Presentacion 
                                (Id_Producto, Id_Presentacion, Precio_Unitario, Descuento, Produccion_Actual) 
                                VALUES (:producto_id, :presentacion_id, :precio, :descuento, :produccion)");
            $stmt->execute([
                ":producto_id" => $producto_id,
                ":presentacion_id" => $id_presentacion,
                ":precio" => $precio,
                ":descuento" => $descuento,
                ":produccion" => $stock
            ]);

            echo "<script>alert('Producto registrado con éxito'); window.location.href = '../products.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    } else if ($accion == 'desactivar'){
       // $id = $_POST["id"] ?? "";

        $id = $_POST["id"] ?? "";

        try {
            $sql = "UPDATE productos SET Estado = '0' WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":id" => $id]);

            echo json_encode(["mensaje" => "Producto desactivado con éxito"]);
        } catch (PDOException $e) {
            echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
        }
    } else if ($accion == 'obtener'){
        $id = $_POST["id"] ?? "";
        
        if ($id > 0) {
            // Obtener datos del producto
            $stmt = $pdo->prepare("SELECT * FROM productos WHERE Id = ?");
            $stmt->execute([$id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            // Obtener presentaciones asociadas al producto
            $stmt = $pdo->prepare("SELECT pr.Id, pr.Presentacion, pp.Precio_Unitario, pp.Descuento, pp.Produccion_Actual 
                                FROM Producto_Presentacion pp 
                                INNER JOIN Presentaciones pr ON pp.Id_Presentacion = pr.Id
                                WHERE pp.Id_Producto = ?");
            $stmt->execute([$id]);
            $presentaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Obtener todas las opciones de presentación disponibles
            $stmt = $pdo->prepare("SELECT Id, Presentacion FROM Presentaciones");
            $stmt->execute();
            $opcionesPresentacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode(["producto" => $producto, "presentaciones" => $presentaciones, "opcionesPresentacion" => $opcionesPresentacion]);
        } else {
            echo json_encode(["error" => "Producto no encontrado"]);
        }
    } else if ($accion == 'actualizar'){
        $id = $_POST["productoId"] ?? "";
        $nombre = $_POST["nombre"] ?? "";
        $produccion = $_POST["produccion"] ?? "";

         // Verificar si el producto ya existe
        $stmt = $pdo->prepare("SELECT Id FROM productos WHERE Nombre = :nombre AND Id != :id");
        $stmt->execute([
            ":nombre" => $nombre,
             ":id" => $id
        ]);
        if ($stmt->fetch()) {
            echo json_encode(["mensaje" => "Ya existe un producto con ese Nombre!"]);
            exit;
        }

        try {
            $sql = "UPDATE productos SET Nombre = :nombre
                    WHERE Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nombre" => $nombre,
                ":id" => $id
            ]);

            echo json_encode(["mensaje" => "Producto actualizado con éxito"]);
        } catch (PDOException $e) {
            echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
        }
    }else if ($accion == 'activar'){
        // $id = $_POST["id"] ?? "";
 
         $id = $_POST["id"] ?? "";
 
         try {
             $sql = "UPDATE productos SET Estado = '1' WHERE Id = :id";
             $stmt = $pdo->prepare($sql);
             $stmt->execute([":id" => $id]);
 
             echo json_encode(["mensaje" => "Producto activado con éxito"]);
         } catch (PDOException $e) {
             echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
         }
     }
}
?>
