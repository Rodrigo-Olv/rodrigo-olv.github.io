<?php
session_start();
include 'db.php';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
// Consulta para obtener productos de la categoría seleccionada
$sql = "SELECT productos.id, productos.nombre, productos.imagen_url, MIN(variantes_productos.precio) AS precio_min
        FROM productos
        JOIN variantes_productos ON productos.id = variantes_productos.producto_id
        JOIN categorias ON productos.categoria_id = categorias.id
        WHERE categorias.nombre = :categoria
        GROUP BY productos.id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['categoria' => $categoria]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($categoria); ?></title>
    <link rel="stylesheet" href="estilos.css">
</head>
<header>
<?php
include 'header.php';
?>
</header>
<body>
    <h1><?= htmlspecialchars($categoria); ?></h1>
    <div class="catalogo">
        <?php foreach ($productos as $producto): ?>
            <div class="producto-ficha">
                <a href="ficha_producto.php?id=<?= $producto['id']; ?>">
                    <img src="<?= $producto['imagen_url']; ?>" alt="<?= $producto['nombre']; ?>" class="producto-imagen">
                    <h3><?= $producto['nombre']; ?></h3>
                    <p>Desde €<?= number_format($producto['precio_min'], 2); ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
<footer>
<?php
include 'footer.php';
?>
</footer>
</html>
