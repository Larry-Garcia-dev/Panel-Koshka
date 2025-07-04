 <?php

// Obtener la imagen del usuario
$userId = $_SESSION['user_id'];

$sqlUserImg = "SELECT img FROM user WHERE id = ?";
$stmtUser = $conexion->prepare($sqlUserImg);
$stmtUser->execute([$userId]);
$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

// Construir rutas de imagen
$imgFolderPath = __DIR__ . "/../images/perfil/";
$imgWebPath = "../images/perfil/";

if (!empty($userData['img']) && file_exists($imgFolderPath . $userData['img'])) {
    $userPhotoURL = $imgWebPath . $userData['img'];
} else {
    $userPhotoURL = $imgWebPath . "default.png";
}
?>
 
 <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-shop"></i> Koshka Admin
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3"><strong><?= htmlspecialchars($userName) ?></strong></span>

                <div class="dropdown">
                    <button class="btn p-0 border-0 bg-transparent" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= htmlspecialchars($userPhotoURL) ?>" alt="Perfil" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" onerror="this.onerror=null; this.src='../images/perfil/defaul.png';" />
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#perfilModal">
                                <i class="bi bi-person-circle me-2"></i>Mi perfil
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="#">Istanbul</a></li>
                        <li><a class="dropdown-item text-danger" href="../php/cerrar.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <!-- Modal para cambiar nombre de usuario y mucho mas  -->
    <!-- Modal de perfil -->
    <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="../php/actualizar_perfil.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="perfilModalLabel">Editar perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body text-center">

                        <!-- Imagen actual -->
                        <img
                            src="<?= htmlspecialchars($userPhotoURL) ?>"
                            alt="Perfil"
                            class="rounded-circle mb-3"
                            style="width: 100px; height: 100px; object-fit: cover;"
                            onerror="this.onerror=null; this.src='../images/perfil/default.png';">

                        <!-- Subir nueva imagen -->
                        <div class="mb-3">
                            <label for="nuevaImagen" class="form-label">Nueva foto de perfil</label>
                            <input class="form-control" type="file" name="nuevaImagen" id="nuevaImagen" accept="image/*">
                        </div>

                        <!-- Cambiar nombre -->
                        <div class="mb-3">
                            <label for="nuevoNombre" class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" name="nuevoNombre" id="nuevoNombre" value="<?= htmlspecialchars($userName) ?>" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Fin de modal para cambiar nombre y foto de perfil -->