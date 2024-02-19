<section>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body text-center">
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
                            <li class="list-group-item">
                                <form action="/procesaCSV" method="post" enctype="multipart/form-data">
                                    <label for="csvFile">Selecciona un archivo CSV:</label>
                                    <input type="file" name="csvFile" id="csvFile" accept=".csv" required>
                                    <button type="submit" class="btn btn-primary mt-5">Cargar fichero CSV</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>