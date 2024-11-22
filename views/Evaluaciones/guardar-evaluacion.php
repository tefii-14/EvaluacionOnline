<?php
require_once '../../app/models/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados desde el formulario
    $tituloFormulario = $_POST['titulo']; // Título del formulario
    $preguntas = json_decode($_POST['preguntas'], true); // Decodificar JSON de preguntas

    // Establecer conexión
    $conexion = Conexion::getConexion();

    try {
        // Iniciar una transacción para asegurar la integridad de los datos
        $conexion->beginTransaction();

        // Insertar los datos en la tabla 'Evaluaciones'
        $queryEvaluacion = "INSERT INTO Evaluaciones (idcategoria, idusuario, fechainicio, fechafin, comentarios, tiempodesarrollo)
                            VALUES (:idcategoria, :idusuario, :fechainicio, :fechafin, :comentarios, :tiempodesarrollo)";
        $stmtEvaluacion = $conexion->prepare($queryEvaluacion);
        $stmtEvaluacion->execute([
            ':idcategoria' => 1,  // Cambia esto según sea necesario
            ':idusuario' => 1,    // Cambia esto según el usuario actual
            ':fechainicio' => date('Y-m-d H:i:s'),
            ':fechafin' => date('Y-m-d H:i:s', strtotime('+1 day')), // Ejemplo de fecha fin
            ':comentarios' => 'Formulario generado dinámicamente.',
            ':tiempodesarrollo' => 60, // Ejemplo de tiempo
        ]);
        $idEvaluacion = $conexion->lastInsertId(); // Obtener el id de la evaluación insertada

        // Insertar las preguntas
        foreach ($preguntas as $pregunta) {
            if (!isset($pregunta['titulo']) || !isset($pregunta['alternativas'])) {
                throw new Exception('Datos de pregunta incompletos.');
            }

            $queryPregunta = "INSERT INTO Preguntas (idevaluacion, titulo, puntaje)
                              VALUES (:idevaluacion, :titulo, :puntaje)";
            $stmtPregunta = $conexion->prepare($queryPregunta);
            $stmtPregunta->execute([
                ':idevaluacion' => $idEvaluacion,
                ':titulo' => $pregunta['titulo'],
                ':puntaje' => 10,  // Puntaje para cada pregunta
            ]);
            $idPregunta = $conexion->lastInsertId(); // Obtener el id de la pregunta insertada

            // Insertar las alternativas
            foreach ($pregunta['alternativas'] as $alternativa) {
                if (!isset($alternativa['texto']) || !isset($alternativa['correcta'])) {
                    throw new Exception('Datos de alternativa incompletos.');
                }

                $queryAlternativa = "INSERT INTO Alternativas (idpregunta, alternativa, escorrecto)
                                     VALUES (:idpregunta, :alternativa, :escorrecto)";
                $stmtAlternativa = $conexion->prepare($queryAlternativa);
                $stmtAlternativa->execute([
                    ':idpregunta' => $idPregunta,
                    ':alternativa' => $alternativa['texto'],
                    ':escorrecto' => $alternativa['correcta'] ? 1 : 0,
                ]);
            }
        }

        // Commit de la transacción
        $conexion->commit();
        echo "Formulario guardado correctamente.";

    } catch (Exception $e) {
        // Rollback en caso de error
        $conexion->rollBack();
        echo "Error al guardar el formulario: " . $e->getMessage();
    }
}
?>