<?php
// Incluir configuración y la clase de conexión
require_once "../../app/config/App.php";
require_once "../../app/models/Conexion.php";

// Obtener la conexión a la base de datos
$conn = Conexion::getConexion();

// Consultas para obtener los datos de la base de datos
$queryEvaluaciones = "SELECT COUNT(*) AS total FROM Evaluaciones"; // Asumiendo que existe una tabla Evaluaciones
$stmtEvaluaciones = $conn->prepare($queryEvaluaciones);
$stmtEvaluaciones->execute();
$totalEvaluaciones = $stmtEvaluaciones->fetch(PDO::FETCH_ASSOC)['total'];

$queryUsuarios = "SELECT COUNT(*) AS total FROM Usuarios"; // Consulta para contar usuarios
$stmtUsuarios = $conn->prepare($queryUsuarios);
$stmtUsuarios->execute();
$totalUsuarios = $stmtUsuarios->fetch(PDO::FETCH_ASSOC)['total'];

$queryRoles = "SELECT * FROM Roles"; // Consulta para obtener roles
$stmtRoles = $conn->prepare($queryRoles);
$stmtRoles->execute();
$roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
//Incluye la cabecera del DASHBOARD y 2 secciones NAV + ASIDE
require_once "../includes/header.php";
?>

<!-- Estilos específicos para el gráfico -->
<style>
    #dynamic-content canvas {
        width: 400px !important;
        height: 300px !important;
        width: 420px;  /* Ajusta el tamaño del contenedor si es necesario */
    }
</style>

<!-- Asegúrate de cargar jQuery primero -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Luego carga los demás scripts -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Agrega el script de Chart.js -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Wrapper -->
        <div class="content-header">
            <!-- Content Header (Page header) -->
            <?php echo renderContentHeader("Categorias", "Inicio", SERVERURL . "views"); ?>
       </div>

        <div class="content">
            <div class="container-fluid">
                <!-- Row with cards -->
                <div class="row">
                    <!-- Card: Evaluaciones -->
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $totalEvaluaciones; ?></h3> <!-- Dynamic placeholder from DB -->
                                <p>Total Evaluaciones</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <a href="#" class="small-box-footer" id="evaluaciones-btn">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Card: Usuarios -->
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $totalUsuarios; ?></h3> <!-- Dynamic placeholder from DB -->
                                <p>Total Usuarios</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="#" class="small-box-footer" id="usuarios-btn">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Card: Gráficos -->
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><i class="fas fa-chart-pie"></i></h3>
                                <p>Gráficos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <a href="#" class="small-box-footer" id="graficos-btn">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content Section -->
                <div id="dynamic-content" class="mt-4">
                    <!-- Placeholder for CRUD or graphs -->
                </div>
            </div>
        </div>
</div>

<!-- AdminLTE Scripts -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
    $(document).ready(function () {
        // Click event for Evaluaciones
        $("#evaluaciones-btn").click(function () {
        console.log("Botón Evaluaciones clickeado"); // Verifica que el evento se dispare
            $("#dynamic-content").html(`
                <h4>CRUD de Evaluaciones</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Evaluación 1</td>
                            <td>2024-11-23</td>
                            <td><button class="btn btn-sm btn-primary">Editar</button> <button class="btn btn-sm btn-danger">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
            `);
        });


        // Click event for Usuarios
        $("#usuarios-btn").click(function () {
            $("#dynamic-content").html(`
                <h4>CRUD de Usuarios</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $role): ?>
                        <tr>
                            <td><?php echo $role['idrol']; ?></td>
                            <td><?php echo $role['rol_nombre']; ?></td>
                            <td>email@example.com</td>
                            <td><button class="btn btn-sm btn-primary">Editar</button> <button class="btn btn-sm btn-danger">Eliminar</button></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            `);
        });

        // Click event for Gráficos
        $("#graficos-btn").click(function () {
            $("#dynamic-content").html(`
                <h4>Gráficos</h4>
                <canvas id="myChart" width="400" height="400"></canvas>
            `);

            // Datos del gráfico (usamos los valores obtenidos en PHP)
            var ctx = document.getElementById('myChart').getContext('2d');
            
            // Datos a pasar desde PHP a JS
            var totalEvaluaciones = <?php echo $totalEvaluaciones; ?>;
            var totalUsuarios = <?php echo $totalUsuarios; ?>;
            
            // Aquí puedes añadir más datos si es necesario

            var myChart = new Chart(ctx, {
                type: 'bar', // Tipo de gráfico
                data: {
                    labels: ['Evaluaciones', 'Usuarios'], // Etiquetas
                    datasets: [{
                        label: 'Total', // Título de los datos
                        data: [totalEvaluaciones, totalUsuarios], // Datos pasados desde PHP
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)', // Color de las barras
                            'rgba(75, 192, 192, 0.2)'  // Color de las barras
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',  // Color del borde
                            'rgba(75, 192, 192, 1)'   // Color del borde
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Iniciar el eje Y en 0
                        }
                    }
                }
            });
        });
    });
</script>

</div>
<!-- /.content-wrapper -->

<?php
//Incluye las últimas 2 secciones: ASIDE + FOOTER y <SCRIPT>
require_once "../includes/footer.php";
?>

</body>
</html>
