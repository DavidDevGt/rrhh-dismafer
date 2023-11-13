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
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center mb-3 font-weight-bold">Iniciar sesión</h5>
                    <form id="formularioLogin" action="backend/procesar_login.php" method="POST">
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
                        <div class="text-center">
                            <a href="index.php?page=register">¿No tienes una cuenta?</a>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-primary btn-block mt-3">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Listener para el botón contraseña
        $('#togglePassword').click(function() {
            var passwordField = $('#password');
            var passwordFieldType = passwordField.attr('type');
            if (passwordFieldType == 'password') {
                passwordField.attr('type', 'text');
                $(this).removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                passwordField.attr('type', 'password');
                $(this).removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });
    });
</script>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>