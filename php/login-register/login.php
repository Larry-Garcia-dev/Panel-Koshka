<?php
// Iniciar sesión
session_start();

// Conexión a la base de datos
require '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $email = $_POST['Email'] ?? '';
    $password = $_POST['Password'] ?? '';

    if (empty($email) || empty($password)) {
        header("Location: ../../index.php?error=missing_fields_login");
        exit();
    }

    try {
        // Buscar usuario por correo
        $stmt = $pdo->prepare("SELECT * FROM user WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y la contraseña es correcta
        if ($user && password_verify($password, $user['Contraseña'])) {
            // Guardar información en sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['Email'];
            $_SESSION['user_name'] = $user['NombreCompleto'];

            // Redirigir a una página protegida (ajusta según tus rutas)
            header("Location: ../../views/index.php");
            exit();
        } else {
            header("Location: ../../index.php?error=invalid_credentials");
            exit();
        }
    } catch (PDOException $e) {
        die("Error en la autenticación: " . $e->getMessage());
    }
}
?>