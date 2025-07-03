<?php
// php/login-register/register.php

require '../../config/db.php'; // Ruta corregida

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $pin = $_POST['Pin'] ?? null;
    $name = $_POST['Name'] ?? null;
    $email = $_POST['Email'] ?? null;
    $user = $_POST['User'] ?? null;
    $password = $_POST['Password'] ?? null;

    if (!$pin || !$name || !$email || !$user || !$password) {
        header("Location: ../../index.php?error=missing_fields");
        exit();
    }

    // Validar longitud del PIN
    if (!is_numeric($pin) || strlen($pin) !== 6) {
        header("Location: ../../index.php?error=invalid_pin_format");
        exit();
    }

    // Verificar si el PIN existe en la tabla pines_registro
    try {
        $stmt = $conexion->prepare("SELECT COUNT(*) FROM pines_registro WHERE pin = ?");
        $stmt->execute([$pin]);

        if ($stmt->fetchColumn() == 0) {
            header("Location: ../../index.php?error=invalid_pin");
            exit();
        }
    } catch (PDOException $e) {
        die("Error al validar el PIN: " . $e->getMessage());
    }

    // Verificar si el correo ya está registrado
    try {
        $stmt = $conexion->prepare("SELECT COUNT(*) FROM user WHERE Email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            header("Location: ../../index.php?error=email_taken");
            exit();
        }
    } catch (PDOException $e) {
        die("Error al verificar correo: " . $e->getMessage());
    }

    // Encriptar contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    try {
        $stmt = $conexion->prepare("INSERT INTO user (Pin, NombreCompleto, Email, Usuario, Contraseña) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$pin, $name, $email, $user, $hashed_password]);

        header("Location: ../../index.php?success=registration");
        exit();
    } catch (PDOException $e) {
        die("Error al registrar: " . $e->getMessage());
    }
}
?>