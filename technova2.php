<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $clave = $_POST["clave"];

    if ($usuario === "admin1" && $clave === "12345") {
        $_SESSION["usuario"] = $usuario;
        header("Location: inventario.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technova Inventarios</title>
    <style>
        /* Tu mismo estilo original */
        /* (lo puedes mantener exactamente igual que lo tenías antes) */
        /* Solo agregaremos lo del formulario */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a1d37, #1b263b);
            color: #d5e1df;
        }
        form {
            background: rgba(15,23,42,0.9);
            padding: 30px;
            border-radius: 15px;
            max-width: 400px;
            margin: 30px auto;
            box-shadow: 0 5px 20px rgba(0,0,0,0.4);
        }
        form input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            outline: none;
        }
        form button {
            width: 100%;
            background: #4e79a7;
            border: none;
            padding: 12px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        form button:hover {
            background: #345f8c;
        }
        .error {
            color: #ff7373;
            text-align: center;
        }
        section {
            display: none;
        }
        section.active {
            display: block;
        }
    </style>
    <script>
        function showSection(id) {
            const sections = document.querySelectorAll("section");
            sections.forEach(sec => sec.classList.remove("active"));
            document.getElementById(id).classList.add("active");
        }

        window.onload = () => {
            showSection("acceso");
        };
    </script>
</head>
<body>
    <header>
        <h1>Technova Inventarios</h1>
        <p>Transformamos la gestión de inventarios...</p>
    </header>

    <nav>
        <a onclick="showSection('acceso')">Acceso a Inventario</a>
        <a onclick="showSection('acerca')">Acerca de Nosotros</a>
        <a onclick="showSection('publicidad')">Publicidad</a>
        <a onclick="showSection('servicios')">Servicios</a>
    </nav>

    <section id="acceso" class="active">
        <h2>Acceso a Inventario</h2>
        <form method="POST" action="">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
    </section>

    <!-- Tus otras secciones (acerca, publicidad, servicios, footer) pueden quedarse igual -->
</body>
</html>



Inventario.php

<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit;
}

include("conexion.php");

// Insertar nuevo producto
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"];
    $codigo = $_POST["codigo"];
    $compra = $_POST["compra"];
    $venta = $_POST["venta"];
    $stock = $_POST["stock"];
    $minimo = $_POST["minimo"];
    $fecha = date("Y-m-d");

    $sql = "INSERT INTO productos_inventario (nombre, descripcion, categoria, codigo_barras, precio_compra, precio_venta, stock_actual, stock_minimo, fecha_registro)
            VALUES ('$nombre','$descripcion','$categoria','$codigo','$compra','$venta','$stock','$minimo','$fecha')";
    mysqli_query($conexion, $sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Technova</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f9; padding: 20px; }
        table { border-collapse: collapse; width: 100%; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #4e79a7; color: white; }
        form { background: #fff; padding: 20px; border-radius: 10px; margin-bottom: 30px; }
        input { margin: 5px; padding: 8px; width: 150px; }
        button { background: #4e79a7; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Inventario de Productos</h1>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre Producto" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <input type="text" name="categoria" placeholder="Categoría" required>
        <input type="text" name="codigo" placeholder="Código Barras" required>
        <input type="number" name="compra" placeholder="Precio Compra" required>
        <input type="number" name="venta" placeholder="Precio Venta" required>
        <input type="number" name="stock" placeholder="Stock Actual" required>
        <input type="number" name="minimo" placeholder="Stock Mínimo" required>
        <button type="submit">Agregar Producto</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre Producto</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Código Barras</th>
            <th>Precio Compra</th>
            <th>Precio Venta</th>
            <th>Stock Actual</th>
            <th>Stock Mínimo</th>
            <th>Fecha Registro</th>
        </tr>
        <?php
        $resultado = mysqli_query($conexion, "SELECT * FROM productos_inventario");
        while($fila = mysqli_fetch_assoc($resultado)){
            echo "<tr>
                <td>{$fila['id_producto']}</td>
                <td>{$fila['nombre']}</td>
                <td>{$fila['descripcion']}</td>
                <td>{$fila['categoria']}</td>
                <td>{$fila['codigo_barras']}</td>
                <td>{$fila['precio_compra']}</td>
                <td>{$fila['precio_venta']}</td>
                <td>{$fila['stock_actual']}</td>
                <td>{$fila['stock_minimo']}</td>
                <td>{$fila['fecha_registro']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
