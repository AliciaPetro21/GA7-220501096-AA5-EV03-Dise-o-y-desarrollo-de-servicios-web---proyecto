<?php 
include 'conexion.php'; // Incluir la conexión a la base de datos

// Comprobar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario y sanitizarlos
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']); 

    // Verificar que los campos no estén vacíos
    if (empty($usuario) || empty($contrasena)) {
        echo "<script>alert('Error: Todos los campos son obligatorios.'); window.location.href = 'login.html';</script>";
        exit();
    }

    // Comprobar si el usuario existe
    $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si el usuario existe, obtenemos la contraseña hash almacenada
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verificamos la contraseña ingresada con el hash almacenado
        if (password_verify($contrasena, $hashed_password)) {
            echo "<script>alert('Autenticación satisfactoria. ¡Bienvenido!'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Error: Contraseña incorrecta.'); window.location.href = 'login.html';</script>";
        }
    } else {
        echo "<script>alert('Error: El usuario no existe.'); window.location.href = 'login.html';</script>";
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>


