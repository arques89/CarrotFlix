<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if (!isAuth()) { ?>
                <a href="/login" class="header__enlace">Iniciar sesión</a>
            <?php } ?>
            <?php if (!empty($_SESSION)) { ?>
                <form method="POST" action="/logout" class="dashboard__form">
                    <input type="submit" value="Cerrar Sesión" class="dashboard__submit--logout">
                </form>
            <?php } ?>
            <?php if (empty($_SESSION)) { ?>
                <a href="/register" class="header__enlace">Registro</a>
            <?php } ?>

        </nav>

        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">CarrotFlix</h1>
            </a>
        </div>
    </div>
</header>
<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">
                <?php if (isAuth()) { ?>
                    Bienvenido: <span><?php echo $_SESSION['name']; ?></span>
                <?php } ?>
            </h2>
        </a>

    </div>
</div>