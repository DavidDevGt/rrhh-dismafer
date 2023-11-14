<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../routes/session.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = obtenerPost('usuario');
    $contraseña = obtenerPost('contraseña');

    $id_usuario = verificarUsuario($usuario, $contraseña);

    if ($id_usuario) {
        iniciarSesion($id_usuario);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
exit;
