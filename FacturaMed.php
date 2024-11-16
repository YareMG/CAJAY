<?php
// Iniciar la sesión antes de cualquier salida
session_start();

if (!isset($_SESSION['id_medico'])) {
    echo "Por favor, inicie sesión para realizar tu Facturacion.";
    exit();
}

// Conexión a la base de datos (ajusta los parámetros según sea necesario)
$servername = "localhost"; // Cambia esto si es necesario
$username = "root"; // Cambia esto si es necesario
$password = "12345678"; // Cambia esto si es necesario
$dbname = "hospital"; // Cambia esto si es necesario

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Registro de Facturación</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="#">CAJAY</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="CerrarSesion.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">MEDICO</div>
                        <a class="nav-link" href="perfilMed.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Perfil
                        </a>
                        <div class="sb-sidenav-menu-heading">Información</div>
                        <a class="nav-link" href="Medico-Pacientes.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-injured"></i></div>
                            Pacientes
                        </a>
                        <a class="nav-link" href="Citas_pro.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Citas Programadas
                        </a>
                        <a class="nav-link" href="Realizar_RecMed.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Realizar Receta Medica
                        </a>
                        <a class="nav-link" href="medicamentosP.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-pills"></i></div>
                            Medicamentos
                        </a>
                        <a class="nav-link" href="FacturaMed.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            Facturación
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-folder"></i></div>
                                Datos Medicos
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="expediente.php">Expedientes</a>
                                    <a class="nav-link" href="HistorialPaci.php">Historial</a>
                                </nav>
                            </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small"></div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">HOSPITAL</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Registrar Nueva Factura</li>
                    </ol>
                    <!-- Formulario de Registro de Facturación -->
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Registro de Facturación</h3>
                                </div>
                                <div class="card-body">
                                    <form action="sp_facturacion.php" method="POST">
                                        <input type="hidden" name="id_medico" value="<?php echo $_SESSION['id_medico']; ?>" />

                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="inputPaciente" name="id_paciente" required>
                                                <option value="" disabled selected>Selecciona un Paciente</option>
                                                <?php
                                                // Conectar a la base de datos
                                                $servername = "localhost";
                                                $username = "root";
                                                $password = "12345678";
                                                $dbname = "hospital";

                                                $conn = new mysqli($servername, $username, $password, $dbname);

                                                if ($conn->connect_error) {
                                                    die("Conexión fallida: " . $conn->connect_error);
                                                }

                                                // Consulta para obtener pacientes
                                                $query = "SELECT id_paciente, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM pacientes";
                                                $result = $conn->query($query);

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id_paciente'] . "'>" . $row['nombre_completo'] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No hay pacientes disponibles</option>";
                                                }

                                                $conn->close();
                                                ?>
                                            </select>
                                            <label for="inputPaciente">Paciente</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="inputCita" name="id_cita" required>
                                                <option value="" disabled selected>Selecciona una Cita</option>
                                                <?php
                                                // Conectar a la base de datos nuevamente
                                                $conn = new mysqli($servername, $username, $password, $dbname);

                                                if ($conn->connect_error) {
                                                    die("Conexión fallida: " . $conn->connect_error);
                                                }

                                                // Consulta para obtener citas médicas
                                                $query = "SELECT id_cita, fecha_cita FROM citas_medicas WHERE id_paciente IN (SELECT id_paciente FROM pacientes)";
                                                $result = $conn->query($query);

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id_cita'] . "'>" . htmlspecialchars($row['fecha_cita']) . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No hay citas disponibles</option>";
                                                }

                                                $conn->close();
                                                ?>
                                            </select>
                                            <label for="inputCita">Cita Médica</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputMontoTotal" name="monto_total" type="number" step="0.01" required />
                                            <label for="inputMontoTotal">Monto Total</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputFechaFactura" name="fecha_factura" type="date" required />
                                            <label for="inputFechaFactura">Fecha de la Factura</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="inputEstadoPago" name="estado_pago" required>
                                                <option value="Pendiente">Pendiente</option>
                                                <option value="Pagado">Pagado</option>
                                            </select>
                                            <label for="inputEstadoPago">Estado de Pago</label>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary btn-block" type="submit">Registrar Factura</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="Facturacion.php">Ver facturas existentes</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin del formulario -->
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Hospital &copy; Cajay 2024</div>
                        <div>
                            <a href="#">Políticas</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
