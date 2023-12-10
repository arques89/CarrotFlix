# CarrotFlix

### Getting Started 🌟
1. `Clonar repositorio` 
  > git clone https://github.com/arques89/CarrotFlix.git

2. `Descarga dependencias`
  - Desde la raiz del proyecto ejecutar.
    > composer install

3. `Configuración de DB`
  - En la carpeta /includes crear el fichero `.env` y añadir conexión con la base de datos en local.

  > DB_HOST=your server
  > DB_USER=db user
  > DB_PASS=db password
  > DB_NAME=db name

4. `Cargando tablas en DB`
  - Cargar el script `/sql/creates.sql` en la db para crear las tablas necesarias.

`Levantando el servidor de desarrollo`
    - Desde la carpeta /public ejecutar.
      > php -S localhost:3000


### Estructura app

INICIO          LOGIN ----------->
  |               |               |
  |               |               |
  |               |               |
  ----------> REGISTER            |
                                  |
   ---->404 NOT FOUND             |
                                  |
                                  |
                                  |
                                  |
      ----- CATALOGO <----- RECOMENDACIONES
      |
      |
      |
      | PANTALLA / PLAYER
