<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<style>
    .bi {
        font-size: 1.25rem;
    }
</style>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Empleados</h2>
    <div class="d-flex justify-content-between align-items-center mt-4">
        <button id="btnAgregar" class="btn btn-success" data-toggle="modal" data-target="#modalEmpleado">
            Agregar Empleados
        </button>

        <div>
            <button class="btn btn-sm btn-primary"><i class="bi bi-filetype-csv"></i></button>
            <button class="btn btn-sm btn-success"><i class="bi bi-filetype-xlsx"></i></button>
            <button class="btn btn-sm btn-danger"><i class="bi bi-filetype-pdf"></i></button>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-hover" id="tabla_empleados">
            <thead class="table-success">
                <tr>
                    <th>DPI</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Puesto</th>
                    <th>Correo</th>
                    <th>Fecha Inicio</th>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioEmpleado">
                    <!-- Campos del formulario -->
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="puesto">Puesto</label>
                        <input type="text" class="form-control" id="puesto" name="puesto" required>
                    </div>
                    <!-- Más campos según necesites -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="formularioEmpleado">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    // Inicializar DataTable en tu tabla
    $('#tabla_empleados').DataTable({
        // Opciones de DataTables (puedes personalizar estas opciones según tus necesidades)
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        // Aquí puedes añadir más opciones como la carga de datos a través de AJAX, etc.
    });

    // Código para manejar eventos del modal, agregar, editar y eliminar empleados
    // ...

    // Eventos para botones de exportación
    // ...
});

</script>
<!-- <script src="index.js"></script> -->

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
