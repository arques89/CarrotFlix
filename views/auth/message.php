<?php
header('Refresh: 5; url=./login');

// Tu código HTML actual
?>
<main class="auth">
    <div class="message">
        <h2 class="auth__heading"><?php echo $title; ?></h2>
        <div>
            <p class="auth__texto">
                Usuario registrado. Para confirmar tu cuenta por favor revisa tu bandeja de entrada. 
            </p>
            <img src="../assets/img/logo-check.avif" alt="">
            <h3>Serás redirigido a la página de Login. Gracias por registrarte.</h3>
        </div>
    </div>
</main>