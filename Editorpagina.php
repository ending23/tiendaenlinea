<?php
session_start();
include 'database.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir si no está logueado
    exit();
}

// Eliminar producto
if (isset($_GET['eliminar_id'])) {
    $id = $_GET['eliminar_id'];
    $sql = "DELETE FROM productos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Producto eliminado correctamente.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Agregar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Insertar datos en la base de datos
    $sql = "INSERT INTO productos (nombre, descripcion, precio) VALUES ('$nombre', '$descripcion', '$precio')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Producto agregado correctamente.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Editar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    $sql = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<p>Producto actualizado correctamente.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "<br></p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: white;
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Productos</h1>

    <!-- Formulario para agregar producto -->
    <h2>Agregar Producto</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <textarea name="descripcion" placeholder="Descripción" required></textarea><br>
        <input type="number" name="precio" placeholder="Precio" step="0.01" required><br>
        <button type="submit" name="add">Agregar Producto</button>
    </form>

    <!-- Listado de productos -->
    <h2>Listado de Productos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
                <td><?php echo $row['precio']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required>
                        <input type="text" name="descripcion" value="<?php echo $row['descripcion']; ?>" required>
                        <input type="number" name="precio" value="<?php echo $row['precio']; ?>" step="0.01" required>
                        <button type="submit" name="update">Actualizar</button>
                    </form>
                    <a href="?eliminar_id=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que quieres eliminar este producto?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>

<?php $conn->close(); ?>
