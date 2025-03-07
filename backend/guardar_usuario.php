<?php
require 'conexion.php'; // Importar la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Cifrar la contraseña
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $id_rol = $_POST["id_rol"];
    $estado = $_POST["estado"]; // Cifrar la contraseña

    // Verificar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT Id FROM usuarios WHERE dni = ?");
    $stmt->execute([$dni]);
    if ($stmt->fetch()) {
        echo "El usuario ya está registrado.";
        exit;
    }

    // Insertar usuario en la base de datos
    $stmt = $pdo->prepare("INSERT INTO usuarios (DNI, Nombre, password, Email, Telefono, Id_Rol, Estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$dni, $nombre, $password, $correo, $telefono, $id_rol, $estado])) {
        echo "Registro exitoso. Ahora puedes iniciar sesión.";
    } else {
        echo "Error en el registro.";
    }
}
?>