<?php
session_start();

/* Configuración de la aplicación */
require_once "./app/config/App.php";

// Cuando un usuario posea una sesión activa, redirige a la página principal
if (isset($_SESSION['login']) && $_SESSION['login']['status'] == true) {
    header("Location: " . SERVERURL . "views/");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= COMPANY ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= SERVERURL ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= SERVERURL ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SERVERURL ?>dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- Formulario de inicio de sesión -->
        <form action="" method="post" autocomplete="off" id="formulario-login">
            <div class="card card-outline">
                <div class="card-header text-center">
                    <h3>Iniciar sesión</h3>
                </div>
                <div class="card-body">

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="nombreusuario" name="nombreusuario" placeholder="Nombre de usuario" autofocus required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="claveacceso" name="claveacceso" placeholder="Contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>


                    <div class="social-auth-links text-center mt-2 mb-3">
                        <button class="btn btn-sm btn-primary btn-block" type="submit">Entrar</button>
                    </div>

                    <!-- Enlace para el registro -->
                    <p class="mb-0 text-center">
                        ¿No tienes una cuenta? <a href="./registro.php">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </form>
    </div>

    <!-- Archivos JS -->
    <script src="<?= SERVERURL ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?= SERVERURL ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= SERVERURL ?>dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const formulario = document.querySelector("#formulario-login");
            const inputNomUser = document.querySelector("#nombreusuario");
            const inputPassUser = document.querySelector("#claveacceso");

            formulario.addEventListener("submit", async (event) => {
                event.preventDefault();

                const parametros = new FormData();
                parametros.append("operation", "login");
                parametros.append("nombreusuario", inputNomUser.value);
                parametros.append("claveacceso", inputPassUser.value);

                const response = await fetch(`./app/controllers/Usuario.controller.php`, {
                    method: 'POST',
                    body: parametros
                });

                const data = await response.json();

                if (!data.esCorrecto) {
                    Swal.fire('Error', data.mensaje, 'error');
                } else {
                    Swal.fire('¡Éxito!', data.mensaje, 'success').then(() => {
                        window.location.href = './views/home/welcome';
                    });
                }
            });
        });
    </script>
</body>

</html>