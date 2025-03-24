<?php
session_start();
require 'conexion.php'; // Importar la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"];
    $password = $_POST["password"];

    // Buscar usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE DNI = ? AND Estado = 1");
    $stmt->execute([$dni]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["documento"] = $dni;
        $_SESSION["usuario"] = $user["Nombre"];
        $_SESSION["rol"] = $user["Id_Rol"];
        $_SESSION["avatar"] = $user["Avatar"];

         // Redirigir a home.php
         header("Location: ../home.php");
         exit;
    } else {
         // Mostrar alerta y redirigir a index.php
        echo "<script>
                alert('Usuario o contraseña incorrectos.');
                window.location.href = '../index.html';
              </script>";
        exit;
    }
}
?>