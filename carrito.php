<?php
session_start();
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<header>
<?php
include 'header.php';
?>
</header>

<body>
    <div class="fondo-carrito">
    <h1>Carrito de Compras</h1>
    <?php if (!empty($carrito)): ?>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Talla</th>
                    <th>Color</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($carrito as $index => $item):
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= $item['producto_id']; ?></td>
                        <td><?= $item['talla']; ?></td>
                        <td><?= $item['color']; ?></td>
                        <td>$<?= number_format($item['precio'], 2); ?></td>
                        <td>
                            <form action="server_modificar_carrito.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="index" value="<?= $index; ?>">
                                <button type="submit" name="accion" value="restar">-</button>
                                <?= $item['cantidad']; ?>
                                <button type="submit" name="accion" value="sumar">+</button>
                            </form>
                        </td>
                        <td>$<?= number_format($subtotal, 2); ?></td>
                        <td>
                            <form action="server_modificar_carrito.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="index" value="<?= $index; ?>">
                                <button type="submit" name="accion" value="eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total: $<?= number_format($total, 2); ?></h3>
        <button class="boton-pago">Proceder al pago</button>
    <?php else: ?>
        <p>El carrito está vacío.</p>
    <?php endif; ?>

    </div>

</body>
<footer>
<?php
include 'footer.php';
?>
</footer>
</html>


