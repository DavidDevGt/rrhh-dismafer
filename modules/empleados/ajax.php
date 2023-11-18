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
        eliminarEmpleado();
        break;
    case 'obtener':
        obtenerEmpleados();
        break;
    default:
        echo json_encode(['error' => 'Acción no reconocida']);
        break;
}

function agregarEmpleado()
{}

function editarEmpleado()
{}

function eliminarEmpleado()
{
    $id_empleado = $_POST['id_empleado'];
    $query = "UPDATE empleados SET activo = 0 WHERE id_empleado = " . dbEscape($id_empleado);
    if (dbQuery($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al eliminar empleado']);
    }
}

function obtenerEmpleados()
{
    $query = "SELECT * FROM empleados";
    $result = dbQuery($query);
    $empleados = dbFetchAll($result);
    echo json_encode(['data' => $empleados]);
}

dbClose();