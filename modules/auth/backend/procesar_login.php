<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../routes/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener usuario y contraseña del formulario
    $usuario = obtenerPost('usuario');
    $contraseña = obtenerPost('contraseña');

    // Verificar las credenciales del usuario
    $id_usuario = verificarUsuario($usuario, $contraseña);

    if ($id_usuario) {
        // Iniciar sesión y redirigir a la página de inicio
        iniciarSesion($id_usuario);
        header('Location: ../index.php');
        exit;
    } else {
        // Redirigir de nuevo al login con un mensaje de error
        header('Location: ../index.php?url=auth/login&error=1');
        exit;
    }
}

// Redirigir a login si no es una petición POST
header('Location: ../index.php?url=auth/login');
exit;
