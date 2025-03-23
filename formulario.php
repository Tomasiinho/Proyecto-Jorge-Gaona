<?php


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Validar datos del formulario
    if (empty($_POST['facultad']) || empty($_POST['nombre']) || empty($_POST['profesor'])) {
        die("Todos los campos son obligatorios.");
    }

    $facultad = $_POST['facultad'];
    $nombre = $_POST['nombre'];
    $profesor = $_POST['profesor'];

    $db_host = "localhost";
    $db_name = "proyecto_jorge_gaona";
    $db_user = "root";
    $db_pass = "";

    // Conexión BD
    $conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Insertar datos
    $query = $conexion->prepare("INSERT INTO usuarios(facultad, nombre, profesor) VALUES (?, ?, ?)");
    if (!$query) {
        die("Error al preparar la consulta: " . $conexion->error);
    }
    $query->bind_param("sss", $facultad, $nombre, $profesor);
    if (!$query->execute()) {
        $error = "Error al ejecutar la consulta: " . $query->error;
    } else {
        $exito = "datos guardados con exito";
    }
    $query->close();


    // Cerrar conexiones
    $conexion->close();
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>UPLA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container text-center">

        <div class="card text-center p-2 mx-auto my-5" style="max-width: 400px;">

            <h1>Formulario UPLA</h1>
            <?php
            if (isset($error)) {
                echo "<div class='alert alert-danger'>" . $error . "</div>";
            }
            if (isset($exito)) {
                echo "<div class='alert alert-success'>" . $exito . "</div>";
            }

            ?>
            <form action="registro.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="facultad" class="form-label">Facultad</label>
                    <input type="text" class="form-control" id="facultad" name="facultad" placeholder="Ingrese el nombre de la facultad" required>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre compelto" required>
                </div>
                <div class="mb-3">
                    <label for="profesor" class="form-label">Profesor</label>
                    <input type="profesor" class="form-control" id="profesor" name="profesor" placeholder="Ingrese el nombre del profesor" required>
                </div>
            </form>
            <br>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>