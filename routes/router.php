<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/session.php';

$router = new AltoRouter();

// Configurar la base del path si tu proyecto está en un subdirectorio
$router->setBasePath('/rrhh-dismafer'); // Ajusta este path según tu estructura

// Definir rutas
$router->map('GET', '/', function() {
    require __DIR__ . '/../modules/home/index.php';
});

$router->map('GET', '/empleados', function() {
    require __DIR__ . '/../modules/empleados/index.php';
});

$router->map('GET', '/adelantos', function() {
    require __DIR__ . '/../modules/adelantos/index.php';
});

$router->map('GET', '/ausencias', function() {
    require __DIR__ . '/../modules/ausencias/index.php';
});

$router->map('GET', '/pagos', function() {
    require __DIR__ . '/../modules/pagos/index.php';
});

$router->map('GET', '/usuarios', function() {
    require __DIR__ . '/../modules/usuarios/index.php';
});

$router->map('GET', '/vacaciones', function() {
    require __DIR__ . '/../modules/vacaciones/index.php';
});

$router->map('GET', '/login', function() {
    require __DIR__ . '/../modules/auth/login.php';
});

$router->map('GET', '/register', function() {
    require __DIR__ . '/../modules/auth/register.php';
});

// $router->map('POST', '/auth/login', function() {
//     require __DIR__ . '/../modules/auth/backend/procesar_login.php';
// });

// Aquí puedes seguir agregando rutas según necesites

// Procesar la ruta solicitada
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // No se encontró la ruta
    header("HTTP/1.0 404 Not Found");
    require __DIR__ . '/../includes/404.php';
}
