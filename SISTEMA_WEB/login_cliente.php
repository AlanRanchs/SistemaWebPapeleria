<?php
session_start();
include "modelo/conexion.php";

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if (!empty($_POST["email_cliente"]) && !empty($_POST["clave_cliente"])) {
    $email_cliente = $conexion->real_escape_string($_POST["email_cliente"]);
    $clave_cliente = $conexion->real_escape_string($_POST["clave_cliente"]);
    
    // Preparar la consulta para la tabla 'clientes'
    $sql = $conexion->prepare("SELECT * FROM clientes WHERE email_cliente=?");
    if (!$sql) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }
    
    $sql->bind_param("s", $email_cliente);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $datos = $result->fetch_object();
        // Validar la contraseña
        if (password_verify($clave_cliente, $datos->clave_cliente)) {
            $_SESSION["id_cliente"] = $datos->id_cliente;
            $_SESSION["nombre_cliente"] = $datos->nombre_cliente;
            header("Location: index.php");
        } else {
            header("Location: iniciosesion.php?error=Credenciales incorrectas");
        }
    } else {
        header("Location: iniciosesion.php?error=Credenciales incorrectas");
    }
} else {
    header("Location: iniciosesion.php?error=Campos vacíos");
}
?>