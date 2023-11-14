<?php
require_once __DIR__ . '/../../includes/header.php';
?>

<style>
    .input-group-text {
        cursor: pointer;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center mb-3 font-weight-bold">Registro</h5>
                    <form id="formularioRegistro" action="backend/procesar_registro.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="usuario" class="form-control mb-3" placeholder="Usuario" required>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" name="contraseña" class="form-control mb-3" placeholder="Contraseña" id="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash" id="togglePassword"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" name="confirmar_contraseña" class="form-control mb-3" placeholder="Confirmar Contraseña" id="confirmPassword" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash" id="toggleConfirmPassword"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-block mt-3">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Listener para el botón de mostrar contraseña
        $('#togglePassword, #toggleConfirmPassword').click(function() {
            var passwordField = $(this).closest('.input-group').find('input');
            var passwordFieldType = passwordField.attr('type');
            if (passwordFieldType == 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });

        // Validación de contraseña en el frontend
        $('#formularioRegistro').submit(function(e) {
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();

            var validPassword = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z]).{8,}$/;

            if (!validPassword.test(password)) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error',
                    text: 'La contraseña debe tener al menos 8 caracteres, incluir un número y un carácter especial.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                return false;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error',
                    text: 'Las contraseñas no coinciden.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
                return false;
            }
        });
    });
</script>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>