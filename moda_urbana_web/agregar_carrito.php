<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

// Depuración para verificar si la sesión de usuario está presente
if (!isset($_SESSION['usuario'])) {
    echo json_encode([
        "success" => false,
        "message" => "Debe iniciar sesión para agregar productos al carrito.",
        "logged_in" => false
    ]);
    exit;
}

// Si el usuario está autenticado
if (isset($_POST['producto_id'], $_POST['cantidad'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $usuario_id = $_SESSION['usuario'];

    // Verificar si el carrito ya tiene el producto
    $stmt = $pdo->prepare("SELECT * FROM carrito WHERE usuario_id = ? AND producto_id = ?");
    $stmt->execute([$usuario_id, $producto_id]);
    $producto_en_carrito = $stmt->fetch();

    if ($producto_en_carrito) {
        // Actualizar la cantidad
        $nueva_cantidad = $producto_en_carrito['cantidad'] + $cantidad;
        $stmt = $pdo->prepare("UPDATE carrito SET cantidad = ? WHERE id = ?");
        $stmt->execute([$nueva_cantidad, $producto_en_carrito['id']]);
    } else {
        // Agregar nuevo producto al carrito
        $stmt = $pdo->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
        $stmt->execute([$usuario_id, $producto_id, $cantidad]);
    }

    // Enviar respuesta JSON de éxito
    echo json_encode([
        "success" => true,
        "message" => "Producto añadido al carrito correctamente."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Datos insuficientes para agregar al carrito."
    ]);
}
?>
