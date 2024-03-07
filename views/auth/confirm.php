<?php
header('Refresh: 5; url=./login');

// Tu código HTML actual
?>
<main class="auth">
    <div class="message">
        <h2 class="auth__heading"><?php echo $title; ?></h2>
        <div>
            <p class="auth__texto">
                <h4>Usuario Confirmado.</h4> 
            </p>
            <img src="../assets/img/logo-check.avif" alt="">
            <h3>Serás redirigido a la página de Login. Gracias por verificar tu usuario.</h3>
        </div>
    </div>
</main>

