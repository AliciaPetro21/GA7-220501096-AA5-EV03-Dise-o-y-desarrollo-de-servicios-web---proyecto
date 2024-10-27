<?php
// Conexión a la base de datos
include 'conexion.php'; // Asegúrate de que 'conexion.php' esté bien configurado

// Verificar que el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    // Verificar que los campos no estén vacíos
    if (empty($usuario) || empty($contrasena)) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Comprobar si el usuario ya existe en la base de datos
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Error: El usuario ya existe.'); window.location.href = 'index.html';</script>";
    } else {
        // Registrar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)");
        // Encriptar la contraseña antes de almacenarla
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $usuario, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso.'); window.location.href = 'index.html';</script>";
        } else {
            echo "<script>alert('Error en el registro: " . $stmt->error . "'); window.location.href = 'index.html';</script>";
        }
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

