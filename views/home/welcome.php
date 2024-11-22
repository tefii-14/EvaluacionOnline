<?php
//Configuración aplicación
require_once "../../app/config/App.php";
//Incluye la cabecera del DASHBOARD y 2 secciones NAV + ASIDE
require_once "../includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <?php echo renderContentHeader("Inicio", "Inicio", SERVERURL . "views"); ?>
  <!-- /.content-header -->

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Bloque para "Crear Evaluación" -->
        <div class="col-lg-4 col-md-6 col-sm-12">
          <div class="card">
            <div class="card-body text-center">
              <a href="../Evaluaciones/lista-evaluacion" class="btn btn-primary btn-block">
                <i class="fas fa-book-open fa-2x"></i> <!-- Ícono -->
                <p class="mt-2">Crear Evaluación</p> <!-- Texto -->
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
</div> 
</div>
<!-- /.content-wrapper -->
 
<?php
//Incluye las últimas 2 secciones: ASIDE + FOOTER y <SCRIPT>
require_once "../includes/footer.php";
?>

</body>

</html>