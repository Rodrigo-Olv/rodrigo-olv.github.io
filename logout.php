<?php
// Inicia o recupera la sesión actual
session_start();

// Destruye todos los datos de la sesión
session_unset();
session_destroy();

// Redirige al usuario a la página de inicio
header("Location: index.php");
exit;
?>
