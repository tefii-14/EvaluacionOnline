<?php

//Administrador (100%), Asistente, Invitado, 
$permisos = [
  "Administrador" => [
    ["modulo" => "Alternativas", "ruta" => "Alternativas/lista-alternativa", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "Categorias", "ruta" => "Categorias/lista-categoria", "icono" => "nav-icon fas fa-th"],
    ["modulo" => "Evaluaciones", "ruta" => "Evaluaciones/lista-evaluacion", "icono" => ""],
    ["modulo" => "Inicio", "ruta" => "Inicio/lista-inicio", "icono" => ""],
    ["modulo" => "Preguntas", "ruta" => "Preguntas/lista-pregunta", "icono" => ""],
    ["modulo" => "Resultados", "ruta" => "Resultados/lista-resultado", "icono" => ""],
    ["modulo" => "Usuarios", "ruta" => "Usuarios/lista-usuario", "icono" => ""]
  ],
  "Instructor"     => [],
  "Alumno"      => [],
  "Invitado"      => []
];