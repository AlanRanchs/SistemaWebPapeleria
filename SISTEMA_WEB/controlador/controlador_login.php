<?php
session_start();
if (!empty($_POST["btningresar"])){
   if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    
    // Asumiendo que $conexion es tu conexión a la base de datos
    $sql = $conexion->query("SELECT * FROM usuario WHERE usuario_usuario='$usuario' AND clave_usuario='$password'");
    
    if ($datos = $sql->fetch_object()) {
        $_SESSION["id"] = $datos->id_usuario;
        $_SESSION["nombre"] = $datos->nombre_usuario;
        $_SESSION["apellido"] = $datos->apellido_usuario;
        header("Location: inicio.php");
    } else {
        echo "<div class='alert alert-danger'>Acceso denegado</div>";
    }
    
   } else {
    echo "Campos vacíos";
   }
}
?>
