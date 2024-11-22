<?php
// Conexión a la base de datos usando PDO
require_once "./app/config/App.php"; // Ruta a tu archivo de conexión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar datos del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $fechanac = $_POST['fechanac'];
    $telefono = $_POST['telefono'];
    $username = $_POST['nombreusuario'];
    $password = password_hash($_POST['claveacceso'], PASSWORD_DEFAULT); // Encriptar contraseña
    $rol = $_POST['rol']; // Asumimos que "rol" corresponde a id_rol

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO Usuarios (id_rol, username, passuser, nombres, apellidos, dni, fechanac, telefono, create_at)
            VALUES (:rol, :username, :password, :nombres, :apellidos, :dni, :fechanac, :telefono, NOW())";
    
    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Asignar los valores a los parámetros de la consulta
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':fechanac', $fechanac);
    $stmt->bindParam(':telefono', $telefono);

    // Ejecutar la consulta
    try {
        $stmt->execute();
        // Redirigir a la página principal después de registrar
        header("Location: ../index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error al registrar usuario: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="<?= SERVERURL ?>dist/css/styles.css"> <!-- Asegúrate de enlazar tu archivo CSS -->
</head>
<body>
    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        <form method="POST" action="registro.php">
            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required>

            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required>

            <label for="fechanac">Fecha de Nacimiento:</label>
            <input type="date" id="fechanac" name="fechanac" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="nombreusuario">Nombre de Usuario:</label>
            <input type="text" id="nombreusuario" name="nombreusuario" required>

            <label for="claveacceso">Contraseña:</label>
            <input type="password" id="claveacceso" name="claveacceso" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="1">Instructor</option>
                <option value="2">Alumno</option>
                <option value="3">Invitado</option>
            </select>

            <button type="submit">Registrar</button>
        </form>
        <p><a href="./index.php">¿Ya tienes cuenta? Inicia sesión</a></p>
    </div>
</body>
</html>
