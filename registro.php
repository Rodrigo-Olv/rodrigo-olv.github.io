<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$nombre, $email, $password])) {
        echo "Registro exitoso. Puedes iniciar sesión ahora.";
    } else {
        echo "Error en el registro.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <title>Registro</title>
</head>
<header>
<?php
include 'header.php';
?>
</header>
<body class="body-ajustado">
    <div class="contenido">
        <h1 class="inicio-sesion">Registro de Usuario</h1>
        <form method="POST" action="" class="formulario-login">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <br>
            <input type="submit" value="Registrar">
        </form>
        <br>
        <a id="volver" href="login.php"><button class="boton-pago">Volver a Iniciar Sesión</button></a>
    </div>
</body>
<footer>
<?php
include 'footer.php';
?>
</footer>
</html>
