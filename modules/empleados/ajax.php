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
{
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $puesto = $_POST['puesto'];
    $telefono = $_POST['telefono'];
    $estado_civil = $_POST['estado_civil'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $direccion = $_POST['direccion'];
    $dpi = $_POST['dpi'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    $query = "INSERT INTO empleados (nombres, apellidos, puesto, telefono, estado_civil, correo, fecha_nacimiento, fecha_inicio, direccion, dpi, activo) VALUES (" . dbEscape($nombres) . ", " . dbEscape($apellidos) . ", " . dbEscape($puesto) . ", " . dbEscape($telefono) . ", " . dbEscape($estado_civil) . ", " . dbEscape($correo) . ", " . dbEscape($fecha_nacimiento) . ", " . dbEscape($fecha_inicio) . ", " . dbEscape($direccion) . ", " . dbEscape($dpi) . ", " . dbEscape($activo) . ")";
    if (dbQuery($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al agregar empleado']);
    }
}

function editarEmpleado()
{
    $id_empleado = $_POST['id_empleado'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $puesto = $_POST['puesto'];
    $telefono = $_POST['telefono'];
    $estado_civil = $_POST['estado_civil'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $direccion = $_POST['direccion'];
    $dpi = $_POST['dpi'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    $query = "UPDATE empleados SET nombres = '" . dbEscape($nombres) . "', apellidos = '" . dbEscape($apellidos) . "', puesto = '" . dbEscape($puesto) . "', telefono = '" . dbEscape($telefono) . "', estado_civil = '" . dbEscape($estado_civil) . "', correo = '" . dbEscape($correo) . "', fecha_nacimiento = '" . dbEscape($fecha_nacimiento) . "', fecha_inicio = '" . dbEscape($fecha_inicio) . "', direccion = '" . dbEscape($direccion) . "', dpi = '" . dbEscape($dpi) . "', activo = " . dbEscape($activo) . " WHERE id_empleado = " . dbEscape($id_empleado);
    if (dbQuery($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al editar empleado']);
    }

}

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