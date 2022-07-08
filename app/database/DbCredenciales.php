<?php
require_once('../sunat/lib/phpdotenv/vendor/autoload.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('../../');
$dotenv->load();

define("HOSTNAME", $_ENV["HOSTNAME"]); // Nombre del host
define("PORT", $_ENV["PORT"]); // Puerto de servidor
define("DATABASE", $_ENV["DATABASE"]); // Nombre de la base de datos
define("USERNAME", $_ENV["USERNAME"]); // Nombre del usuario
define("PASSWORD", $_ENV["PASSWORD"]); // Nombre de la constraseña