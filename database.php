<?php
$mysqli = new mysqli('localhost', 'root', 'pass', 'mi_proyecto');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Crear un producto
function createProduct($nombre, $descripcion, $precio) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO productos (nombre, descripcion, precio) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nombre, $descripcion, $precio);
    $stmt->execute();
    $stmt->close();
}

// Leer todos los productos
function getProducts() {
    global $mysqli;
    $result = $mysqli->query("SELECT id, nombre, descripcion, precio FROM productos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Leer un producto por ID
function getProduct($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, nombre, descripcion, precio FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Actualizar un producto
function updateProduct($id, $nombre, $descripcion, $precio) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $id);
    $stmt->execute();
    $stmt->close();
}

// Eliminar un producto
function deleteProduct($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
