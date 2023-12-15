<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<style>
    .bi {
        font-size: 1.25rem;
    }

    .btn-sm {
        margin-right: 5px;
    }

    #tabla_empleados_filter {
        margin-bottom: 15px;
    }

    #tabla_empleados_length {
        margin-bottom: 15px;
    }

    /* Estilo para el interruptor de activo/inactivo */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
        vertical-align: middle;
        /* Alinea verticalmente con otros elementos si es necesario */
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 28px;
        /* Hace que el fondo también sea redondeado */
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        /* Ajuste para centrar mejor el círculo */
        bottom: 3px;
        /* Ajuste para centrar mejor el círculo */
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
        /* Círculo perfecto */
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(22px);
        -ms-transform: translateX(22px);
        transform: translateX(22px);
    }
</style>

<div class="container mt-4">
    <h2 class="text-center">Gestión de Empleados</h2>
    <div class="d-flex justify-content-between align-items-center">
        <button id="btnAgregar" class="btn btn-success" data-toggle="modal" data-target="#modalEmpleado">
            Agregar Empleados
        </button>

        <div>
            <button class="btn btn-sm btn-primary"><i class="bi bi-filetype-csv"></i></button>
            <button class="btn btn-sm btn-success"><i class="bi bi-filetype-xlsx"></i></button>
            <button class="btn btn-sm btn-danger"><i class="bi bi-filetype-pdf"></i></button>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-hover" id="tabla_empleados">
            <thead class="thead-light">
                <tr>
                    <th>DPI</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Puesto</th>
                    <th>Correo</th>
                    <th>Fecha Inicio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Las filas se cargarán dinámicamente aquí -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para agregar/editar empleados -->
<div class="modal fade" id="modalEmpleado" tabindex="-1" role="dialog" aria-labelledby="modalEmpleadoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEmpleadoLabel">Agregar/Editar Empleado</h5>
                <button type="button" class="close btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioEmpleado">
                    <!-- Campos del formulario en dos columnas -->
                    <div class="row">
                        <div class="col-md-6 form-group mt-2">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control mt-1" id="nombres" name="nombre" required>
                        </div>
                        <div class="col-md-6 form-group mt-2">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control mt-1" id="apellidos" name="apellido" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mt-2">
                            <label for="puesto">Puesto</label>
                            <input type="text" class="form-control mt-1" id="puesto" name="puesto" required>
                        </div>
                        <div class="col-md-6 form-group mt-2">
                            <label for="telefono">Telefono</label>
                            <input type="text" class="form-control mt-1" id="telefono" name="telefono" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mt-2">
                            <label for="estado_civil">Estado Civil</label>
                            <input type="text" class="form-control mt-1" id="estado_civil" name="estado_civil" required>
                        </div>
                        <div class="col-md-6 form-group mt-2">
                            <label for="correo">Correo</label>
                            <input type="text" class="form-control mt-1" id="correo" name="correo" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mt-2">
                            <label for="fecha_nacimiento">Fecha Nacimiento</label>
                            <input type="text" class="form-control datepicker mt-1" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>
                        <div class="col-md-6 form-group mt-2">
                            <label for="fecha_inicio">Fecha Inicio de Labores</label>
                            <input type="text" class="form-control datepicker mt-1" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                    </div>

                    <!-- Campo en una sola columna -->
                    <div class="form-group mt-2">
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control mt-1" id="direccion" name="direccion" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="dpi">DPI</label>
                        <input type="text" class="form-control mt-1" id="dpi" name="dpi" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="activo">Activo</label>
                        <label class="switch">
                            <input type="checkbox" id="activo" name="activo">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formularioEmpleado">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Inicialización de Datepicker para los campos de fecha
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        // Inicializar DataTable
        var tablaEmpleados = $('#tabla_empleados').DataTable({
            "ajax": {
                "url": "/rrhh-dismafer/empleados/ajax",
                "type": "POST",
                "data": {
                    "accion": "obtener"
                }
            },
            "columns": [{
                    "data": "dpi"
                },
                {
                    "data": "nombres"
                },
                {
                    "data": "apellidos"
                },
                {
                    "data": "puesto"
                },
                {
                    "data": "correo"
                },
                {
                    "data": "fecha_inicio"
                },
                {
                    "data": "activo",
                    "render": function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge badge-success">Activo</span>';
                        } else {
                            return '<span class="badge badge-danger">Inactivo</span>';
                        }
                    }
                },
                {
                    "data": "id_empleado",
                    "render": function(data, type, row) {
                        return '<button class="btn btn-sm btn-warning btnEditar" data-id="' + data + '"><i class="bi bi-pencil-square"></i></button><button class="btn btn-sm btn-danger btnEliminar" data-id="' + data + '"><i class="bi bi-trash"></i></button>';
                    }
                }
                // ... otras columnas ...
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        });

        // Manejo de apertura del modal
        $('#btnAgregar').click(function() {
            prepararModalParaAgregar();
        });

        function prepararModalParaAgregar() {
            limpiarFormulario();
            $('#modalEmpleadoLabel').text('Agregar Empleado');
            $('#formularioEmpleado').attr('data-accion', 'agregar');
            $('#modalEmpleado').modal('show');
        }

        // Función para limpiar el formulario
        function limpiarFormulario() {
            $('#formularioEmpleado')[0].reset();
        }

        $('#formularioEmpleado').submit(function(e) {
            e.preventDefault();
            var datosFormulario = $(this).serialize();
            var accion = $(this).data('accion');

            $.ajax({
                url: '/rrhh-dismafer/empleados/ajax',
                type: 'POST',
                data: datosFormulario + "&accion=" + accion,
                success: function(response) {
                    $('#modalEmpleado').modal('hide');
                    if (response.success) {
                        tablaEmpleados.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: '¡El formulario se envió correctamente!',
                            showConfirmButton: false,
                            timer: 1000 // Duración de 1 segundo
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: '¡Hubo un error al enviar el formulario!',
                            showConfirmButton: false,
                            timer: 1000 // Duración de 1 segundo
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '¡Hubo un error en la solicitud!',
                        showConfirmButton: false,
                        timer: 1000 // Duración de 1 segundo
                    });
                }
            });
        });
        // Cerrar el modal usando el botón de cierre
        $('.close').click(function() {
            $('#modalEmpleado').modal('hide');
        });
    });
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>