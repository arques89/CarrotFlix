<header class="header">
<nav class="navbar navbar fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">CarrotFlix</a>

      <?php if (!empty($_SESSION)) { ?>
      <?php if (isAuth()) { ?>  
        <a id="browse" class="navbar-brand" href="/browse">Browse</a>
      <?php } ?>
      <?php } ?>

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
      <span class="navbar-toggler-icon">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ec5353" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M4 6l16 0" />
        <path d="M4 12l16 0" />
        <path d="M4 18l16 0" />
      </svg>

      </span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
           
          
          <?php if (empty($_SESSION)) { ?>
              <?php if (!isAuth()) { ?>
                Bienvenido
                <?php } ?>
                <?php } ?>
                <?php if (!empty($_SESSION)) { ?>
                  <?php if (isAuth()) { ?>
                    Bienvenido <?php echo $_SESSION['name'] . ' ' . $_SESSION['surname'] ?>
                    <?php } ?>
                <?php } ?>
          
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">

            <?php if (empty($_SESSION)) { ?>
              <?php if (!isAuth()) { ?>
                <a href="/register" class="header__enlace">Register</a>
                <?php } ?>
            <?php } ?>
            
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#">
            <?php if (!isAuth()) { ?>
                <a href="/login" class="header__enlace">Login</a>
            <?php } ?>
            <?php if (!empty($_SESSION)) { ?>
                <form method="POST" action="/logout" class="dashboard__form">
                    <input type="submit" value="Cerrar Sesión" class="dashboard__submit--logout">
                </form>
                <?php } ?>
            </a>
          </li>

        </ul>

      </div>
    </div>
  </div>
</nav>













    
















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
                <a href="/register" class="header__enlace">Register</a>
            <?php } ?>

        </nav>

    </div>
</header>
<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">
                <?php if (isAuth()) { ?>
                    Bienvenido: <span><?php echo $_SESSION['name'];?></span> 
                    Rol: <span><?php echo isAdmin() ? "Admin" : "User"; ?></span>  
                <?php } ?>
            </h2>
        </a>

    </div>
</div>