
# Laravel+Vue Crud Starter


[![Build Status](https://dev.azure.com/anowarhossain/laravel-vue-crud-starter/_apis/build/status/AnowarCST.laravel-vue-crud-starter?branchName=master)](https://dev.azure.com/anowarhossain/laravel-vue-crud-starter/_build/latest?definitionId=6&branchName=master)


## About Repository

A very simple Laravel 8 + Vue 2 + AdminLTE 3 based Curd Starter template for SPA Application.
<p align="center">
<img src="https://i.imgur.com/mZAHbUL.png">
<img src="https://i.imgur.com/3hhoQnq.png">
<img src="https://i.imgur.com/aHtQkYl.png">
<img src="https://i.imgur.com/V7OuwLn.png">
</p>

## Tech Specification

- Laravel 8
- Vue 2 + VueRouter + vue-progressbar + sweetalert2 + laravel-vue-pagination
- Laravel Passport
- Admin LTE 3 + Bootstrap 4 + Font Awesome 5
- PHPUnit Test Case/Test Coverage

## Features

- Modal based Create+Edit, List with Pagination, Delete with Sweetalert
- Login, Register, Forget+Reset Password as default auth
- Profile, Update Profile, Change Password, Avatar
- Product Management 
- User Management
- Settings: Categories, Tags
- Frontend and Backend User ACL with Gate Policy (type: admin/user)
- Simple Static Dashboard
- Developer Options for OAuth Clients and Personal Access Token
- Build with Docker

## Installation

- `git clone https://github.com/AnowarCST/laravel-vue-crud-starter.git`
- `cd laravel-vue-crud-starter/`
- `composer install`
- `composer install --ignore-platform-reqs`
- `copy .env.example .env`
- Update `.env` and set your database credentials
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan passport:install`
- `npm install`
- `npm run dev`
- `php artisan serve`

## Install with Docker

- `docker-compose up -d`
- `docker exec -it vue-starter /bin/bash`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan passport:install`
- Application http://localhost:8008/
- Adminer for Database http://localhost:8080/
- DBhost: yourIP:3307, user: root, Password: 123456


## Unit Test

#### run PHPUnit

```bash
# run PHPUnit all test cases
vendor/bin/phpunit
# or Feature test only
vendor/bin/phpunit --testsuite Feature
```

#### Code Coverage Report

```bash
# reports is a directory name
vendor/bin/phpunit --coverage-html reports/
```
A `reports` directory has been created for code coverage report. Open the dashboard.html.


## Credit
This repository is motivated by [Hujjat/laravStart](https://github.com/Hujjat/laravStart) and his awesome video tutorial in [Youtube](https://www.youtube.com/playlist?list=PLB4AdipoHpxaHDLIaMdtro1eXnQtl_UvE).

## License

[MIT license](https://opensource.org/licenses/MIT).

# Prototipo de Proyecto Laravel 8 + Vue Crud Starter #
https://github.com/AnowarCST/laravel-vue-crud-starter 

Un simple template de Laravel 8 + Vue 2 + AdminLTE 3 basado en el template de Curd Starter para Aplicaciones SPA.
<p align="center">
<img src="https://i.imgur.com/mZAHbUL.png">
<img src="https://i.imgur.com/3hhoQnq.png">
<img src="https://i.imgur.com/aHtQkYl.png">
<img src="https://i.imgur.com/V7OuwLn.png">
</p>

# Iniciar proyecto #
- git clone https://github.com/AnowarCST/laravel-vue-crud-starter.git

- cd laravel-vue-crud-starter/

## Instalar Composer ##
- composer install
- o 
- composer install --ignore-platform-reqs 

(De esta manera se ignora la version del modulo y se toma la vigente en el servidor)

# Configurar .gitignore #

        #/node_modules (Se habilita por no poder bajar librerias desde el servidor)
        /node_modules/.cache/
        /public/hot
        /public/storage
        /storage/*.key
        #/vendor (Se habilita por no poder bajar librerias desde el servidor)
        .env
        .env.backup
        .phpunit.result.cache
        Homestead.json
        Homestead.yaml
        npm-debug.log
        yarn-error.log
        reports/
        .idea
        .vscode

# Agregando configuraci??n en el caso de usar Mysql o MariaDb #

En el archivo app/Providers/AppServiceProvider.php

        <?php

        namespace App\Providers;

        use Illuminate\Support\Facades\Schema; //importar Schema
        use Illuminate\Support\ServiceProvider;

        class AppServiceProvider extends ServiceProvider
        {
            /**
            * Register any application services.
            *
            * @return void
            */
            public function register()
            {
                //
            }

            /**
            * Bootstrap any application services.
            *
            * @return void
            */
            public function boot()
            {
                //Linea agregada para Mysql y/o MariaDb antes de cualquier migrate
                Schema::defaultStringLength(191); 
            }
        }


# Creando .env e iniciando la app #

    > copy .env.example .env
    > Update .env and set your database credentials
    > php artisan key:generate
    > php artisan migrate
    > php artisan db:seed
    > php artisan passport:install
    > npm install
    > npm run dev
    > php artisan serve
# Configurar Oracle #
Referencia (https://www.jc-mouse.net/laravel/conexion-a-base-de-datos-oracle-con-laravel)

> ## Paso 1. Biblioteca Instant-Client ##

        La biblioteca de Oracle Instant Client nos permite que las aplicaciones se conecten a una base de datos Oracle ya sea local o remota. Para descargar la biblioteca ingresa Oracle Instant Client y luego a la secci??n de descargas donde se debe seleccionar el sistema operativo, para nuestro ejemplo Windows. Un detalle importante, aun si tu SO es de 64 bits, descarga la biblioteca para 32 bits.

        La ??ltima versi??n de la biblioteca es la 19.8, para el ejemplo de este tutorial utilizaremos Basic Package instantclient-basic-nt-12.2.0.1.0.zip  (requiere registro), la raz??n es que tengo instalado Microsoft Visual Studio 2013 y me dio pereza actualizar a 2017. Continuemos

        Una vez descargado la librer??a, descomprime en alg??n lugar de tu computadora, yo lo hice en ??D:\Oracle\instantclient_12_2??, anota esa ruta ya que luego debes agregar la misma en el PATH del sistema y reiniciar el equipo.

> ## Paso 2. Habilitar Instant-Client en el servidor ##

        Ahora debemos habilitar la biblioteca en XAMPP.
        Abre el archivo php.ini ubicado en xampp/php/ y busca la l??nea ??;extension=oci8_12c??, borra el punto y coma ??;?? y guarda los cambios.
        Reinicia el servidor y abre phpinfo.php, busca OCI8 para comprobar que la extensi??n esta habilitada.
        oci8 apache xampp
        Hasta aqu??, la conexi??n a Oracle deber??a funcionar correctamente, pero y si no entonces debemos realizar lo siguiente:

        EXTRA: Abre la carpeta de instantclient_12_2/ y copia todas as *.dll que encuentres, ve a xampp/php/ y pega las librer??as, haz lo mismo con /xampp/php/ext/, es decir, pega tambi??n ah?? las librer??as de instantclient_12_2/. Realiza esta acci??n solo si m??s adelante tienes problemas al conectar con Oracle.

> ## Paso 3. laravel-oci8 ##

        Laravel-OCI8 es un paquete que te permite comunicar Laravel con Oracle, el proyecto se encuentra bajo la licencia del The MIT License (MIT).
        Abre tu proyecto Laravel con VSC y luego una nueva terminal. Escribe el siguiente comando para instalar laravel-oci8:

            > composer require yajra/laravel-oci8:^X

        donde en X, se debe indica la versi??n del proyecto Laravel.

        Una vez terminada la instalaci??n, se debe registrar laravel-oci8, para ello abrir el archivo app.php de la carpeta config/ y agregar en provider:

            > Yajra\Oci8\Oci8ServiceProvider::class,

> ## Paso 4. Configuraci??n de la conexi??n a Oracle ##

        Abre el archivo .env e introduce tu configuraci??n para Oracle:

            DB_CONNECTION=oracle
            DB_HOST=db
            DB_PORT=1521
            DB_DATABASE=laravel
            DB_USERNAME=root
            DB_PASSWORD=123456

        En una terminal escribe:

            > php artisan vendor:publish ???tag=oracle

        Lo que hace este comando es crear un archivo oracle.php en la carpeta config/, el contenido es el siguiente:

            <?php

            return [
                'oracle' => [
                    'driver' => 'oracle',
                    'tns' => env('DB_TNS', ''),
                    'host' => env('DB_HOST', ''),
                    'port' => env('DB_PORT', '1521'),
                    'database' => env('DB_DATABASE', ''),
                    'service_name' => env('DB_DATABASE', ''),
                    'username' => env('DB_USERNAME', ''),
                    'password' => env('DB_PASSWORD', ''),
                    'charset' => env('DB_CHARSET', 'AL32UTF8'),
                    'prefix' => env('DB_PREFIX', ''),
                    'prefix_schema' => env('DB_SCHEMA_PREFIX', ''),
                    'edition' => env('DB_EDITION', 'ora$base'),
                    'server_version' => env('DB_SERVER_VERSION', '11g'),
                ],
            ];

        Finalmente copie el contenido de oracle.php en en el archivo database.php  y guarde los cambios.

# Generador de modelos elocuents #
https://github.com/krlove/eloquent-model-generator

Eloquent Model Generator es una herramienta basada en [Code Generator](https://github.com/krlove/code-generator) para generar modelos Eloquent.

## Instalaci??n
Paso 1. Agregue Eloquent Model Generator a su proyecto:
```
composer require krlove/eloquent-model-generator --dev
```
Paso 2. Registrar `GeneratorServiceProvider`:
```php
'providers' => [
    // ...
    Krlove\EloquentModelGenerator\Provider\GeneratorServiceProvider::class,
];
```
Si est?? utilizando Laravel versi??n 5.5 o superior, este paso se puede omitir ya que este proyecto admite [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery) feature.

Paso 3. Configure su conexion a la base de datos.

## Uso
Use
```
php artisan krlove:generate:model User
```
para generar una clase modelo. El generador buscar?? una tabla con el nombre `users` y generar?? un modelo para ella.

### table-name
Use `table-name` opci??n para especificar otro nombre de tabla:
```
php artisan krlove:generate:model User --table-name=userrol
```
En este caso, el modelo generado contendr?? `protected $table = 'userrol'` propiedad.

### output-path
El archivo generado se guardar?? en el directorio `app` de su aplicaci??n y tendr?? el espacio de nombres` App` por defecto. Si desea cambiar el destino y el espacio de nombres, proporcione las opciones `output-path` y` namespace` respectivamente:
```
php artisan krlove:generate:model User --output-path=/full/path/to/output/directory --namespace=Some\\Other\\NSpace
```
`output-path` puede ser una ruta absoluta o relativa al directorio `app` del proyecto. El camino absoluto debe comenzar con `/`:
- `/var/www/html/app/Models` - absolute path
- `Models` - ruta relativa, se transformar?? en `/var/www/html/app/Models` (asumiendo que el directorio de la aplicaci??n de tu proyecto es `/var/www/html/app`)


### base-class-name
Por defecto, la clase generada se extender?? desde `Illuminate\Database\Eloquent\Model`. Para cambiar la clase base, especifique la opci??n `base-class-name`:
```
php artisan krlove:generate:model User --base-class-name=Some\\Other\\Base\\Model
```

### Backup
Guarde el modelo existente antes de generar uno nuevo
```
php artisan krlove:generate:model User --backup
```

Si el archivo `User.php` ya existe, primero se le cambiar?? el nombre a` User.php ~ `y se guardar?? en el mismo directorio. Despu??s de eso, se generar?? un nuevo `User.php`.

### Otras opciones
Hay varias opciones ??tiles para definir las propiedades de varios modelos:
- `no-timestamps` - agrega la propiedad` public $ timestamps = false; `al modelo
- `date-format` - especifica la propiedad` dateFormat` del modelo
- `connection` - especifica la propiedad del nombre de la conexi??n del modelo

# Configurar Laravel auditing #

    > composer require owen-it/laravel-auditing

    Edite el archivo y agregue la siguiente l??nea para registrar el proveedor de servicios:
* ### config/app.php ###

        'providers' => [
            // ...

            OwenIt\Auditing\AuditingServiceProvider::class,

            // ...
        ],

## Publicaci??n ##

Despu??s de configurar el marco de su elecci??n, use el siguiente comando para publicar los ajustes de configuraci??n:

        > php artisan vendor:publish --provider "OwenIt\Auditing\AuditingServiceProvider" --tag="config"

Esto crear?? el archivo de configuraci??n.
### config/audit.php ###

Puede leer m??s sobre las opciones de configuraci??n en la secci??n Configuraci??n general .
Lumen por defecto no lee desde la **config** ubicaci??n. Aseg??rese de cargar la configuraci??n en el arranque. Edite el :
* ### bootstrap/app.php ###

        // ...

        $app->configure('audit');

        return $app;

        // ...

## Base de datos ##
Publique la auditsmigraci??n de la tabla en el directorio con el siguiente comando:database/

        > php artisan vendor:publish --provider "OwenIt\Auditing\AuditingServiceProvider" --tag="migrations"

### Personalizaci??n ###
Si es necesario, el archivo de migraci??n se puede personalizar. Eche un vistazo a la secci??n Migraci??n de auditor??a para ver algunos de los cambios que se pueden realizar.

Una vez hecho esto, ejecute el artisancomando para migrar, creando la auditstabla en su base de datos:

        > php artisan migrate

Aqu?? es donde Audit se almacenar??n los registros, de forma predeterminada.

## Configuraci??n Auditable ##
http://www.laravel-auditing.com/docs/9.0
### Incluir atributos ### 
La **$auditInclude** propiedad act??a como una lista blanca de atributos , lo que significa que solo se auditar??n los nombres de propiedad que arrayfiguran en ella.

        <?php
        namespace App;

        use Illuminate\Database\Eloquent\Model;
        use OwenIt\Auditing\Contracts\Auditable;

        class Article extends Model implements Auditable
        {
            use \OwenIt\Auditing\Auditable;

            /**
            * Attributes to include in the Audit.
            *
            * @var array
            */
            protected $auditInclude = [
                'title',
                'content',
            ];

            // ...
        }

### Excluir atributos ###
Por otro lado, **$auditExclude** act??a como una lista negra , excluyendo todas las propiedades en el arrayde ser auditadas.

        <?php
        namespace App;

        use Illuminate\Database\Eloquent\Model;
        use OwenIt\Auditing\Contracts\Auditable;

        class Article extends Model implements Auditable
        {
            use \OwenIt\Auditing\Auditable;

            /**
            * Attributes to exclude from the Audit.
            *
            * @var array
            */
            protected $auditExclude = [
                'published',
            ];

            // ...
        }
# Instalando Chart js

    > npm install vue-chartjs chart.js@2.9.4 --save
