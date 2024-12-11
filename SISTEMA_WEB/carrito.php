<?php 
session_start();
include "modelo/conexion.php";

// Verificar si la sesión está iniciada
$sesion_iniciada = isset($_SESSION['id_cliente']);

// Función para contar los productos en el carrito
function contarProductosEnCarrito() {
    if (!isset($_SESSION['carrito'])) {
        return 0;
    }
    $totalProductos = 0;
    foreach ($_SESSION['carrito'] as $producto) {
        $totalProductos += $producto['cantidad'];
    }
    return $totalProductos;
}

// Agregar producto al carrito
if (isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
    $producto_id = $_POST['producto_id'];
    $cantidad = (int)$_POST['cantidad'];

    // Crear el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Consultar el producto en la base de datos
    $query = "SELECT * FROM inventario WHERE id_producto = $producto_id";
    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();

        // Si ya está en el carrito, actualizar la cantidad; si no, añadirlo
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
        } else {
            $_SESSION['carrito'][$producto_id] = [
                'nombre' => $producto['nombre_producto'],
                'precio' => $producto['precio_producto'],
                'cantidad' => $cantidad,
                'stock' => $producto['cantidad_producto']
            ];
        }
    }

    header('Location: carrito.php');
    exit();
}

// Eliminar un producto del carrito
if (isset($_POST['eliminar_id'])) {
    $producto_id = $_POST['eliminar_id'];
    if (isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
    }
}

// Actualizar la cantidad de un producto en el carrito
if (isset($_POST['actualizar_id']) && isset($_POST['cantidad'])) {
    $producto_id = $_POST['actualizar_id'];
    $cantidad = (int)$_POST['cantidad'];

    if (isset($_SESSION['carrito'][$producto_id])) {
        if ($cantidad > 0 && $cantidad <= $_SESSION['carrito'][$producto_id]['stock']) {
            $_SESSION['carrito'][$producto_id]['cantidad'] = $cantidad;
        } else {
            echo "<script>alert('Cantidad no disponible de Productos');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PapelPlus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="img/logo2.jpeg" type="image/png">
    <style>
      .cart-counter {
        background-color: #dc3545;
        border-radius: 50%;
        color: white;
        padding: 0.25em 0.6em;
        font-size: 0.875rem;
        position: absolute;
        top: -10px;
        right: -10px;
      }
    </style>
</head>
<body>

<header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand">
                <strong>PapelPlus</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarHeader">
                <div class="d-flex ms-auto align-items-center">
                    <form class="d-flex me-2" method="GET" action="index.php" style="max-width: 250px;">
                        <div class="input-group">
                            <input class="form-control" type="search" placeholder="Buscar..." aria-label="Search" name="query" style="height: 38px; font-size: 0.95rem;">
                            <button class="btn btn-outline-light" type="submit" style="height: 38px; font-size: 0.95rem;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <a href="carrito.php" class="btn btn-primary position-relative me-2" style="height: 38px; font-size: 0.95rem; display: flex; align-items: center;">
                        <i class="fas fa-shopping-cart me-1"></i> Carrito
                        <?php if ($cantidadCarrito = contarProductosEnCarrito()): ?>
                            <span class="cart-counter"><?php echo $cantidadCarrito; ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if ($sesion_iniciada): ?>
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <?php echo htmlspecialchars($_SESSION['nombre_cliente']); ?>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="iniciosesion.php" class="btn btn-success"><i class="fas fa-user"></i> Ingresar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="container mt-5">
    <h1>Carrito de Compras</h1>
    <?php if (!empty($_SESSION['carrito'])): ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            foreach ($_SESSION['carrito'] as $id_producto => $producto) {
                $subtotal = $producto['precio'] * $producto['cantidad'];
                $total += $subtotal;
                echo "<tr>
                        <td>{$producto['nombre']}</td>
                        <td>\${$producto['precio']}</td>
                        <td>
                            <form action='carrito.php' method='post' class='d-inline' id='form-{$id_producto}'>
                                <input type='hidden' name='actualizar_id' value='{$id_producto}'>
                                <input type='number' name='cantidad' value='{$producto['cantidad']}' min='1' max='{$producto['stock']}' class='form-control' style='width: 80px; display: inline-block;' onchange='document.getElementById(\"form-{$id_producto}\").submit()'>
                            </form>
                        </td>
                        <td>\${$subtotal}</td>
                        <td>
                            <form action='carrito.php' method='post' class='d-inline'>
                                <input type='hidden' name='eliminar_id' value='{$id_producto}'>
                                <button type='button' class='btn btn-danger' onclick='confirmarEliminacion(this.form)'>
                                    <i class='fas fa-trash'></i>
                                </button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" class="text-end">Total</td>
                <td><?php echo "\${$total}"; ?></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
        <a href="index.php" class="btn btn-secondary">Seguir Comprando</a>
        <button class="btn btn-success" onclick="mostrarOpcionesPago()">Proceder al Pago</button>

        <!-- Modal para opciones de pago -->
        <div id="modalOpcionesPago" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Opciones de Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="procesar_pago.php" method="POST" id="formPago">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pago_tienda" value="tienda" required>
                                <label class="form-check-label" for="pago_tienda">
                                    Pago contra entrega en tienda
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pago_tarjeta" value="tarjeta">
                                <label class="form-check-label" for="pago_tarjeta">
                                    Pago con tarjeta de crédito/débito
                                </label>
                                <div id="form_tarjeta" style="display: none;">
                                    <input type="text" class="form-control mt-2" name="numero_tarjeta" id="numero_tarjeta" placeholder="Número de tarjeta">
                                    <input type="text" class="form-control mt-2" name="fecha_expiracion" id="fecha_expiracion" placeholder="Fecha de expiración (MM/AA)">
                                    <input type="text" class="form-control mt-2" name="cvv" id="cvv" placeholder="CVV">
                                </div>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pago_transferencia" value="transferencia">
                                <label class="form-check-label" for="pago_transferencia">
                                    Pago por transferencia bancaria
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Confirmar Pago</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>El carrito está vacío.</p>
    <?php endif; ?>
</main>

<script>
function confirmarEliminacion(form) {
    if (confirm("¿Desea eliminar el producto de la lista?")) {
        form.submit();
    }
}

function mostrarOpcionesPago() {
    const modal = new bootstrap.Modal(document.getElementById('modalOpcionesPago'));
    modal.show();

    document.getElementById('pago_tarjeta').addEventListener('change', function() {
        document.getElementById('form_tarjeta').style.display = 'block';
    });

    document.getElementById('pago_tienda').addEventListener('change', function() {
        document.getElementById('form_tarjeta').style.display = 'none';
    });

    document.getElementById('pago_transferencia').addEventListener('change', function() {
        document.getElementById('form_tarjeta').style.display = 'none';
    });
}

document.getElementById('formPago').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const metodoPago = document.querySelector('input[name="metodo_pago"]:checked');
    
    if (!metodoPago) {
        alert('Por favor, seleccione un método de pago.');
        return;
    }
    
    if (metodoPago.value === 'tarjeta') {
        const numeroTarjeta = document.getElementById('numero_tarjeta').value;
        const fechaExpiracion = document.getElementById('fecha_expiracion').value;
        const cvv = document.getElementById('cvv').value;
        
        if (!numeroTarjeta || !fechaExpiracion || !cvv) {
            alert('Por favor, complete todos los campos de la tarjeta.');
            return;
        }
        
        // Validación básica del número de tarjeta (16 dígitos)
        if (!/^\d{16}$/.test(numeroTarjeta)) {
            alert('El número de tarjeta debe tener 16 dígitos.');
            return;
        }
        
        // Validación básica de la fecha de expiración (MM/AA)
        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(fechaExpiracion)) {
            alert('La fecha de expiración debe tener el formato MM/AA.');
            return;
        }
        
        // Validación básica del CVV (3 o 4 dígitos)
        if (!/^\d{3,4}$/.test(cvv)) {
            alert('El CVV debe tener 3 o 4 dígitos.');
            return;
        }
    }
    
    // Si todas las validaciones pasan, enviar el formulario
    this.submit();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




