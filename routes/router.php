<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/session.php';

$router = new AltoRouter();

// Configurar la base del path si tu proyecto está en un subdirectorio
$router->setBasePath('/app');

// Definir rutas
$router->map('GET', '/empleados', function() {
    require __DIR__ . '/../modules/empleados/index.php';
});

// $router->map('GET', '/nombre-de-modulo/submodulo', function() {
//     require __DIR__ . '/../modules/nombre-de-modulo/submodulo.php'; // Ajusta la ruta según sea necesario
// });

$router->map('GET', '/auth/login', function() {
    require __DIR__ . '/../modules/auth/login.php';
});

$router->map('POST', '/auth/login', function() {
    // Aquí podrías incluir la lógica de procesamiento del login o redirigir a otro archivo que lo maneje
});

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
