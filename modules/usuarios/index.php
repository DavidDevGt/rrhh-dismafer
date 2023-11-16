<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<style>
    .bi {
        font-size: 1.25rem;
    }

    .btn-sm {
        margin-right: 5px;
    }

    #tabla_usuarios_filter {
        margin-bottom: 15px;
    }

    #tabla_usuarios_length {
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
    <h2 class="text-center">Usuarios del Sistema</h2>
    <div class="d-flex justify-content-between align-items-center">
        <button id="btnAgregar" class="btn btn-success" data-toggle="modal" data-target="#modalUsuario" disabled>
            Agregar Usuarios
        </button>

        <div>
            <button class="btn btn-sm btn-primary"><i class="bi bi-filetype-csv"></i></button>
            <button class="btn btn-sm btn-success"><i class="bi bi-filetype-xlsx"></i></button>
            <button class="btn btn-sm btn-danger"><i class="bi bi-filetype-pdf"></i></button>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-hover" id="tabla_usuarios">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Fecha Creación</th>
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

<!-- Modal para agregar/editar Usuarios -->
<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUsuarioLabel">Editar Usuarios</h5>
                <button type="button" class="close btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioUsuario">
                    <input type="hidden" id="id_usuario" name="id_usuario">

                    <!-- Campo en una sola columna -->
                    <div class="form-group mt-2">
                        <label for="nombre_usuario">Nombre de Usuario</label>
                        <input type="text" class="form-control mt-1" id="nombre_usuario" name="nombre_usuario" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="contrasena1">Contraseña</label>
                        <input type="text" class="form-control mt-1" id="contrasena1" name="contrasena1" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="contrasena2">Confirmar Contraseña</label>
                        <input type="text" class="form-control mt-1" id="contrasena2" name="contrasena2 " required>
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
                <button type="submit" class="btn btn-primary" form="formularioUsuario">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Inicialización de DataTables
        var tablaUsuarios = $('#tabla_usuarios').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": "/rrhh-dismafer/usuarios/ajax",
                "type": "POST",
                "data": function(d) {
                    d.accion = 'obtener';
                }
            },
            "columns": [{
                    "data": "id_usuario"
                },
                {
                    "data": "nombre_usuario"
                },
                {
                    "data": "creado_en"
                },
                {
                    "data": "activo",
                    render: function(data) {
                        return data == 1 ? 'Activo' : 'Inactivo';
                    }
                },
                {
                    "data": null,
                    "defaultContent": "<button class='btnEditar btn btn-warning btn-sm'>Editar</button><button class='btnEliminar btn btn-danger btn-sm'>Eliminar</button>"
                }
            ]
        });

        // Manejo de apertura del modal para agregar usuario
        $('#btnAgregar').click(function() {
            limpiarFormulario();
            $('#modalUsuario').modal('show');
        });

        // Evento para el envío del formulario
        $('#formularioUsuario').submit(function(e) {
            e.preventDefault();
            var datosFormulario = $(this).serialize();

            $.ajax({
                url: '/rrhh-dismafer/usuarios/ajax',
                type: 'POST',
                data: datosFormulario,
                success: function(response) {
                    $('#modalUsuario').modal('hide');
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "¡Hecho!",
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.error,
                        });
                    }
                    tablaUsuarios.ajax.reload();
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ocurrió un error al procesar la solicitud.",
                    });
                }
            });
        });

        // Eventos para editar y eliminar usuario
        $('#tabla_usuarios tbody').on('click', 'button.btnEditar', function() {
            var data = tablaUsuarios.row($(this).parents('tr')).data();
            cargarDatosModal(data);
            $('#modalUsuario').modal('show');
        });

        $('#tabla_usuarios tbody').on('click', 'button.btnEliminar', function() {
            var data = tablaUsuarios.row($(this).parents('tr')).data();

            Swal.fire({
                title: '¿Estás seguro de eliminar el usuario?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario hace clic en "Sí, eliminar", realiza la eliminación
                    $.ajax({
                        url: '/rrhh-dismafer/usuarios/ajax',
                        type: 'POST',
                        data: {
                            accion: 'eliminar',
                            id_usuario: data.id_usuario
                        },
                        success: function(response) {
                            tablaUsuarios.ajax.reload();
                        }
                    });
                }
            });
        });


        // Función para limpiar el formulario
        function limpiarFormulario() {
            $('#formularioUsuario')[0].reset();
            $('#formularioUsuario input[name="id_usuario"]').val('');
            $('#formularioUsuario input[name="accion"]').val('agregar');
        }


        // Función para cargar datos en el modal para editar
        function cargarDatosModal(data) {
            $('#formularioUsuario input[name="accion"]').val('editar');
            $('#formularioUsuario input[name="id_usuario"]').val(data.id_usuario);
            $('#formularioUsuario input[name="nombre_usuario"]').val(data.nombre_usuario);
            // No cargamos la contraseña
            $('#formularioUsuario input[name="activo"]').prop('checked', data.activo == 1);
        }

        // Cerrar el modal usando el botón de cierre
        $('.close').click(function() {
            $('#modalUsuario').modal('hide');
        });
    });;
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>