<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login']['status'] == false) {
  header("Location: " . SERVERURL);
}

//Obtener el perfil del usuario 
$listapermisos = $_SESSION['login']['permisos'];

//Obtener la vista y validar con "listaPermisos"
$urlCompleta = $_SERVER['REQUEST_URI'];
$arrayURL = explode("/", $urlCompleta);
$vistaActual = end($arrayURL);

$encontrado = false; //bandera
foreach ($listapermisos as $permiso) {
  if ($vistaActual == $permiso['ruta']) {
    $encontrado = true;
  }
}

//El usuario ha intentado ingresar a una vista que no le corresponde
if (!$encontrado) {
  header("Location: " . SERVERURL . "views/home/welcome");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= COMPANY ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome Icons ACTUALIZADO 6.6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Theme style -->
  <link rel="stylesheet" href="<?= SERVERURL ?>dist/css/adminlte.min.css">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="<?= SERVERURL ?>dist/css/estilos.css">

</head>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li> 

        <!-- Cerrar sesión -->
        <li class="nav-item">
          <a class="nav-link" href="<?= SERVERURL ?>app/controllers/usuario.controller.php?operation=destroy" role="button" title="Cerrar sesión">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= SERVERURL ?>views" class="brand-link">
        <img src="<?= SERVERURL ?>dist/img/USER.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= COMPANY ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <?php
            // Las opciones del SIDEBAR se renderizan de forma automática (en función del PERFIL)
            $vista = "";
            foreach ($listapermisos as $permiso) {
              if ($permiso['visible'] == true) {
                $vista = SERVERURL . "views/" . $permiso['modulo'] . "/" . $permiso['ruta'];
                echo "
                  <li class='nav-item'>
                  <a href='{$vista}' class='nav-link'>
                  <p>
                  {$permiso['texto']}
                  </p>
                  </a>
                  </li>
                ";
              }
            }
            ?>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>