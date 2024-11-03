<?php
session_start();

// Datos de ejemplo para el login (en una base de datos real, esto vendría de una tabla de usuarios)
$usuarios = [
    'admin' => 'admin123', // Usuario administrador
    'cliente' => 'cliente123' // Usuario cliente
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar las credenciales
    if (isset($usuarios[$username]) && $usuarios[$username] === $password) {
        $_SESSION['usuario'] = $username; // Almacenar usuario en sesión
        header("Location: listado_productos.php"); // Redirigir a la página de productos
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input {
            display: block;
            margin: 10px 0;
            padding: 10px;
            width: 100%;
        }
        button {
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<form method="POST">
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <input type="text" name="username" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Iniciar Sesión</button>
</form>

</body>
</html>
