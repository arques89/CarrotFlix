<section>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mt-5 offset-md-3">
                <div class="card">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card-body p-4 text-left">
                                <?php
                                if ($user->getIsAdmin()) {
                                    echo '<h4 class="card-title text-success">Rol: Administrador</h4>';
                                } else {
                                    echo '<h4 class="card-title text-warning">Rol: Usuario</h4>';
                                }
                                ?>
                                <h4 class="card-title">Usuario: <?php echo $user->getName() . " " . $user->getSurname() ?></h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item text-secondary">Correo Electrónico: <?php echo $user->getEmail() ?></li>
                                    <?php if ($user->getIsAdmin()) { ?>
                                        <li class="list-group-item">
                                            <form action="/procesaCSV" method="post" enctype="multipart/form-data" id="csvForm">
                                                <label for="csvFile">Selecciona un archivo CSV:</label>
                                                <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
                                                <button type="button" class="btn btn-primary mt-3" id="submitBtn">Cargar fichero CSV</button>
                                            </form>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 p-5">
                            <img src="/assets/img/avatar.jpg" alt="Avatar" class="img-fluid rounded-circle">
                        </div>
                    </div>
                </div>
                <div class="text-success text-center bold"><?php echo ($alerts ? $alerts : ''); ?></div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('csvForm');
        const submitBtn = document.getElementById('submitBtn');

        submitBtn.addEventListener('click', async function() {
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                });

                if (response.ok) {
                    const result = await response.json(); // Suponiendo que el backend devuelve un JSON

                    if (result.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Registros insertados correctamente.',
                            icon: 'success',
                        }).then(() => {
                            window.location.href = "/profile";
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al insertar la película. Datos no válidos.',
                            icon: 'error',
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al cargar el archivo CSV.',
                        icon: 'error',
                    });
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
</script>