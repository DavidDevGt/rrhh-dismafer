<?php
require_once __DIR__ . '/../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $usuario = obtenerPost('usuario');
    $contraseña = obtenerPost('contraseña');
    $confirmar_contraseña = obtenerPost('confirmar_contraseña');

    // Verificar que las contraseñas coincidan
    // if ($contraseña !== $confirmar_contraseña) {
    //     header('Location: /rrhh-dismafer/register?error=contraseñas_no_coinciden');
    //     exit;
    // }

    // Encriptar la contraseña
    $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);

    // Preparar y ejecutar la consulta para insertar el usuario
    $query = "INSERT INTO usuarios_sistema (nombre_usuario, contraseña_hash, activo) VALUES ('" . dbEscape($usuario) . "', '" . dbEscape($contraseña_hash) . "', 1)";
    $resultado = dbQuery($query);

    if ($resultado) {
        // Redirigir a la página de login con un mensaje de éxito
        header('Location: /rrhh-dismafer/login?registro_exitoso=1');
        exit;
    } else {
        // En caso de error, redirigir al formulario de registro con un mensaje de error
        header('Location: /rrhh-dismafer/register?error=error_en_registro');
        exit;
    }
}

// Si no es una petición POST, redirigir al formulario de registro
header('Location: /rrhh-dismafer/register');
exit;
