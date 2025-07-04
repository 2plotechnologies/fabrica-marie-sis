<?php
session_start();
require 'conexion.php'; // Importar la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Buscar usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE DNI = ? AND Estado = 1");
    $stmt->execute([$dni]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["documento"] = $dni;
        $_SESSION["usuario"] = $user["Nombre"];
        $_SESSION["id_Usuario"] = $user["Id"];
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