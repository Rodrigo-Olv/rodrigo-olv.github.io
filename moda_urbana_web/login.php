<?php
// Ejemplo en server_login.php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Verificar usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario'] = $user['email']; // Configura la sesión con el email o nombre del usuario.
        header("Location: index.php"); // Redirige a la página principal después de iniciar sesión.
        exit;
    } else {
        echo "Credenciales incorrectas";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos.css">
    <title>Iniciar Sesión</title>
</head>
<header>
<?php
include 'header.php';
?>
</header>
<body class="body-ajustado">
    <div class="contenido">
        <h1 class="inicio-sesion">Iniciar Sesión</h1>
        <form method="POST" action="" class="formulario-login">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <br>
            <button type="submit" value="Iniciar Sesión">Iniciar sesión</button>
        </form>
        <p class="inicio-sesion">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>

    
</body>
<footer>
<?php
include 'footer.php';
?>
</footer>
</html>
