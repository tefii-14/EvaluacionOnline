<?php
// Incluir la clase de conexión
//require_once '../Evaluaciones/guardarEvaluacion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Preguntas</title>
    <link rel="stylesheet" href="../../dist/css/styles.css">
    <style>
        /* Estilos adicionales para hacer que el formulario sea más ancho */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .formulario {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            /* Haciendo el formulario más ancho */
            max-width: 900px;
            /* Máximo ancho de 900px */
            margin: auto;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .pregunta-container {
            margin-top: 20px;
        }

        .pregunta {
            margin-bottom: 20px;
        }

        .opciones {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .opcion {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .opcion input[type="text"] {
            flex: 1;
            margin-left: 10px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            /* Botones más pequeños */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 12px;
            /* Fuente más pequeña */
            width: auto;
            /* Ajusta el ancho solo al contenido */
        }

        button:hover {
            background-color: #45a049;
        }

        .botones {
            text-align: left;
            /* Alineando los botones a la izquierda */
            margin-left: 0;
            /* Asegura que el contenedor no ocupe todo el ancho */
        }

        .guardar-btn {
            background-color: #007BFF;
            /* Color azul para el botón de guardar */
            margin-top: 20px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Alineación del botón "Agregar opción" a la derecha */
        .agregar-opcion-container {
            display: flex;
            justify-content: flex-end;
            /* Alinea el botón a la derecha */
            margin-top: 10px;
        }

        .agregar-opcion {
            background-color: #007BFF;
            /* Color azul */
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="formulario">
        <input type="text" name="Titulo" placeholder="Formulario sin título" required>

        <div class="pregunta-container">
            <!-- Las preguntas se agregarán aquí dinámicamente -->
        </div>

        <div class="botones">
            <button class="agregar-pregunta">+ Agregar nueva pregunta</button>
            <button class="guardar-btn">Guardar todo</button>
        </div>

        <div class="error" style="display: none;"></div> <!-- Mensaje de error -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const agregarPreguntaBtn = document.querySelector('.agregar-pregunta');
            const guardarBtn = document.querySelector('.guardar-btn');
            const preguntaContainer = document.querySelector('.pregunta-container');
            const errorDiv = document.querySelector('.error'); // Elemento para mostrar errores

            // Variable para almacenar las preguntas y sus alternativas
            let preguntasFormulario = [];
            let contadorPreguntas = 1; // Contador para las preguntas

            // Agregar nueva pregunta
            agregarPreguntaBtn.addEventListener('click', function() {
                const nuevaPregunta = document.createElement('div');
                nuevaPregunta.classList.add('pregunta');
                nuevaPregunta.innerHTML = `
            <label for="pregunta">Pregunta ${contadorPreguntas}</label>
            <input type="text" name="pregunta" placeholder="Escribe la pregunta" required>
            <div class="opciones">
                <div class="opcion">
                    <input type="radio" name="respuesta" id="respuesta">
                    <input type="text" name="opcion" placeholder="Escribe una opción" required>
                </div>
                <div class="opcion">
                    <input type="radio" name="respuesta" id="respuesta">
                    <input type="text" name="opcion" placeholder="Escribe una opción" required>
                </div>
            </div>
            <div class="agregar-opcion-container">
                <button class="agregar-opcion">+ Agregar opción</button>
            </div>
        `;
                preguntaContainer.appendChild(nuevaPregunta);

                // Incrementar el contador para la siguiente pregunta
                contadorPreguntas++;

                // Agregar funcionalidad al botón "Agregar opción" dentro de la nueva pregunta
                const agregarOpcionBtn = nuevaPregunta.querySelector('.agregar-opcion');
                agregarOpcionBtn.addEventListener('click', function() {
                    const nuevaOpcion = document.createElement('div');
                    nuevaOpcion.classList.add('opcion');
                    nuevaOpcion.innerHTML = `
                <input type="radio" name="respuesta" id="respuesta">
                <input type="text" name="opcion" placeholder="Escribe una opción" required>
            `;
                    nuevaPregunta.querySelector('.opciones').appendChild(nuevaOpcion);
                });
            });

            // Función para validar campos vacíos
            function validarCampos() {
                const preguntas = document.querySelectorAll('.pregunta');
                for (let pregunta of preguntas) {
                    const preguntaTexto = pregunta.querySelector('input[name="pregunta"]').value.trim();
                    if (preguntaTexto === '') {
                        errorDiv.textContent = 'Por favor, completa todas las preguntas.';
                        errorDiv.style.display = 'block'; // Mostrar el mensaje de error
                        return false;
                    }

                    const opciones = pregunta.querySelectorAll('.opcion input[type="text"]');
                    for (let opcion of opciones) {
                        const opcionTexto = opcion.value.trim();
                        if (opcionTexto === '') {
                            errorDiv.textContent = 'Por favor, completa todas las opciones.';
                            errorDiv.style.display = 'block'; // Mostrar el mensaje de error
                            return false;
                        }
                    }
                }

                errorDiv.style.display = 'none';
                return true;
            }

            // Función para guardar el formulario
            guardarBtn.addEventListener('click', function() {
                const isValid = validarCampos();

                if (isValid) {
                    const preguntas = document.querySelectorAll('.pregunta');
                    preguntasFormulario = []; // Limpiar el arreglo de preguntas

                    preguntas.forEach(pregunta => {
                        const preguntaTexto = pregunta.querySelector('input[name="pregunta"]').value;
                        const opciones = pregunta.querySelectorAll('.opcion input[type="text"]');
                        let opcionesData = [];

                        opciones.forEach(opcion => {
                            opcionesData.push({
                                texto: opcion.value,
                                correcta: false
                            }); // Aquí puedes definir lógica para marcar las correctas
                        });

                        preguntasFormulario.push({
                            titulo: preguntaTexto,
                            alternativas: opcionesData
                        });
                    });

                    // Enviar los datos al servidor usando fetch
                    fetch('guardar-evaluacion.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                'titulo': document.querySelector('input[name="Titulo"]').value,
                                'preguntas': JSON.stringify(preguntasFormulario),
                            })
                        })
                        .then(response => response.text())
                        .then(data => {
                            alert(data); // Mostrar el resultado de la operación
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
    </script>

    </script>
</body>

</html>