<?php
require 'conexion.php'; // Importar la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $accion = $_POST["accion"];

    if($accion == 'crear'){
         // Filtrar y sanitizar los datos
        $documento = filter_input(INPUT_POST, "documento", FILTER_SANITIZE_STRING);
        $id_proveedor = filter_input(INPUT_POST, "id_proveedor", FILTER_VALIDATE_INT);
        $descripcion = filter_input(INPUT_POST, "descripcion", FILTER_SANITIZE_STRING);
        $monto = filter_input(INPUT_POST, "monto", FILTER_SANITIZE_STRING);

        // Verificar si los datos requeridos están presentes
        if (!$id_proveedor || !$descripcion || !$monto) {
            die("<script>alert('Error: Datos inválidos o incompletos'); window.history.back();</script>");
        }

        // Verificar si el documento ya existe
        if($documento != ''){
            $stmt = $pdo->prepare("SELECT Id FROM gastos WHERE NumeroDocumento = ?");
            $stmt->execute([$documento]);
            if ($stmt->fetch()) {
                echo "<script>
                        alert('Ya existe un gasto con ese Nro. de documento!');
                        window.location.href = '../payments.php';
                    </script>";
                exit;
            }
        }
        

        // Insertar proveedor en la base de datos
        $stmt = $pdo->prepare("INSERT INTO gastos (NumeroDocumento, IdProveedor, Descripcion, Monto) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$documento, $id_proveedor, $descripcion, $monto])) {
            echo "<script>
                    alert('Gasto registrado exitosamente.');
                    window.location.href = '../payments.php';
                </script>";
            exit;
        } else {
            echo "Error en el registro.";
        }
    }
}
?>