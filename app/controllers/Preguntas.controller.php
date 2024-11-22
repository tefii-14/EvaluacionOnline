<?php
// Conexión a la base de datos con PDO
$dsn = "mysql:host=localhost;dbname=dbevaluacion;charset=utf8mb4"; // Cambia "localhost" y "dbevaluacion" si es necesario
$username = "root"; // Cambia por tu usuario de MySQL
$password = ""; // Cambia por tu contraseña de MySQL

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir datos del formulario
    $idcategoria = $_POST['idcategoria']; // Este campo debe venir del combo de "Tema"
    $titulo = $_POST['pregunta'];
    $opcionA = $_POST['opcion_a'];
    $opcionB = $_POST['opcion_b'];
    $opcionC = $_POST['opcion_c'];
    $correcta = $_POST['correcta'];

    try {
        // Iniciar una transacción
        $conn->beginTransaction();

        // Insertar la pregunta
        $query_pregunta = "INSERT INTO Preguntas (idevaluacion, titulo, puntaje) VALUES (1, ?, 10)";
        $stmt_pregunta = $conn->prepare($query_pregunta);
        $stmt_pregunta->execute([$titulo]);
        $idpregunta = $conn->lastInsertId(); // Obtener el ID de la pregunta insertada

        // Insertar las alternativas
        $query_alternativa = "INSERT INTO Alternativas (idpregunta, alternativa, escorrecto) VALUES (?, ?, ?)";
        $stmt_alternativa = $conn->prepare($query_alternativa);

        $alternativas = [
            [$opcionA, ($correcta == 'A') ? 1 : 0],
            [$opcionB, ($correcta == 'B') ? 1 : 0],
            [$opcionC, ($correcta == 'C') ? 1 : 0],
        ];

        foreach ($alternativas as $alt) {
            $stmt_alternativa->execute([$idpregunta, $alt[0], $alt[1]]);
        }

        // Confirmar la transacción
        $conn->commit();

        echo "<p style='color:green;'>Pregunta y alternativas guardadas correctamente.</p>";
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $conn->rollBack();
        echo "<p style='color:red;'>Error al guardar los datos: " . $e->getMessage() . "</p>";
    }
}
?>