<?php
$host = "localhost"; // Cambia esto si tu base de datos está en otro servidor
$dbname = "fabrica_db";
$username = "root";
$password = "";

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activa las excepciones para errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Obtiene resultados como array asociativo
        PDO::ATTR_EMULATE_PREPARES => false // Desactiva la emulación de declaraciones preparadas
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
    //echo "Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
