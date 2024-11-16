<?php
// Conexión a la base de datos
require_once 'db.php';

// Variables para los filtros
$genero = isset($_GET['genero']) ? $_GET['genero'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$precio_min = isset($_GET['precio_min']) ? (int)$_GET['precio_min'] : 0;
$precio_max = isset($_GET['precio_max']) ? (int)$_GET['precio_max'] : 10000; // Precio máximo arbitrario si no se especifica
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : ''; // Trim para evitar espacios

// Consulta base
$query = "SELECT productos.id, productos.nombre, productos.imagen_url, variantes_productos.precio 
          FROM productos 
          JOIN variantes_productos ON productos.id = variantes_productos.producto_id 
          WHERE 1=1";

// Filtrar por búsqueda
if ($busqueda !== '') {
    $query .= " AND productos.nombre LIKE :busqueda"; // Usamos LIKE para búsqueda parcial
}

// Filtrar por género
if ($genero !== '') {
    $query .= " AND variantes_productos.genero = :genero";
}

// Filtrar por categoría
if ($categoria !== '') {
    $query .= " AND productos.categoria_id = (SELECT id FROM categorias WHERE nombre = :categoria)";
}

// Filtrar por precio
$query .= " AND variantes_productos.precio BETWEEN :precio_min AND :precio_max";

// Preparar y ejecutar la consulta
$stmt = $pdo->prepare($query);

// Asociar los parámetros
if ($busqueda !== '') {
    $busqueda_param = "%$busqueda%"; // Búsqueda parcial
    $stmt->bindParam(':busqueda', $busqueda_param);
}
if ($genero !== '') {
    $stmt->bindParam(':genero', $genero);
}
if ($categoria !== '') {
    $stmt->bindParam(':categoria', $categoria);
}
$stmt->bindParam(':precio_min', $precio_min, PDO::PARAM_INT);
$stmt->bindParam(':precio_max', $precio_max, PDO::PARAM_INT);

$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
