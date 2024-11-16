<?php
include 'db.php'; // Conexión a la base de datos
session_start();

// Obtener el producto por ID
$id = $_GET['id'];
$sql_producto = "SELECT * FROM productos WHERE id = ?";
$stmt_producto = $pdo->prepare($sql_producto);
$stmt_producto->execute([$id]);
$producto = $stmt_producto->fetch(PDO::FETCH_ASSOC);

// Obtener variantes del producto (talla, color, precio)
$sql_variantes = "SELECT * FROM variantes_productos WHERE producto_id = ?";
$stmt_variantes = $pdo->prepare($sql_variantes);
$stmt_variantes->execute([$id]);
$variantes = $stmt_variantes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $producto['nombre']; ?></title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<script>
    function comprobarSesionYAñadirAlCarrito(productoId) {
        const talla = document.querySelector('select[name="talla"]').value;
        const color = document.querySelector('select[name="color"]').value;
        const precio = document.getElementById('precio').textContent;

        // Comprobar la sesión del usuario
        const xhrSesion = new XMLHttpRequest();
        xhrSesion.open('GET', 'server_sesiones.php', true);
        xhrSesion.onload = function() {
            const response = JSON.parse(xhrSesion.responseText);
            if (response.success) {
                // Si la sesión está activa, añadimos el producto al carrito
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'server_carrito.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert('Producto añadido al carrito');
                    } else {
                        alert('Error al añadir al carrito');
                    }
                };

                const params = `producto_id=${productoId}&talla=${talla}&color=${color}&precio=${precio}`;
                xhr.send(params);
            } else {
                alert(response.message); // Mostrar mensaje de error si no hay sesión activa
            }
        };
        xhrSesion.send();
    }
</script>
<header>
<?php
include 'header.php';
?>
</header>

<body>
    <div class="producto-detalle">
        <div >
            <img class="producto-imagen-detalle" src="<?= $producto['imagen_url']; ?>" alt="<?= $producto['nombre']; ?>">
        </div>
        <div class="producto-info">
            <h2 id="nombre-producto"><?= $producto['nombre']; ?></h2>
            <p><?= $producto['descripcion']; ?></p>

            <h3 id="opciones-talla">Opciones de Talla</h3>
            <select id="select-talla" name="talla">
                <?php
                $tallas = [];
                foreach ($variantes as $variante) {
                    if (!in_array($variante['talla'], $tallas)) {
                        $tallas[] = $variante['talla'];
                        echo "<option value='{$variante['talla']}'>{$variante['talla']}</option>";
                    }
                }
                ?>
            </select>

            <h3 id="opciones-color">Opciones de Color</h3>
            <select id="select-color" name="color">
                <?php
                $colores = [];
                foreach ($variantes as $variante) {
                    if (!in_array($variante['color'], $colores)) {
                        $colores[] = $variante['color'];
                        echo "<option value='{$variante['color']}'>{$variante['color']}</option>";
                    }
                }
                ?>
            </select>

            <h3 id="encabezado-precio">Precio: $<span id="precio"></span></h3>
            
            <button id="btnAñadirCarrito" onclick="comprobarSesionYAñadirAlCarrito(<?= $producto['id']; ?>)"><i id="icono-carrito" class="fa-solid fa-cart-shopping"></i> Añadir al Carrito</button>


        </div>
    </div>

    <script>
        // Actualizar el precio cuando se seleccione una talla y color
        const variantes = <?= json_encode($variantes); ?>;
        const selectTalla = document.querySelector('select[name="talla"]');
        const selectColor = document.querySelector('select[name="color"]');
        const precioElement = document.getElementById('precio');

        function actualizarPrecio() {
            const talla = selectTalla.value;
            const color = selectColor.value;
            const variante = variantes.find(v => v.talla === talla && v.color === color);
            if (variante) {
                precioElement.textContent = parseFloat(variante.precio).toFixed(2);
            }
        }

        selectTalla.addEventListener('change', actualizarPrecio);
        selectColor.addEventListener('change', actualizarPrecio);

        // Inicializar el precio
        actualizarPrecio();
    </script>
</body>
<footer>
<?php
include 'footer.php';
?>
</footer>
</html>
