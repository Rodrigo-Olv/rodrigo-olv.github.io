<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos enviados por AJAX
    $nombre = $_POST['nombre'];
    $talla = $_POST['talla'];
    $color = $_POST['color'];
    $precio = $_POST['precio'];

    // Crear el producto como un array
    $producto = [
        'nombre' => $nombre,
        'talla' => $talla,
        'color' => $color,
        'precio' => $precio,
        'cantidad' => 1 // Inicia con 1 unidad
    ];

    // Comprobar si el carrito ya existe en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el producto ya está en el carrito
    $producto_existente = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['nombre'] == $nombre && $item['talla'] == $talla && $item['color'] == $color) {
            $item['cantidad']++; // Aumentar la cantidad si es el mismo producto con misma talla y color
            $producto_existente = true;
            break;
        }
    }

    // Si el producto no existe en el carrito, agregarlo
    if (!$producto_existente) {
        $_SESSION['carrito'][] = $producto;
    }

    // Respuesta de éxito
    http_response_code(200);
    echo json_encode(['message' => 'Producto añadido al carrito']);
}
?>
