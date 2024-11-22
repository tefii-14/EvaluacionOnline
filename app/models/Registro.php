<?php
// Conexión a la base de datos con PDO
$dsn = "mysql:host=localhost;dbname=dbevaluacion;charset=utf8mb4";
$username = "root";
$password = ""; // Cambia si tu contraseña es distinta

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $fechanac = $_POST['fechanac'];
    $telefono = $_POST['telefono'];
    $nombreusuario = $_POST['nombreusuario'];
    $claveacceso = password_hash($_POST['claveacceso'], PASSWORD_BCRYPT); // Hashear contraseña
    $rol = $_POST['rol']; // ID del rol seleccionado

    try {
        // Iniciar transacción
        $conn->beginTransaction();

        // Insertar datos en la tabla Personas
        $query_persona = "INSERT INTO Personas (apellidos, nombres, dni, fechanac, telefono) VALUES (?, ?, ?, ?, ?)";
        $stmt_persona = $conn->prepare($query_persona);
        $stmt_persona->execute([$apellidos, $nombres, $dni, $fechanac, $telefono]);
        $idpersona = $conn->lastInsertId();

        // Insertar datos en la tabla Usuarios
        $query_usuario = "INSERT INTO Usuarios (idpersona, idrol, nombreusuario, claveacceso, nivelacceso) VALUES (?, ?, ?, ?, 1)";
        $stmt_usuario = $conn->prepare($query_usuario);
        $stmt_usuario->execute([$idpersona, $rol, $nombreusuario, $claveacceso]);

        // Confirmar transacción
        $conn->commit();
        echo "<p>Usuario registrado exitosamente.</p>";
    } catch (PDOException $e) {
        // Revertir transacción en caso de error
        $conn->rollBack();
        echo "<p>Error al registrar usuario: " . $e->getMessage() . "</p>";
    }
}
?>
