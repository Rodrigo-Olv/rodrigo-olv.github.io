<?php
include 'db.php'; // Conexión a la base de datos
require_once 'filtros.php'; // Asegúrate de que este archivo esté correctamente configurado para manejar filtros
session_start();
// Variables para almacenar los filtros y parámetros
$condiciones = [];
$parametros = [];

// Verificar si hay filtros aplicados
if (!empty($_GET['categoria'])) {
    $condiciones[] = "categorias.nombre = :categoria";
    $parametros['categoria'] = $_GET['categoria'];
}

if (!empty($_GET['precio_min'])) {
    $condiciones[] = "variantes_productos.precio >= :precio_min";
    $parametros['precio_min'] = $_GET['precio_min'];
}

if (!empty($_GET['precio_max'])) {
    $condiciones[] = "variantes_productos.precio <= :precio_max";
    $parametros['precio_max'] = $_GET['precio_max'];
}

if (!empty($_GET['genero'])) {
    $condiciones[] = "variantes_productos.genero = :genero";
    $parametros['genero'] = $_GET['genero'];
}

// ** NUEVO: Agregar la búsqueda manual **
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
if (!empty($busqueda)) {
    $condiciones[] = "productos.nombre LIKE :busqueda"; // Usamos LIKE para permitir búsqueda parcial
    $parametros['busqueda'] = '%' . $busqueda . '%'; // Preparamos el parámetro con comodines
}

// Construir la consulta SQL, uniendo las tablas necesarias
$sql = "SELECT productos.id, productos.nombre, productos.imagen_url, MIN(variantes_productos.precio) AS precio_min
        FROM productos
        JOIN variantes_productos ON productos.id = variantes_productos.producto_id
        JOIN categorias ON productos.categoria_id = categorias.id";

// Si hay filtros, añadir cláusulas WHERE
if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}

// Agrupar por producto para obtener el precio mínimo
$sql .= " GROUP BY productos.id";

// Preparar y ejecutar la consulta
$stmt = $pdo->prepare($sql);
$stmt->execute($parametros);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=PT+Sans:wght@400;700&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<header>
<?php
include 'header.php';
?>
</header>

<body>
    <div class="slider">
    <div class="slides">
        <img src="imagenes/slide1.png" alt="Imagen 1">
        <img src="imagenes/slide2.png" alt="Imagen 2">
        <img src="imagenes/slide3.png" alt="Imagen 3">
        <img src="imagenes/slide4.png" alt="Imagen 4">
    </div>
    </div>
    
    <form method="GET" action="index.php" class="form">
        <input type="text" name="busqueda" placeholder="Buscar producto" value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
        <label for="genero">Género:</label>
        <select name="genero" id="genero">
            <option value="">Todos</option>
            <option value="hombre" <?= isset($_GET['genero']) && $_GET['genero'] === 'hombre' ? 'selected' : ''; ?>>Hombre</option>
            <option value="mujer" <?= isset($_GET['genero']) && $_GET['genero'] === 'mujer' ? 'selected' : ''; ?>>Mujer</option>
            <option value="unisex" <?= isset($_GET['genero']) && $_GET['genero'] === 'unisex' ? 'selected' : ''; ?>>Unisex</option>
        </select>

        <label for="categoria">Categoría:</label>
        <select name="categoria" id="categoria">
            <option value="">Todas</option>
            <option value="Camisetas" <?= isset($_GET['categoria']) && $_GET['categoria'] === 'Camisetas' ? 'selected' : ''; ?>>Camisetas</option>
            <option value="Sudaderas" <?= isset($_GET['categoria']) && $_GET['categoria'] === 'Sudaderas' ? 'selected' : ''; ?>>Sudaderas</option>
            <option value="Pantalones" <?= isset($_GET['categoria']) && $_GET['categoria'] === 'Pantalones' ? 'selected' : ''; ?>>Pantalones</option>
            <option value="Calzado" <?= isset($_GET['categoria']) && $_GET['categoria'] === 'Calzado' ? 'selected' : ''; ?>>Calzado</option>
            <option value="Accesorios" <?= isset($_GET['categoria']) && $_GET['categoria'] === 'Accesorios' ? 'selected' : ''; ?>>Accesorios</option>
        </select>

        <label for="precio_min">Precio Mínimo:</label>
        <input type="number" name="precio_min" id="precio_min" placeholder="0" min="0" value="<?= isset($_GET['precio_min']) ? $_GET['precio_min'] : ''; ?>">

        <label for="precio_max">Precio Máximo:</label>
        <input type="number" name="precio_max" id="precio_max" placeholder="1000" min="0" value="<?= isset($_GET['precio_max']) ? $_GET['precio_max'] : ''; ?>">

        <button type="submit" value="Buscar">Buscar</button>
    </form>
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
    <script>
        let index = 0; // Índice de la imagen actual
        const slides = document.querySelector('.slides');
        const images = document.querySelectorAll('.slides img');
        const totalImages = images.length;

        function nextSlide() {
        index = (index + 1) % totalImages; // Incrementa el índice y reinicia al llegar a la última imagen
        const offset = -index * 100; // Calcula el desplazamiento
        slides.style.transform = `translateX(${offset}vw)`; // Aplica el desplazamiento
        }

        // Cambio de imagen cada 5 segundos
        setInterval(nextSlide, 5000);
    </script>
</body>
<footer>
<?php
include 'footer.php';
?>
</footer>

</html>
