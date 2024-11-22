<?php
// Incluir configuración y la clase de conexión
require_once "../../app/config/App.php";
require_once "../../app/models/Conexion.php";

// Obtener la conexión a la base de datos
$conn = Conexion::getConexion();

// Consulta para obtener todas las alternativas
$query = "SELECT * FROM Alternativas ORDER BY idalternativa DESC";
$stmt = $conn->prepare($query);
$stmt->execute();

// Obtener todas las alternativas
$alternativas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
//Incluye la cabecera del DASHBOARD y 2 secciones NAV + ASIDE
require_once "../includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <?php echo renderContentHeader("Lista de Alternativas", "Inicio", SERVERURL . "views"); ?>
  <!-- /.content-header -->

  <!-- Tabla de alternativas -->
  <div class="col-md-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">Lista de Alternativas</div>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Alternativa</th>
                <th>Escorrecto</th>
                <th>ID Pregunta</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Iterar sobre las alternativas obtenidas
              foreach ($alternativas as $alternativa) {
                echo "<tr>";
                echo "<td>" . $alternativa['idalternativa'] . "</td>";
                echo "<td>" . $alternativa['escorrecto'] . "</td>";
                echo "<td>" . $alternativa['alternativa'] . "</td>";
                echo "<td>" . $alternativa['idpregunta'] . "</td>";
                echo "<td>";
                echo "<a href='#' class='btn btn-sm btn-info'>Editar</a>";
                echo "<a href='#' class='btn btn-sm btn-danger'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div> <!-- ./card-body -->
    </div> <!-- ./card -->
  </div> <!-- ./col-md-12 -->
</div>
<!-- /.content-wrapper -->

<?php
//Incluye las últimas 2 secciones: ASIDE + FOOTER y <SCRIPT>
require_once "../includes/footer.php";
?>

</body>
</html>
