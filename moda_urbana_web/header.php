<div class="header">
    <a href="index.php" class="enlace-inicio"><img class="logo_header" src="imagenes/logo.png" alt=""><h1>MODA URBANA</h1></a>
    <div>
        <nav class="navegacion">
            <details class="texto-nav" id="categorias">
                <summary>Categorías</summary>
                <ul>
                    <li><a class="texto-nav" href="categoria.php?categoria=Camisetas">Camisetas</a></li>
                    <li><a class="texto-nav" href="categoria.php?categoria=Sudaderas">Sudaderas</a></li>
                    <li><a class="texto-nav" href="categoria.php?categoria=Pantalones">Pantalones</a></li>
                    <li><a class="texto-nav" href="categoria.php?categoria=Calzado">Calzado</a></li>
                    <li><a class="texto-nav" href="categoria.php?categoria=Accesorios">Accesorios</a></li>
                </ul>
            </details>
            <ul>
            <?php if (isset($_SESSION['usuario'])): ?>
                    <li><a class="texto-nav" href="usuario.php">Mi cuenta</a></li>
                    <li><a class="texto-nav" href="logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a class="texto-nav" href="login.php">Iniciar sesión</a></li>
                <?php endif; ?>
                <li><a class="texto-nav" href="carrito.php"><i id="icono-carrito" class="fa-solid fa-cart-shopping"></i> Carrito  (<?= isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)</a></li>
                <li><a class="texto-nav" href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </div>

</div>
