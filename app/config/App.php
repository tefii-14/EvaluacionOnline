<?php

//Constantes globales
const SERVERURL = "http://localhost/EvaluacionOnline/";
const COMPANY = "Formulario Online";
const VERSION = "1.0";

//Configuración horaria
date_default_timezone_set("America/Lima");

//Recursos - HELPERS...
function renderContentHeader($title, $home, $path){
  return "
  <div class='content-header'>
    <div class='container-fluid'>
      <div class='row mb-2'>
        <div class='col-sm-6'>
          <h1 class='m-0'>{$title}</h1>
        </div>
        <div class='col-sm-6'>
          <ol class='breadcrumb float-sm-right'>
            <li class='breadcrumb-item'><a href='{$path}'>{$home}</a></li>
            <li class='breadcrumb-item active'>{$title}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  ";
}

//Qué opciones e interfaces podrá utilizar el usuario
$permisos = [
  "Administrador" => [
    ["vista" => "evaluaciones", "ruta" => "lista-evaluacion"],
    ["vista" => "categorias", "ruta" => "lista-categoria"],
    ["vista" => "inicio", "ruta" => "lista-inicio"],
    ["vista" => "preguntas", "ruta" => "lista-pregunta"],
    ["vista" => "alternativas", "ruta" => "lista-alternativa"],
    ["vista" => "usuarios", "ruta" => "lista-usuario"],
    ["vista" => "resultados", "ruta" => "lista-resultado"]
  ],
  "Instructor" => [
    ["vista" => "evaluaciones", "ruta" => "lista-evaluacion"],
    ["vista" => "categorias", "ruta" => "lista-categoria"],
    ["vista" => "inicio", "ruta" => "lista-inicio"],
    ["vista" => "preguntas", "ruta" => "lista-pregunta"],
    ["vista" => "alternativas", "ruta" => "lista-alternativa"],
    ["vista" => "resultados", "ruta" => "lista-resultado"]
  ],
  "Alumno" => [
    ["vista" => "inicio", "ruta" => "lista-inicio"],
    ["vista" => "evaluaciones", "ruta" => "lista-evaluacion"],
    ["vista" => "preguntas", "ruta" => "lista-pregunta"],
    ["vista" => "resultados", "ruta" => "lista-resultado"]
  ],
  "Invitado" => [
    ["vista" => "evaluaciones", "ruta" => "lista-evaluacion"],
    ["vista" => "resultados", "ruta" => "lista-resultado"],
    ["vista" => "preguntas", "ruta" => "lista-pregunta"]
  ],
];