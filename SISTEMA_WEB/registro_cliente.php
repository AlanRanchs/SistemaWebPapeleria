<?php
include "modelo/conexion.php";

if (!empty($_POST["nombre_cliente"]) && !empty($_POST["email_cliente"]) && !empty($_POST["clave_cliente"]) && !empty($_POST["telefono_cliente"])) {
    $nombre_cliente = htmlspecialchars($_POST["nombre_cliente"]);
    $email_cliente = htmlspecialchars($_POST["email_cliente"]);
    $clave_cliente = htmlspecialchars($_POST["clave_cliente"]);
    $telefono_cliente = htmlspecialchars($_POST["telefono_cliente"]);

    // Verificar si el correo ya está registrado
    $sql_check_email = $conexion->prepare("SELECT * FROM clientes WHERE email_cliente = ?");
    if (!$sql_check_email) {
        die("Error en la preparación de la consulta de verificación: " . $conexion->error);
    }
    $sql_check_email->bind_param("s", $email_cliente);
    $sql_check_email->execute();
    $result_check_email = $sql_check_email->get_result();

    if ($result_check_email->num_rows > 0) {
        echo "<script>
                alert('Correo ya está en uso');
                window.location.href = 'iniciosesion.php';
              </script>";
    } else {
        // Verificar si el usuario está en la tabla de clientes baneados
        $sql_check_ban = $conexion->prepare("SELECT * FROM clientes_baneados WHERE email_cliente = ?");
        if (!$sql_check_ban) {
            die("Error en la preparación de la consulta de verificación: " . $conexion->error);
        }
        $sql_check_ban->bind_param("s", $email_cliente);
        $sql_check_ban->execute();
        $result_check_ban = $sql_check_ban->get_result();

        if ($result_check_ban->num_rows > 0) {
            echo "<script>
                    alert('El usuario está bloqueado');
                    window.location.href = 'iniciosesion.php';
                  </script>";
        } else {
            // Insertar el nuevo usuario en la tabla de clientes
            $hashed_password = password_hash($clave_cliente, PASSWORD_DEFAULT);
            $sql = $conexion->prepare("INSERT INTO clientes (nombre_cliente, email_cliente, clave_cliente, telefono_cliente) VALUES (?, ?, ?, ?)");
            if (!$sql) {
                die("Error en la preparación de la consulta de inserción: " . $conexion->error);
            }
            $sql->bind_param("ssss", $nombre_cliente, $email_cliente, $hashed_password, $telefono_cliente);

            if ($sql->execute()) {
                echo "<script>
                        alert('Registro correcto');
                        window.location.href = 'iniciosesion.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Error en el registro');
                        window.location.href = 'iniciosesion.php';
                      </script>";
            }
        }
    }
} else {
    echo "<script>
            alert('Campos vacíos');
            window.location.href = 'iniciosesion.php';
          </script>";
}
?>





