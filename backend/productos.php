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
    
    if($accion == 'crear'){
        $nombre = $_POST["nombre"] ?? "";
        $stock = $_POST["produccion"] ?? 0;
        $precio = $_POST["precio_unitario"] ?? 0;
        $descuento = $_POST["descuento"] ?? 0;
        $id_presentacion = $_POST["id_presentacion"] ?? null;
        $fecha = $_POST["fecha_creacion"] ?? date();
        $estado = $_POST["estado"] ?? 1; // 1 = Activo, 0 = Inactivo

        $carpeta_destino = "../assets/productos/"; // Carpeta donde se guardará la imagen

        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            $nombre_imagen = time() . "_" . basename($_FILES["imagen"]["name"]); // Evita nombres repetidos
            $ruta_final = $carpeta_destino . $nombre_imagen;

            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_final)) {
                $imagen_ruta = "assets/productos/" . $nombre_imagen; // Ruta relativa para la base de datos
            } else {
                die("Error al mover la imagen a la carpeta destino.");
            }
        } else {
            die("Error en la subida de la imagen.");
        }


        // Insertar datos en la base de datos
        try {
            // Verificar si el producto ya existe
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
            $sql = "INSERT INTO productos (Nombre, Fecha_Creacion, Estado, Imagen) 
                    VALUES (:nombre, :fecha, :estado, :imagen)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":nombre" => $nombre,
                ":fecha" => $fecha,
                ":estado" => $estado,
                ":imagen" => $imagen_ruta
            ]);
        
            // Obtener el ID del producto recién insertado
            $producto_id = $pdo->lastInsertId();
        
            // Insertar en la tabla Producto_Presentacion
            $sql_presentacion = "INSERT INTO Producto_Presentacion (Id_Producto, Id_Presentacion, Precio_Unitario, Descuento, Produccion_Actual) VALUES (:producto_id, :presentacion_id, :precio, :descuento, :produccion)";
            $stmt_presentacion = $pdo->prepare($sql_presentacion);
            $stmt_presentacion->execute([
                ":producto_id" => $producto_id,
                ":presentacion_id" => $id_presentacion,
                ":precio" => $precio,
                ":descuento" => $descuento,
                ":produccion" => $stock  // Debes asegurarte de que este valor viene del formulario
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
