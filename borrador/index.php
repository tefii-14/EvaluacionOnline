<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario Dinámico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #d4f1f4, #d9e4dd);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }
        .form-title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .question {
            margin-bottom: 15px;
        }
        .question label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .options {
            display: flex;
            gap: 10px;
        }
        .options input[type="radio"] {
            accent-color: #0a66c2; /* Azul Microsoft Forms */
        }
        button {
            background-color: #0a66c2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #084a92;
        }
        #resultado {
            margin-top: 20px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">Cuestionario Dinámico</h1>

        <form id="cuestionario">
            <!-- Área donde se agregarán las preguntas -->
            <div id="preguntas"></div>

            <!-- Botones de acción -->
            <button type="button" onclick="agregarPregunta()">Agregar Pregunta</button>
            <button type="button" onclick="procesarRespuestas()">Enviar</button>
        </form>

        <p id="resultado"></p>
    </div>

    <script>
        let contadorPreguntas = 0;
        const respuestasCorrectas = {}; // Objeto para almacenar las respuestas correctas de cada pregunta

        // Función para agregar una nueva pregunta
        function agregarPregunta() {
            contadorPreguntas++;
            const preguntasDiv = document.getElementById('preguntas');
            
            // Crear el contenedor de la pregunta
            const questionDiv = document.createElement('div');
            questionDiv.classList.add('question');
            questionDiv.id = `pregunta${contadorPreguntas}`;

            // Crear el título de la pregunta
            const preguntaLabel = document.createElement('label');
            preguntaLabel.textContent = `Pregunta ${contadorPreguntas}:`;
            questionDiv.appendChild(preguntaLabel);

            // Crear el campo de texto para ingresar la pregunta
            const inputPregunta = document.createElement('input');
            inputPregunta.type = 'text';
            inputPregunta.placeholder = 'Escribe tu pregunta aquí';
            inputPregunta.required = true;
            questionDiv.appendChild(inputPregunta);

            // Crear opciones de respuesta
            const opcionesDiv = document.createElement('div');
            opcionesDiv.classList.add('options');
            opcionesDiv.innerHTML = `
                <label><input type="radio" name="respuesta${contadorPreguntas}" value="Sí" required> Sí</label>
                <label><input type="radio" name="respuesta${contadorPreguntas}" value="No" required> No</label>
            `;
            questionDiv.appendChild(opcionesDiv);

            // Crear selector para elegir la respuesta correcta
            const correctaLabel = document.createElement('label');
            correctaLabel.textContent = 'Selecciona la respuesta correcta: ';
            const selectCorrecta = document.createElement('select');
            selectCorrecta.id = `correcta${contadorPreguntas}`;
            selectCorrecta.innerHTML = `
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            `;
            questionDiv.appendChild(correctaLabel);
            questionDiv.appendChild(selectCorrecta);

            // Agregar la pregunta al formulario
            preguntasDiv.appendChild(questionDiv);
        }

        // Función para procesar las respuestas y mostrar el resultado
        function procesarRespuestas() {
            const resultadoDiv = document.getElementById('resultado');
            let puntaje = 0;

            for (let i = 1; i <= contadorPreguntas; i++) {
                const respuestaSeleccionada = document.querySelector(`input[name="respuesta${i}"]:checked`);
                const respuestaCorrecta = document.getElementById(`correcta${i}`).value;

                if (respuestaSeleccionada && respuestaSeleccionada.value === respuestaCorrecta) {
                    puntaje++;
                }
            }

            resultadoDiv.textContent = `Tu puntaje es: ${puntaje} de ${contadorPreguntas}`;
        }
    </script>
</body>
</html>
