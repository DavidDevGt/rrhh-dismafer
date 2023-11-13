<?php
// Incluye la configuración de la base de datos
require_once __DIR__ . '/../config/database.php';

session_start();

function verificarUsuario($nombre_usuario, $contraseña)
{
    // Verificar el usuario y la contraseña en la base de datos
    $usuario = dbFetchRow("SELECT id_usuario, contraseña_hash FROM usuarios_sistema WHERE nombre_usuario = '" . dbEscape($nombre_usuario) . "' AND activo = 1");

    if ($usuario && password_verify($contraseña, $usuario['contraseña_hash'])) {
        // Usuario autenticado correctamente
        return $usuario['id_usuario'];
    } else {
        // Autenticación fallida
        return false;
    }
}

function iniciarSesion($id_usuario)
{
    $_SESSION['user_id'] = $id_usuario;

    // Generar un token único para esta sesión
    $token = bin2hex(random_bytes(32));
    $_SESSION['token'] = $token;

    // Registrar la sesión en la base de datos
    dbQueryPreparada("INSERT INTO sesiones (id_usuario, token, fecha_inicio_sesion) VALUES (?, ?, NOW())", [$id_usuario, $token]);
}

function verificarSesion()
{
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['token'])) {
        return false;
    }

    // Verificar si la sesión está registrada en la base de datos y aún es válida
    $sesion = dbFetchRow("SELECT id_sesion FROM sesiones WHERE id_usuario = '" . dbEscape($_SESSION['user_id']) . "' AND token = '" . dbEscape($_SESSION['token']) . "' AND fecha_cerrar_sesion IS NULL");

    return (bool)$sesion;
}

function cerrarSesion()
{
    if (isset($_SESSION['user_id']) && isset($_SESSION['token'])) {
        // Actualizar la base de datos para marcar el fin de la sesión
        dbQueryPreparada("UPDATE sesiones SET fecha_cerrar_sesion = NOW() WHERE id_usuario = ? AND token = ?", [$_SESSION['user_id'], $_SESSION['token']]);
    }

    // Destruir la sesión de PHP
    session_unset();
    session_destroy();
}
