<?php
require_once __DIR__ . '/../../../config/database.php';

header('Content-Type: application/json');

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
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al registrar usuario']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
exit;