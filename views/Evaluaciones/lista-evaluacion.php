<?php
//require_once '../Evaluaciones/guardarEvaluacion.php'; // Descomenta si necesitas guardar datos
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Dinámico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 18px;
            color: #333;
            margin: 0;
        }

        .header .opciones button {
            border: none;
            background-color: #007BFF;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .header .opciones button:hover {
            background-color: #0056b3;
        }

        .formulario {
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        .formulario input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .pregunta {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .pregunta label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .opciones .opcion {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .opciones .opcion input[type="radio"] {
            margin-right: 10px;
        }

        .opciones .opcion input[type="text"] {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .agregar-pregunta,
        .guardar-btn {
            display: block;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            text-align: center;
        }

        .agregar-pregunta:hover,
        .guardar-btn:hover {
            background-color: #45a049;
        }

        .agregar-opcion {
            margin-top: 10px;
            padding: 5px 10px;
            font-size: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .agregar-opcion:hover {
            background-color: #0056b3;
        }

        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            text-align: center;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            color: black;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        #form-link {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #copiar-link {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #copiar-link:hover {
            background-color: #0056b3;
        }
        .opciones-recopilar {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin: 20px 0;
        }

        .opcion-recopilar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
        }

        .opcion-recopilar span {
            font-size: 24px;
        }

        .opcion-recopilar:hover {
            background-color: #e0e0e0;
        }

        /* Estilos para vista móvil */
        .modo-movil {
            max-width: 375px;
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para vista PC */
        .modo-pc {
            max-width: 800px;
            margin: 20px auto;
            box-shadow: none;
            border: none;
        }


    </style>
</head>

<body>
    <!-- Parte superior -->
    <div class="header">
        <h1>Formulario de Evaluación</h1>
        <div class="opciones">
            <button>Ver respuestas</button>
            <button class="vista-previa">Vista previa</button>
            <button id="recopilar-respuestas-btn">Recopilar respuestas</button>
        </div>
    </div>

    <!-- Formulario -->
    <div class="formulario">
        <input type="text" name="titulo" placeholder="Título del formulario" required>

        <div class="pregunta-container">
            <!-- Contenedor dinámico de preguntas -->
        </div>

        <button class="agregar-pregunta">+ Agregar nueva pregunta</button>
        <button class="guardar-btn">Guardar</button>
    </div>

    <!-- Modal para recopilar respuestas -->
    <div id="modal-recuperar-respuestas" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Recopilar Respuestas</h2>
            <p>Elige una opción para recopilar las respuestas:</p>
            <div class="opciones-recopilar">
                <div class="opcion-recopilar">
                    <span>📋</span>
                    <p>Ver respuestas en un archivo</p>
                </div>
                <div class="opcion-recopilar">
                    <span>🔗</span>
                    <p>Compartir enlace del formulario</p>
                </div>
                <div class="opcion-recopilar">
                    <span>📊</span>
                    <p>Visualizar estadísticas</p>
                </div>
            </div>
            <input type="text" id="form-link" value="https://forms.office.com/personalizado" readonly>
            <button id="copiar-link">Copiar Enlace</button>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const agregarPreguntaBtn = document.querySelector('.agregar-pregunta');
            const guardarBtn = document.querySelector('.guardar-btn');
            const preguntaContainer = document.querySelector('.pregunta-container');
            const modal = document.getElementById('modal-recuperar-respuestas');
            const recopilarRespuestasBtn = document.getElementById('recopilar-respuestas-btn');
            const closeModalBtn = modal.querySelector('.close');
            const copiarLinkBtn = document.getElementById('copiar-link');
            const formLink = document.getElementById('form-link');
            let contadorPreguntas = 1;

            // Mostrar el modal al hacer clic en "Recopilar respuestas"
            recopilarRespuestasBtn.addEventListener('click', function () {
                modal.style.display = 'block';
            });

            // Cerrar el modal al hacer clic en la "X"
            closeModalBtn.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            // Copiar enlace al portapapeles
            copiarLinkBtn.addEventListener('click', function () {
                formLink.select();
                document.execCommand('copy');
                alert('Enlace copiado al portapapeles');
            });

            // Cerrar el modal si el usuario hace clic fuera del contenido
            window.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Función para agregar una nueva pregunta
            agregarPreguntaBtn.addEventListener('click', function () {
                const preguntaDiv = document.createElement('div');
                preguntaDiv.classList.add('pregunta');
                preguntaDiv.innerHTML = `
                    <label>Pregunta ${contadorPreguntas}</label>
                    <input type="text" name="pregunta_${contadorPreguntas}" placeholder="Escribe tu pregunta" required>
                    <div class="opciones">
                        <div class="opcion">
                            <input type="radio" name="respuesta_${contadorPreguntas}">
                            <input type="text" name="opcion_${contadorPreguntas}[]" placeholder="Escribe una opción" required>
                        </div>
                    </div>
                    <button class="agregar-opcion">+ Agregar opción</button>
                `;

                const agregarOpcionBtn = preguntaDiv.querySelector('.agregar-opcion');
                agregarOpcionBtn.addEventListener('click', function () {
                    const opcionDiv = document.createElement('div');
                    opcionDiv.classList.add('opcion');
                    opcionDiv.innerHTML = `
                        <input type="radio" name="respuesta_${contadorPreguntas}">
                        <input type="text" name="opcion_${contadorPreguntas}[]" placeholder="Escribe una opción" required>
                    `;
                    preguntaDiv.querySelector('.opciones').appendChild(opcionDiv);
                });

                preguntaContainer.appendChild(preguntaDiv);
                contadorPreguntas++;
            });

            // Guardar formulario
            guardarBtn.addEventListener('click', function () {
                alert('Formulario guardado correctamente.');
            });
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const vistaPreviaBtn = document.querySelector('.vista-previa');
        const formularioContainer = document.querySelector('.formulario');

        vistaPreviaBtn.addEventListener('click', function () {
            // Crear el modal de vista previa
            const modalVistaPrevia = document.createElement('div');
            modalVistaPrevia.style.position = 'fixed';
            modalVistaPrevia.style.top = '0';
            modalVistaPrevia.style.left = '0';
            modalVistaPrevia.style.width = '100%';
            modalVistaPrevia.style.height = '100%';
            modalVistaPrevia.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            modalVistaPrevia.style.zIndex = '1000';
            modalVistaPrevia.style.display = 'flex';
            modalVistaPrevia.style.justifyContent = 'center';
            modalVistaPrevia.style.alignItems = 'center';

            // Contenedor de contenido dentro del modal
            const vistaPreviaContent = document.createElement('div');
            vistaPreviaContent.style.backgroundColor = '#fff';
            vistaPreviaContent.style.borderRadius = '8px';
            vistaPreviaContent.style.padding = '20px';
            vistaPreviaContent.style.width = '90%';
            vistaPreviaContent.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
            vistaPreviaContent.style.overflowY = 'auto';
            vistaPreviaContent.style.maxHeight = '90%';

            // Agregar el formulario clonado al modal
            const formularioClone = formularioContainer.cloneNode(true);
            formularioClone.style.margin = '0';
            formularioClone.querySelector('.guardar-btn').style.display = 'none'; // Ocultar el botón "Guardar"
            vistaPreviaContent.appendChild(formularioClone);

            // Contenedor para el selector de vista y botón de cierre
            const opcionesVista = document.createElement('div');
            opcionesVista.style.display = 'flex';
            opcionesVista.style.justifyContent = 'space-between';
            opcionesVista.style.alignItems = 'center';
            opcionesVista.style.marginBottom = '20px';

            // Selector para cambiar entre Vista PC y Vista Móvil
            const modoVistaSelect = document.createElement('select');
            modoVistaSelect.innerHTML = `
                <option value="pc">Vista PC</option>
                <option value="movil">Vista Móvil</option>
            `;
            modoVistaSelect.style.padding = '5px';
            modoVistaSelect.style.marginRight = 'auto';

            // Escuchar el cambio del selector
            modoVistaSelect.addEventListener('change', function () {
                if (modoVistaSelect.value === 'movil') {
                    vistaPreviaContent.style.maxWidth = '375px';
                    vistaPreviaContent.style.border = '1px solid #ccc';
                } else {
                    vistaPreviaContent.style.maxWidth = '800px';
                    vistaPreviaContent.style.border = 'none';
                }
            });

            // Botón de cierre del modal
            const closeButton = document.createElement('button');
            closeButton.textContent = 'Cerrar Vista Previa';
            closeButton.style.padding = '10px 20px';
            closeButton.style.backgroundColor = '#007BFF';
            closeButton.style.color = '#fff';
            closeButton.style.border = 'none';
            closeButton.style.borderRadius = '4px';
            closeButton.style.cursor = 'pointer';

            closeButton.addEventListener('click', function () {
                modalVistaPrevia.remove();
            });

            opcionesVista.appendChild(modoVistaSelect);
            opcionesVista.appendChild(closeButton);
            vistaPreviaContent.prepend(opcionesVista);

            modalVistaPrevia.appendChild(vistaPreviaContent);
            document.body.appendChild(modalVistaPrevia);
        });
    });
</script>



</body>

</html>
