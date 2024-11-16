<?php
$host = 'localhost'; // Cambia si es necesario
$db_name = 'moda_urbana_db'; // Nombre actualizado de tu base de datos
$username = 'root'; // Cambia al usuario de tu base de datos
$password = ''; // Cambia a la contraseña de tu base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
