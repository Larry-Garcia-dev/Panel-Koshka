<?php
//======================================================  Nombre de User =================================================================

session_start();

// Verifica que el usuario haya iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php?error=unauthorized");
    exit();
}

$userName = $_SESSION['user_name'];


//=======================================================  Fin de nombre de User =================================================================


//=======================================================  Mostrar Productos =================================================================

require "../config/db.php";


?>