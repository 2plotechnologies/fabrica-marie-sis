<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Evitar que el usuario vuelva atrás con el botón del navegador
echo "<script>
        sessionStorage.clear(); // Limpiar almacenamiento en el navegador
        localStorage.clear(); // Opcional: limpiar almacenamiento persistente
        window.location.href = '../index.html';
      </script>";
exit;
?>
