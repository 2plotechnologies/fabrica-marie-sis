<?php
session_start();
require 'conexion.php'; // Importar la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];
    $password = $_POST["password"];

    // Buscar usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE DNI = ?");
    $stmt->execute([$dni]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["documento"] = $dni;
        $_SESSION["usuario"] = $user["Nombre"];
        echo "Inicio de sesión exitoso. Bienvenido, " . htmlspecialchars($_SESSION["usuario"]) . "!";
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}
?>