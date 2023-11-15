<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/session.php';

$router = new AltoRouter();

// Configurar la base del path
$router->setBasePath('/rrhh-dismafer');

// Rutas públicas (no requieren autenticación)
$router->map('GET', '/', function() {
    require __DIR__ . '/../modules/home/index.php';
});
$router->map('GET', '/login', function() {
    require __DIR__ . '/../modules/auth/login.php';
});
$router->map('GET', '/register', function() {
    require __DIR__ . '/../modules/auth/register.php';
});
$router->map('POST', '/login/process', function() {
    require __DIR__ . '/../modules/auth/backend/procesar_login.php';
});
$router->map('POST', '/register/process', function() {
    require __DIR__ . '/../modules/auth/backend/procesar_registro.php';
});

// Rutas de vistas privadas (requieren autenticación)
$rutasPrivadas = [
    ['/empleados', '/../modules/empleados/index.php'],
    ['/adelantos', '/../modules/adelantos/index.php'],
    ['/ausencias', '/../modules/ausencias/index.php'],
    ['/pagos', '/../modules/pagos/index.php'],
    ['/vacaciones', '/../modules/vacaciones/index.php'],
    ['/usuarios', '/../modules/usuarios/index.php'],
    ['/postulaciones', '/../modules/postulaciones/index.php'],
    ['/vacantes', '/../modules/vacantes/index.php'],
    ['/candidatos', '/../modules/candidatos/index.php'],
    ['/dashboard', '/../modules/dashboard/index.php']
];

foreach ($rutasPrivadas as $ruta) {
    $router->map('GET', $ruta[0], function() use ($ruta) {
        if (verificarSesion()) {
            require __DIR__ . $ruta[1];
        } else {
            header('Location: /rrhh-dismafer/login');
            exit;
        }
    });
}

// Rutas AJAX
$rutasAjax = [
    ['/empleados/ajax', '/../modules/empleados/ajax.php'],
    ['/adelantos/ajax', '/../modules/adelantos/ajax.php'],
    // ... [Agrega todas las rutas AJAX necesarias aquí]
];

foreach ($rutasAjax as $rutaAjax) {
    $router->map('POST', $rutaAjax[0], function() use ($rutaAjax) {
        if (verificarSesion()) {
            require __DIR__ . $rutaAjax[1];
        } else {
            // Manejar no autenticado o responder con un error
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }
    });
}

// Procesar la ruta solicitada
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // No se encontró la ruta
    header("HTTP/1.0 404 Not Found");
    require __DIR__ . '/../includes/404.php';
}
