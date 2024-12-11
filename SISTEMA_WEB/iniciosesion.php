<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/styleiniciosesion.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
    <title>Inicio de sesión</title>
    <link rel="icon" href="img/logo2.jpeg" type="image/png">
</head>

<body>
    <img class="wave" src="img/wave.png" alt="Wave Background">
    <div class="container">
        <div class="img">
            <img src="img/bg.png" alt="Background Image">
        </div>
        <div class="login-content">
            <form method="post" action="login_cliente.php">
                <img src="img/avatar.png" alt="Avatar">
                <h2 class="title">BIENVENIDO</h2>
                <?php
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
                }
                ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input id="email" type="email" class="input" name="email_cliente" required>
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Contraseña</h5>
                        <input type="password" id="password" class="input" name="clave_cliente" required>
                    </div>
                </div>
                <input name="btningresar" class="btn" type="submit" value="INICIAR SESION">
                <div class="register-link">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal">Registrarse</button>
                </div>
                <div class="back-link">
                    <a href="index.php" class="btn-back">Regresar</a>
                </div>
                <div class="admin-link">
                    <a href="login.php">Panel de administrador</a>
                </div>
                
            </form>
        </div>
    </div>

    <!-- Modal de Registro -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Registro de Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="registro_cliente.php">
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre</label>
                        <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="email_cliente">Email</label>
                        <input type="email" class="form-control" id="email_cliente" name="email_cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="clave_cliente">Contraseña</label>
                        <input type="password" class="form-control" id="clave_cliente" name="clave_cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono_cliente">Teléfono</label>
                        <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- JavaScript Libraries -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/fontawesome.js"></script>
    <script src="js/main.js"></script>
    <script src="js/main2.js"></script>
</body>

</html>
