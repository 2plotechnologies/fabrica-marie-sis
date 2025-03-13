<?php
require 'conexion.php'; // Importar la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Filtrar y sanitizar los datos
    $dni = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_STRING);
    $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);
    $password = $_POST["password"]; // No sanitizamos aquí porque será encriptada
    $correo = filter_input(INPUT_POST, "correo", FILTER_VALIDATE_EMAIL);
    $telefono = filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_NUMBER_INT);
    $id_rol = filter_input(INPUT_POST, "id_rol", FILTER_VALIDATE_INT);
    $estado = filter_input(INPUT_POST, "estado", FILTER_VALIDATE_INT);
    $avatar = filter_input(INPUT_POST, "options", FILTER_SANITIZE_STRING);

    // Verificar si los datos requeridos están presentes
    if (!$dni || !$nombre || !$password || !$correo || !$telefono || !$id_rol || $estado === false) {
        die("<script>alert('Error: Datos inválidos o incompletos'); window.history.back();</script>");
    }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Verificar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT Id FROM usuarios WHERE dni = ?");
    $stmt->execute([$dni]);
    if ($stmt->fetch()) {
        echo "<script>
                alert('Ya existe un usuario con ese Nro. de documento!');
                window.location.href = '../admin.php';
            </script>";
        exit;
    }

    // Insertar usuario en la base de datos
    $stmt = $pdo->prepare("INSERT INTO usuarios (DNI, Nombre, password, Email, Telefono, Id_Rol, Estado, Avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$dni, $nombre, $hashed_password, $correo, $telefono, $id_rol, $estado, $avatar])) {
        echo "<script>
                alert('Usuario creado exitosamente.');
                window.location.href = '../admin.php';
            </script>";
        exit;
    } else {
        echo "Error en el registro.";
    }
}
?>