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