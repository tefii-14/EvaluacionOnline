<?php
session_start(); // Crea o hereda la sesión

require_once "../models/Usuario.php";
$usuario = new Usuario();

// Arreglo de accesos según el rol
// Arreglo de accesos según el rol
$accesos = [
  "Administrador" => [
    ["modulo" => "home", "ruta" => "welcome", "visible" => false, "texto" => "", "icono" => ""],
    ["modulo" => "alternativas", "ruta" => "lista-alternativa", "visible" => true, "texto" => "Alternativas", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "categorias", "ruta" => "lista-categoria", "visible" => true, "texto" => "Categorias", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "evaluaciones", "ruta" => "lista-evaluacion ", "visible" => true, "texto" => "Evaluaciones", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "inicio", "ruta" => "lista-inicio", "visible" => true, "texto" => "Inicio", "icono" => "nav-icon fas fa-th"],

    ["modulo" => "preguntas", "ruta" => "lista-pregunta", "visible" => true, "texto" => "Preguntas", "icono" => "nav-icon fas fa-th"],
    //["modulo" => "preguntas", "ruta" => "lista-pregunta", "visible" => true, "texto" => "Preguntas", "icono" => "nav-icon fas fa-th"],

    ["modulo" => "resultados", "ruta" => "lista-resultado", "visible" => true, "texto" => "Resultados", "icono" => "nav-icon fas fa-th"],

    ["modulo" => "usuarios", "ruta" => "lista-usuario", "visible" => true, "texto" => "Usuarios", "icono" => "nav-icon fas fa-th"],
    //["modulo" => "usuarios", "ruta" => "registra-usuario", "visible" => true, "texto" => "Usuarios", "icono" => "nav-icon fas fa-th"],
    // Otros accesos para "Administrador"
  ],
  "Instructor" => [
    ["modulo" => "home", "ruta" => "welcome", "visible" => false, "texto" => "", "icono" => ""],
    ["modulo" => "alternativas", "ruta" => "lista-alternativa", "visible" => true, "texto" => "Alternativas", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "categorias", "ruta" => "lista-categoria", "visible" => true, "texto" => "Categorias", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "evaluaciones", "ruta" => "lista-evaluacion ", "visible" => true, "texto" => "Evaluaciones", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "inicio", "ruta" => "lista-inicio", "visible" => true, "texto" => "Inicio", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "preguntas", "ruta" => "lista-pregunta", "visible" => true, "texto" => "Preguntas", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "resultados", "ruta" => "lista-resultado", "visible" => true, "texto" => "Resultados", "icono" => "nav-icon fas fa-th"],
    // Otros accesos para "Instructor"
  ],
  "Alumno" => [
    ["modulo" => "home", "ruta" => "welcome", "visible" => false, "texto" => "", "icono" => ""],
    ["modulo" => "evaluaciones", "ruta" => "lista-evaluacion ", "visible" => true, "texto" => "Evaluaciones", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "inicio", "ruta" => "lista-inicio", "visible" => true, "texto" => "Inicio", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "preguntas", "ruta" => "lista-pregunta", "visible" => true, "texto" => "Preguntas", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "resultados", "ruta" => "lista-resultado", "visible" => true, "texto" => "Resultados", "icono" => "nav-icon fas fa-th"],
    // Otros accesos para "Alumno"
  ],
  "Invitado" => [
    ["modulo" => "home", "ruta" => "welcome", "visible" => false, "texto" => "", "icono" => ""],
    ["modulo" => "evaluaciones", "ruta" => "lista-evaluacion ", "visible" => true, "texto" => "Evaluaciones", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "preguntas", "ruta" => "lista-pregunta", "visible" => true, "texto" => "Preguntas", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "resultados", "ruta" => "lista-resultado", "visible" => true, "texto" => "Resultados", "icono" => "nav-icon fas fa-th"],
    // Otros accesos para "Invitado"
  ]
];

// Inicializar la sesión si no existe
if (!isset($_SESSION['login'])) {
  $_SESSION['login'] = [
    "status"      => false,
    "idusuario"   => -1,
    "apellidos"   => "",
    "nombres"     => "",
    "rol_nombre"  => "",
    "nombreusuario" => "",
    "permisos"    => []
  ];
}

// Comunicación E/S JSON
header('Content-Type: application/json; charset=utf-8');

// Procesar el inicio de sesión (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['operation']) && $_POST['operation'] == 'login') {
    // Validar existencia de datos enviados
    $nombreusuario = isset($_POST['nombreusuario']) ? $usuario->limpiarCadena($_POST['nombreusuario']) : null;
    $claveacceso = isset($_POST['claveacceso']) ? $usuario->limpiarCadena($_POST['claveacceso']) : null;

    $statusLogin = [
      "esCorrecto" => false,
      "mensaje"    => "Datos incompletos."
    ];

    // Validar datos completos
    if ($nombreusuario && $claveacceso) {
      $registro = $usuario->login(['nombreusuario' => $nombreusuario]);

      if (count($registro) == 0) {
        $statusLogin["mensaje"] = "Usuario no existe.";
      } else {
        $claveEncriptada = $registro[0]['claveacceso'];

        if (password_verify($claveacceso, $claveEncriptada)) {
          $statusLogin["esCorrecto"] = true;
          $statusLogin["mensaje"] = "Bienvenido a la aplicación.";

          // Actualizar sesión
          $_SESSION["login"]["status"] = true;
          $_SESSION["login"]["idusuario"] = $registro[0]['idusuario'];
          $_SESSION["login"]["apellidos"] = $registro[0]['apellidos'] ?? ""; // Validar clave
          $_SESSION["login"]["nombres"] = $registro[0]['nombres'] ?? "";     // Validar clave
          $_SESSION["login"]["rol_nombre"] = $registro[0]['rol_nombre'];
          $_SESSION["login"]["nombreusuario"] = $registro[0]['nombreusuario'];
          $_SESSION["login"]["permisos"] = $accesos[$registro[0]['rol_nombre']] ?? [];
        } else {
          $statusLogin["mensaje"] = "Contraseña incorrecta.";
        }
      }
    }

    // Responder en JSON
    echo json_encode($statusLogin);
  }
}

// Procesar el cierre de sesión (GET)
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET["operation"]) && $_GET["operation"] == "destroy") {
    session_destroy();
    session_unset();
    header("Location: ../../"); // Redirigir a la página de inicio
  }
}
