<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<header>
<?php
include 'header.php';
?>
</header>
<body  class="body-ajustado">
    <div class="contenido">
    <h1>Contacto</h1>
    <form action="enviar_contacto.php" method="post" class="formulario-contacto">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" required></textarea>

        <button type="submit">Enviar</button>
    </form>

    </div>
</body>
<footer>
<?php
include 'footer.php';
?>
</footer>
</html>
