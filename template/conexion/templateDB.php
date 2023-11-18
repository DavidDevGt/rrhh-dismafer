<?php
// Parámetros de conexión a la base de datos
$host = 'localhost';
$db_name = 'rrhh_dismafer';
$username = 'root';
$password = '';

// Establecer conexión con la base de datos usando mysqli
$conexion = new mysqli($host, $username, $password, $db_name);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Funciones para interactuar con la base de datos más rápido
function dbQuery($query)
{
    global $conexion;
    return mysqli_query($conexion, $query);
}

function dbFetchAssoc($result)
{
    return mysqli_fetch_assoc($result);
}
function dbNumRows($result)
{
    return mysqli_num_rows($result);
}
function dbEscape($str)
{
    global $conexion;
    return mysqli_real_escape_string($conexion, $str);
}

function dbInsertId()
{
    global $conexion;
    return mysqli_insert_id($conexion);
}


function dbClose()
{
    global $conexion;
    mysqli_close($conexion);
}


function dbFetchAll($result)
{
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function dbFetchRow($query)
{
    global $conexion;
    $result = mysqli_query($conexion, $query);
    return mysqli_fetch_assoc($result);
}

function dbFetchValue($query)
{
    global $conexion;
    $result = mysqli_query($conexion, $query);
    $row = mysqli_fetch_array($result);
    return $row[0];
}

function dbUpdate($table, $data, $condition)
{
    global $conexion;
    $setQuery = [];
    foreach ($data as $column => $value) {
        $setQuery[] = "`$column` = '" . dbEscape($value) . "'";
    }
    $query = "UPDATE `$table` SET " . implode(', ', $setQuery) . " WHERE $condition";
    return mysqli_query($conexion, $query);
}

function dbQueryPreparada($query, $params = [])
{
    global $conexion;

    $stmt = $conexion->prepare($query);
    if ($stmt === false) {
        return false;
    }

    if ($params) {
        $tipos = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $tipos .= 'i';
            } elseif (is_float($param)) {
                $tipos .= 'd';
            } elseif (is_string($param)) {
                $tipos .= 's';
            } else {
                $tipos .= 'b';
            }
        }

        $stmt->bind_param($tipos, ...$params);
    }

    $stmt->execute();
    return $stmt;
}
