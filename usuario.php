<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<header>
<?php
include 'header.php';
?>
</header>
<body>
    <h1>Perfil de <?= htmlspecialchars($_SESSION['usuario']); ?></h1>
    <p>Bienvenido/a, <?= htmlspecialchars($_SESSION['usuario']); ?>. Aquí puedes ver y editar tu información de perfil.</p>
    <a href="editar_usuario.php">Editar perfil</a>
    <a href="logout.php">Cerrar sesión</a>
</body>
<footer>
<?php
include 'footer.php';
?>
</footer>
</html>
