<?php
session_start();
if (empty($_SESSION["id"])) {
    header("location: login.php");
    exit();
}

include "modelo/conexion.php";

// Orden por defecto (ASCendente)
$order = 'ASC';
$order_by = 'id_producto'; // Ordenar por defecto por ID de producto

function mostrarDireccionOrden($order_by, $order) {
    if ($order == 'ASC') {
        $direccion = 'Menor a mayor';
    } else {
        $direccion = 'Mayor a menor';
    }

    if ($order_by == 'cantidad_producto') {
        $columna = 'Cantidad Producto';
    } elseif ($order_by == 'precio_producto') {
        $columna = 'Precio Producto';
    } else {
        $columna = 'ID Producto'; // Por defecto
    }

    echo "Ordenado por $columna: $direccion";
}

// Consultar la base de datos con la ordenación y búsqueda
function fetchProducts($conexion, $order_by, $order, $search_term = '') {
    $query = "SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, cantidad_producto, imagen_producto FROM inventario";
    
    // Agregar la cláusula WHERE si se ha proporcionado un término de búsqueda
    if (!empty($search_term)) {
        $search_term = mysqli_real_escape_string($conexion, $search_term);
        $query .= " WHERE nombre_producto LIKE '%$search_term%'";
    }
    
    $query .= " ORDER BY $order_by $order";
    
    $result = $conexion->query($query);
    return $result;
}

if (isset($_GET['ordenar'])) {
    if ($_GET['ordenar'] == 'cantidad_desc') {
        $order_by = 'cantidad_producto';
        $order = 'DESC';
    } elseif ($_GET['ordenar'] == 'cantidad_asc') {
        $order_by = 'cantidad_producto';
        $order = 'ASC';
    } elseif ($_GET['ordenar'] == 'precio_desc') {
        $order_by = 'precio_producto';
        $order = 'DESC';
    } elseif ($_GET['ordenar'] == 'precio_asc') {
        $order_by = 'precio_producto';
        $order = 'ASC';
    }
}

// Obtener los resultados según el término de búsqueda si se proporcionó
if (isset($_GET['buscar'])) {
    $search_term = $_GET['buscar'];
    $result = fetchProducts($conexion, $order_by, $order, $search_term);
} else {
    $result = fetchProducts($conexion, $order_by, $order);
}

// Función para insertar un nuevo producto en la base de datos
function insertarProducto($conexion, $nombre, $descripcion, $precio, $cantidad, $imagen) {
    // Escapar caracteres especiales y evitar inyección SQL
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);
    $imagen = mysqli_real_escape_string($conexion, $imagen);

    // Preparar la consulta SQL para insertar los datos
    $query = "INSERT INTO inventario (nombre_producto, descripcion_producto, precio_producto, cantidad_producto, imagen_producto) VALUES ('$nombre', '$descripcion', $precio, $cantidad, '$imagen')";
    return $conexion->query($query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Obtener los valores del formulario
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $imagen = $_FILES["imagen"]["name"];

    // Validar que todos los campos están completos
    if (empty($nombre) || empty($descripcion) || empty($precio) || empty($cantidad) || empty($imagen)) {
        echo "<div class='error-message'>Por favor, complete todos los campos</div>";
    } else {
        // Manejar la subida de la imagen
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($imagen);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validar que el archivo es una imagen
        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check !== false) {
            // Subir la imagen
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                // Insertar el producto en la base de datos
                if (insertarProducto($conexion, $nombre, $descripcion, $precio, $cantidad, $target_file)) {
                    echo "<div class='success-message'>Producto agregado correctamente</div>";
                    header("Location: inventario.php");
                    exit();
                } else {
                    echo "<div class='error-message'>Error al agregar producto</div>";
                }
            } else {
                echo "<div class='error-message'>Error al subir la imagen</div>";
            }
        } else {
            echo "<div class='error-message'>El archivo no es una imagen válida</div>";
        }
    }
}

// Manejar la eliminación de un producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"])) {
    // Obtener el ID del producto a eliminar y la cantidad a eliminar
    $id_producto_eliminar = $_POST["id_producto"];
    $cantidad_eliminar = $_POST["cantidad_eliminar"];
    $cantidad_disponible = $_POST["cantidad_disponible"];

    // Verificar que la cantidad a eliminar no sea mayor que la cantidad disponible
    if ($cantidad_eliminar > $cantidad_disponible) {
        echo "<div class='error-message'>No se puede eliminar más de la cantidad disponible</div>";
    } else {
        // Calcular la nueva cantidad después de la eliminación
        $nueva_cantidad = $cantidad_disponible - $cantidad_eliminar;

        // Verificar si la nueva cantidad es 0, entonces eliminar el producto
        if ($nueva_cantidad == 0) {
            $query_eliminar = "DELETE FROM inventario WHERE id_producto = ?";
            
            // Preparar la consulta
            $stmt = $conexion->prepare($query_eliminar);

            // Vincular parámetros
            $stmt->bind_param("i", $id_producto_eliminar);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "<div class='success-message'>Producto eliminado completamente</div>";
                header("Location: inventario.php");
                exit();
            } else {
                echo "<div class='error-message'>Error al eliminar producto</div>";
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            // Actualizar la cantidad del producto
            $query_actualizar = "UPDATE inventario SET cantidad_producto = ? WHERE id_producto = ?";
            
            // Preparar la consulta
            $stmt = $conexion->prepare($query_actualizar);

            // Vincular parámetros
            $stmt->bind_param("ii", $nueva_cantidad, $id_producto_eliminar);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "<div class='success-message'>Cantidad de producto actualizada correctamente</div>";
                header("Location: inventario.php");
                exit();
            } else {
                echo "<div class='error-message'>Error al actualizar la cantidad del producto</div>";
            }

            // Cerrar la declaración
            $stmt->close();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitEdit"])) {
    // Obtener los valores del formulario de edición
    $id_edit = $_POST["editId"];
    $nombre_edit = $_POST["editNombre"];
    $descripcion_edit = $_POST["editDescripcion"];
    $precio_edit = $_POST["editPrecio"];
    $cantidad_edit = $_POST["editCantidad"];

    // Verificar si algún campo está vacío
    if (empty($nombre_edit) || empty($descripcion_edit) || empty($precio_edit) || empty($cantidad_edit)) {
        echo "<div class='error-message'>Por favor, complete todos los campos</div>";
    } else {
        // Manejar la subida de la nueva imagen
        $imagen_edit = $_FILES["editNuevaImagen"]["name"];
        $imagen_ruta = "";

        if (!empty($imagen_edit)) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($imagen_edit);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["editNuevaImagen"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["editNuevaImagen"]["tmp_name"], $target_file)) {
                    $imagen_ruta = $target_file;
                } else {
                    echo "<div class='error-message'>Error al subir la imagen</div>";
                }
            } else {
                echo "<div class='error-message'>El archivo no es una imagen válida</div>";
            }
        }

        // Actualizar el producto en la base de datos
        if (!empty($imagen_ruta)) {
            $query_update = "UPDATE inventario SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, cantidad_producto = ?, imagen_producto = ? WHERE id_producto = ?";
            $stmt_update = $conexion->prepare($query_update);
            $stmt_update->bind_param("ssdiss", $nombre_edit, $descripcion_edit, $precio_edit, $cantidad_edit, $imagen_ruta, $id_edit);
        } else {
            $query_update = "UPDATE inventario SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, cantidad_producto = ? WHERE id_producto = ?";
            $stmt_update = $conexion->prepare($query_update);
            $stmt_update->bind_param("ssdii", $nombre_edit, $descripcion_edit, $precio_edit, $cantidad_edit, $id_edit);
        }

        if ($stmt_update->execute()) {
            echo "<div class='success-message'>Producto actualizado correctamente</div>";
            header("Location: inventario.php");
            exit();
        } else {
            echo "<div class='error-message'>Error al actualizar producto</div>";
        }

        $stmt_update->close();
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleinicio.css">
    <link rel="stylesheet" href="css/styleinventario.css">
    <link rel="icon" href="img/logo.jpeg" type="image/png">
</head>
<body>
<nav class="main-menu">
<ul>
            <li><a href="inicio.php"><img src="img/logo.jpeg" class="menu-logo"></a></li>
            <li><a href="inventario.php" class="menu-item">Inventario</a></li>
            <li><a href="clientes.php" class="menu-item">Clientes</a></li>
            <li><a href="pedidos.php" class="menu-item">Pedidos</a></li>
            <li><a href="ventas.php" class="menu-item">Ventas</a></li>
        </ul>
    <li class="user-section">
        <span class="username"><?php echo $_SESSION["nombre"] . " " . $_SESSION["apellido"]; ?></span>
        <a id="logout-button" class="logout-button" href="controlador/controlador_cerrar_sesion.php">Cerrar Sesión</a>
    </li>
</nav>
<div class="sub-banner">
    <ul>
        <li>
            <form class="search-form" method="GET" action="inventario.php">
                <input type="text" name="buscar" class="search-input" placeholder="Buscar por nombre...">
                <button type="submit" class="search-button">Buscar</button>
            </form>
        </li>
        <li><button onclick="openModal()" class="menu-item">Agregar</button></li>
        <li><button onclick="ordenarCantidadDesc()" class="menu-item">Cantidad: Mayor a Menor</button></li>
        <li><button onclick="ordenarCantidadAsc()" class="menu-item">Cantidad: Menor a Mayor</button></li>
        <li><button onclick="ordenarPrecioDesc()" class="menu-item">Precio: Mayor a Menor</button></li>
        <li><button onclick="ordenarPrecioAsc()" class="menu-item">Precio: Menor a Mayor</button></li>
        <li><button onclick="window.location.href='generarinforme.php'" class="menu-item">Generar Informe</button></li>
    </ul>
</div>
<script>
    function openDeleteModal(id, nombre, cantidad) {
        document.getElementById("deleteModal").style.display = "block";
        document.getElementById("deleteId").value = id;
        document.getElementById("deleteNombre").innerText = nombre;
        document.getElementById("deleteCantidadDisponible").innerText = cantidad;
        document.getElementById("deleteCantidadDisponibleInput").value = cantidad;
    }

    function closeDeleteModal() {
        document.getElementById("deleteModal").style.display = "none";
    }

    function ordenarCantidadDesc() {
        window.location.href = 'inventario.php?ordenar=cantidad_desc';
    }

    function ordenarCantidadAsc() {
        window.location.href = 'inventario.php?ordenar=cantidad_asc';
    }

    function ordenarPrecioDesc() {
        window.location.href = 'inventario.php?ordenar=precio_desc';
    }

    function ordenarPrecioAsc() {
        window.location.href = 'inventario.php?ordenar=precio_asc';
    }

    // Función para abrir la ventana emergente
    function openModal() {
        document.getElementById("myModal").style.display = "block";
    }

    // Función para cerrar la ventana emergente
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    function closeModalAndReload() {
        document.getElementById("myModal").style.display = "none";
        window.location.reload(); // Recargar la página
    }

    function openEditModal(id, nombre, descripcion, precio, cantidad, imagen) {
        document.getElementById("editModal").style.display = "block";
        document.getElementById("editId").value = id;
        document.getElementById("editNombre").value = nombre;
        document.getElementById("editDescripcion").value = descripcion;
        document.getElementById("editPrecio").value = precio;
        document.getElementById("editCantidad").value = cantidad;
        document.getElementById("editImagen").src = imagen; // Mostrar la imagen actual
    }

    function closeEditModal() {
        document.getElementById("editModal").style.display = "none";
    }
</script>
<!-- Ventana emergente para eliminar un producto -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteModal()">&times;</span>
        <h2>Eliminar Producto</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" id="deleteId" name="id_producto">
            <input type="hidden" id="deleteCantidadDisponibleInput" name="cantidad_disponible">
            <p>¿Cuántos productos desea eliminar?</p>
            <p>Producto: <span id="deleteNombre"></span></p>
            <p>Cantidad disponible: <span id="deleteCantidadDisponible"></span></p>
            <label for="cantidad_eliminar">Cantidad a eliminar:</label><br>
            <input type="number" id="cantidad_eliminar" name="cantidad_eliminar" min="1"><br><br>
            <input type="submit" name="eliminar" value="Eliminar">
        </form>
    </div>
</div>
<!-- Ventana emergente para editar un producto -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Editar Producto</h2>
        <form id="editForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <input type="hidden" id="editId" name="editId">
            <label for="editNombre">Nombre:</label><br>
            <input type="text" id="editNombre" name="editNombre"><br><br>
            <label for="editDescripcion">Descripción:</label><br>
            <textarea id="editDescripcion" name="editDescripcion"></textarea><br><br>
            <label for="editPrecio">Precio:</label><br>
            <input type="number" id="editPrecio" name="editPrecio" step="0.01"><br><br>
            <label for="editCantidad">Cantidad:</label><br>
            <input type="number" id="editCantidad" name="editCantidad"><br><br>
            <label for="editImagen">Imagen actual:</label><br>
            <img id="editImagen" src="" alt="Imagen del producto" style="width:100px;height:100px;"><br><br>
            <label for="editNuevaImagen">Nueva Imagen:</label><br>
            <input type="file" id="editNuevaImagen" name="editNuevaImagen"><br><br>
            <input type="submit" name="submitEdit" value="Guardar cambios">
        </form>
    </div>
</div>
<!-- Ventana emergente para agregar un nuevo producto -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModalAndReload()">&times;</span>
        <h2>Agregar Producto</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre"><br><br>
            <label for="descripcion">Descripción:</label><br>
            <textarea id="descripcion" name="descripcion"></textarea><br><br>
            <label for="precio">Precio:</label><br>
            <input type="number" id="precio" name="precio" step="0.01"><br><br>
            <label for="cantidad">Cantidad:</label><br>
            <input type="number" id="cantidad" name="cantidad"><br><br>
            <label for="imagen">Imagen:</label><br>
            <input type="file" id="imagen" name="imagen"><br><br>
            <input type="submit" name="submit" value="Agregar">
        </form>
    </div>
</div>
<div class="orden-info">
    <?php mostrarDireccionOrden($order_by, $order); ?>
</div>
<table border="1" id="product-table">
    <thead>
        <tr>
            <th>ID Producto</th>
            <th>Nombre Producto</th>
            <th>Descripción Producto</th>
            <th>Precio Producto</th>
            <th>Cantidad Producto</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="product-table-body">
    <?php
    function renderProducts($result) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_producto"] . "</td>";
            echo "<td>" . $row["nombre_producto"] . "</td>";
            echo "<td>" . $row["descripcion_producto"] . "</td>";
            echo "<td>" . $row["precio_producto"] . "</td>";
            echo "<td>" . $row["cantidad_producto"] . "</td>";
            echo "<td><img src='" . $row["imagen_producto"] . "' alt='Imagen del producto' style='width:100px;height:100px;'></td>";
            echo "<td>
                    <form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' style='display:inline-block;'>
                        <input type='hidden' name='id_producto' value='" . $row["id_producto"] . "'>
                        <input type='hidden' name='cantidad_disponible' value='" . $row["cantidad_producto"] . "'>
                        <button type='button' class='delete-button' onclick='openDeleteModal(" . $row["id_producto"] . ", \"" . $row["nombre_producto"] . "\", " . $row["cantidad_producto"] . ")'>Eliminar</button>
                    </form>
                    <button type='button' onclick='openEditModal(" . $row["id_producto"] . ", \"" . $row["nombre_producto"] . "\", \"" . $row["descripcion_producto"] . "\", " . $row["precio_producto"] . ", " . $row["cantidad_producto"] . ", \"" . $row["imagen_producto"] . "\")' class='edit-button'>Editar</button>
                  </td>";
            echo "</tr>";
        }
    }
    renderProducts($result);
    ?>
    </tbody>
</table>
</body>
</html>