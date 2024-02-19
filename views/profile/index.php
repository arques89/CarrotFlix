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
                                            <form action="/procesaCSV" method="post" enctype="multipart/form-data">
                                                <label for="csvFile">Selecciona un archivo CSV:</label>
                                                <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
                                                <button type="submit" class="btn btn-primary mt-3">Cargar fichero CSV</button>
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
            </div>
        </div>
    </div>
</section>