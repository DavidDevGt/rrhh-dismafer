<?php
// Incluir lógica de manejo de sesiones
include_once 'session.php';

// Obtener la URL del request
$url = isset($_GET['url']) ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)) : [];

// Módulos accesibles sin autenticación
$modulosPublicos = ['auth', 'home'];

// Obtener el nombre del módulo desde la URL
$modulo = $url[0] ?? 'home'; // 'home' es la página de inicio por defecto

// Verificar si el usuario está intentando acceder a un módulo restringido
if (!in_array($modulo, $modulosPublicos) && !verificarSesion()) {
    header('Location: index.php?url=auth/login');
    exit;
}

// Ruta del archivo basada en la URL
if ($modulo == 'auth') {
    // Manejar autenticación (login/register)
    $submodulo = $url[1] ?? 'login'; // Por defecto a login
    $file_path = __DIR__ . "/../modules/auth/{$submodulo}.php";
} else {
    // Otros módulos
    $file_path = __DIR__ . "/../modules/{$modulo}/index.php";
}

// Verificar si el archivo existe
if (file_exists($file_path)) {
    require_once $file_path;
} else {
    // Página de error 404
    require_once __DIR__ . '/../includes/404.php';
}
