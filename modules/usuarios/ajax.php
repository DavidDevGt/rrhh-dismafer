<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'errors.log');

require_once __DIR__ . '/../../config/database.php';

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    case 'agregar':
        agregarUsuario();
        break;
    case 'editar':
        editarUsuario();
        break;
    case 'eliminar':
        eliminarUsuario();
        break;
    case 'obtener':
        obtenerUsuarios();
        break;
    default:
        echo json_encode(['error' => 'Acción no reconocida']);
        break;
}

function agregarUsuario()
{
    $nombreUsuario = $_POST['nombre_usuario'] ?? '';
    $contrasena = $_POST['contrasena1'] ?? '';
    $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

    $query = "INSERT INTO usuarios_sistema (nombre_usuario, contraseña_hash, activo) VALUES ('" . dbEscape($nombreUsuario) . "', '" . dbEscape($contrasenaHash) . "', 1)";
    $resultado = dbQuery($query);
    echo $resultado ? json_encode(['success' => true]) : json_encode(['error' => 'Error al agregar usuario']);
}

function editarUsuario()
{
    $idUsuario = $_POST['id_usuario'] ?? '';
    $nombreUsuario = $_POST['nombre_usuario'] ?? '';
    $contrasena = $_POST['contrasena1'] ?? '';

    $query = "UPDATE usuarios_sistema SET nombre_usuario = '" . dbEscape($nombreUsuario) . "'";
    if (!empty($contrasena)) {
        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
        $query .= ", contraseña_hash = '" . dbEscape($contrasenaHash) . "'";
    }
    $activo = isset($_POST['activo']) && $_POST['activo'] === 'on' ? 1 : 0;
    $query .= ", activo = " . dbEscape($activo) . " WHERE id_usuario = " . dbEscape($idUsuario);

    $resultado = dbQuery($query);
    echo $resultado ? json_encode(['success' => true, 'message' => 'Usuario actualizado']) : json_encode(['error' => 'Error al editar usuario']);
}

function eliminarUsuario()
{
    $idUsuario = $_POST['id_usuario'] ?? '';
    $query = "UPDATE usuarios_sistema SET activo = 0 WHERE id_usuario = " . dbEscape($idUsuario);
    $resultado = dbQuery($query);
    echo $resultado ? json_encode(['success' => true]) : json_encode(['error' => 'Error al eliminar usuario']);
}

function obtenerUsuarios()
{
    $query = "SELECT * FROM usuarios_sistema";
    $result = dbQuery($query);
    $usuarios = dbFetchAll($result);
    echo json_encode(['data' => $usuarios]);
}

dbClose();