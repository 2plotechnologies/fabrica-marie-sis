<?php 

    require 'conexion.php'; // Importar la conexión
    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];

        if($accion == 'crear'){
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];

             // Verificar si la presentación ya existe
             $stmt = $pdo->prepare("SELECT Id FROM presentaciones WHERE Presentacion = ?");
             $stmt->execute([$nombre]);
             if ($stmt->fetch()) {
                 echo "<script>
                         alert('Ya existe una presentación con ese Nombre!');
                         window.location.href = '../categories.php';
                     </script>";
                 exit;
             }

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
        } else if($accion == 'asignar'){
            $id_producto = $_POST["id_producto"] ?? "";
            $id_presentacion = $_POST["id_presentacion"] ?? "";
            $produccion_actual = $_POST["produccion_actual"] ?? "";
            $precio = $_POST["precio_unitario"] ?? "";
            $descuento = $_POST["descuento"] ?? "";
        
            try {
                $sql = "INSERT INTO Producto_Presentacion (Id_Producto, Id_Presentacion, Precio_Unitario, Descuento, Produccion_Actual)
                        VALUES (:id_producto, :id_presentacion, :precio, :descuento, :produccion)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ":id_producto" => $id_producto,
                    ":id_presentacion" => $id_presentacion,
                    ":precio" => $precio,
                    ":descuento" => $descuento,
                    ":produccion" => $produccion_actual
                ]);
        
                echo json_encode(["mensaje" => "Presentación asignada con éxito"]);
            } catch (PDOException $e) {
                echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
            }
        }else if($accion == 'quitar'){
            $id_producto = $_POST["id_producto"] ?? "";
            $id_presentacion = $_POST["id_presentacion"] ?? "";
            
            try {
                $sql = "DELETE FROM Producto_Presentacion WHERE Id_Producto = :id_producto AND Id_Presentacion = :id_presentacion";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ":id_producto" => $id_producto,
                    ":id_presentacion" => $id_presentacion
                ]);
        
                echo json_encode(["mensaje" => "Presentación quitada con éxito"]);
            } catch (PDOException $e) {
                echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
            }
        }else if ($accion == 'obtener'){
            $id = $_POST["id"] ?? "";
            
            if ($id > 0) {
                 // Obtener datos del producto
                 $stmt = $pdo->prepare("SELECT * FROM presentaciones WHERE Id = ?");
                 $stmt->execute([$id]);
                 $presentacion = $stmt->fetch(PDO::FETCH_ASSOC);
                 echo json_encode(["presentacion" => $presentacion]);
            }
        }else if ($accion == 'eliminar'){
            // $id = $_POST["id"] ?? "";
     
             $id = $_POST["id"] ?? "";

             if ($id > 0) {
                // Verificar si hay productos relacionados con esta presentación
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM producto_presentacion WHERE Id_Presentacion = ?");
                $stmt->execute([$id]);
                $relacionados = $stmt->fetchColumn();
            
                if ($relacionados > 0) {
                    echo json_encode(["mensaje" => "No se puede eliminar la presentación porque está asociada a uno o más productos."]);
                } else {
                    // Ahora sí puedes eliminar la presentación
                    $stmtDelete = $pdo->prepare("DELETE FROM presentaciones WHERE Id = ?");
                    if ($stmtDelete->execute([$id])) {
                        echo json_encode(["mensaje" => "Presentación eliminada correctamente."]);
                    } else {
                        echo json_encode(["mensaje" => "Error al eliminar la presentación."]);
                    }
                }
            }
            
         }else if ($accion == 'actualizar'){
            $id = $_POST["presentacionId"] ?? "";
            $nombre = $_POST["nombrePresentacion"] ?? "";
            $descripcion = $_POST["descripcionPresentacion"] ?? "";

            // Verificar si la presentación ya existe
            $stmt = $pdo->prepare("SELECT Id FROM presentaciones WHERE Presentacion = :presentacion AND Id != :id");
            $stmt->execute([
                ":presentacion" => $nombre,
                ":id" => $id
            ]);
            if ($stmt->fetch()) {
                echo json_encode(["mensaje" => "Ya existe una presentación con ese Nombre!"]);
                exit;
            }
    
            try {
                $sql = "UPDATE presentaciones SET Presentacion = :nombre, Descripcion = :descripcion
                        WHERE Id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ":nombre" => $nombre,
                    ":descripcion" => $descripcion,
                    ":id" => $id
                ]);
    
                echo json_encode(["mensaje" => "Presentación actualizada con éxito"]);
            } catch (PDOException $e) {
                echo json_encode(["mensaje" => "Error: " . $e->getMessage()]);
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