<?php
session_start();
include 'db.php'; // Asegúrate de que este archivo incluya la conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    // Si la sesión está activa, devolvemos el ID del usuario
    echo json_encode([
        "success" => true,
        "usuario_id" => $_SESSION['usuario']
    ]);
} else {
    // Si la sesión no está activa, devolvemos un mensaje de error
    echo json_encode([
        "success" => false,
        "message" => "No hay sesión activa."
    ]);
}
?>
