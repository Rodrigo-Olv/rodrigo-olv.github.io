<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['index']) && isset($_POST['accion'])) {
    $index = $_POST['index'];
    $accion = $_POST['accion'];

    // Verificar que el carrito existe
    if (isset($_SESSION['carrito'][$index])) {
        switch ($accion) {
            case 'sumar':
                $_SESSION['carrito'][$index]['cantidad']++;
                break;

            case 'restar':
                if ($_SESSION['carrito'][$index]['cantidad'] > 1) {
                    $_SESSION['carrito'][$index]['cantidad']--;
                } else {
                    // Si la cantidad llega a 1 y se resta, eliminamos el producto
                    unset($_SESSION['carrito'][$index]);
                }
                break;

            case 'eliminar':
                // Eliminar el producto del carrito
                unset($_SESSION['carrito'][$index]);
                break;
        }

        // Reorganizar el array para evitar huecos en los índices
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}

// Redirigir de vuelta al carrito
header('Location: carrito.php');
exit();
?>
