<?php
// Incluir configuración y la clase de conexión
require_once "../../app/config/App.php";
require_once "../../app/models/Conexion.php";

// Obtener la conexión a la base de datos
$conn = Conexion::getConexion();

// Consulta para obtener las preguntas
$query = "SELECT * FROM Preguntas ORDER BY idpregunta DESC";
$stmt = $conn->prepare($query);
$stmt->execute();

// Obtener todas las preguntas
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
//Incluye la cabecera del DASHBOARD y 2 secciones NAV + ASIDE
require_once "../includes/header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <?php echo renderContentHeader("Lista de Preguntas", "Inicio", SERVERURL . "views"); ?>
  <!-- /.content-header -->

  <!-- Tabla de preguntas -->
  <div class="col-md-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">Lista de Preguntas</div>
          <div class="col-md-6 text-right">
            <!-- Botón de Crear Pregunta -->
            <a href="../Preguntas/formulario-pregunta.php" class="btn btn-sm btn-primary">Crear Pregunta</a>
            <!-- Botón adicional "Registrar Pregunta" -->
            <a href="./registra-pregunta.php" class="btn btn-sm btn-secondary">Registrar Pregunta</a>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Título</th>
                <th>Puntaje</th>
                <th>Alternativas</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Iterar sobre las preguntas obtenidas
              foreach ($preguntas as $pregunta) {
                // Obtener las alternativas de cada pregunta
                $idpregunta = $pregunta['idpregunta'];
                $query_alternativas = "SELECT * FROM Alternativas WHERE idpregunta = :idpregunta";
                $stmt_alternativas = $conn->prepare($query_alternativas);
                $stmt_alternativas->execute(['idpregunta' => $idpregunta]);
                $alternativas = $stmt_alternativas->fetchAll(PDO::FETCH_ASSOC);
                
                // Mostrar cada pregunta y sus alternativas
                echo "<tr>";
                echo "<td>" . $pregunta['idpregunta'] . "</td>";
                echo "<td>" . $pregunta['titulo'] . "</td>";
                echo "<td>" . $pregunta['puntaje'] . "</td>";
                echo "<td>";
                
                // Mostrar las alternativas de la pregunta
                foreach ($alternativas as $alternativa) {
                  echo "<p>" . $alternativa['alternativa'] . "</p>";
                }
                
                echo "</td>";
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
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
//Incluye las últimas 2 secciones: ASIDE + FOOTER y <SCRIPT>
require_once "../includes/footer.php";
?>

</body>
</html>
