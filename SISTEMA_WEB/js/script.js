// Obtiene el nombre de usuario y el botón de cerrar sesión por su ID
const username = document.getElementById('username');
const logoutButton = document.getElementById('logout-button');

// Agrega un evento de clic al nombre de usuario
username.addEventListener('click', function() {
    // Redirige a la página de cerrar sesión al hacer clic en el nombre de usuario
    window.location.href = 'controlador/controlador_cerrar_sesion.php';
});
