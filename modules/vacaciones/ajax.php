<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'errors.log');

require_once __DIR__ . '/../../config/database.php';

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    case 'agregar':
        break;
    case 'editar':
        break;
    case 'eliminar':
        break;
    case 'obtener':
        break;
    default:
        echo json_encode(['error' => 'Acción no reconocida']);
        break;
}

dbClose();