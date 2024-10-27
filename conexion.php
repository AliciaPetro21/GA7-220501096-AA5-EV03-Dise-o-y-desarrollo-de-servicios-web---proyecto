<?php
$servername = "127.0.0.1"; // Dirección del servidor
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // En XAMPP, el usuario root por defecto no tiene contraseña
$dbname = "conexion"; // Asegúrate de que este sea el nombre correcto de tu base de datos
$port = "3306"; // Puerto de MySQL

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar la conexión y mostrar mensajes de éxito o error
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos";
}
?>
