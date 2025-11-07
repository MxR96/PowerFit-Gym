<?php
$usuario = $_SESSION['usuario'] ?? null;
$role = $usuario['role'] ?? null;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">POWERFIT</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navmenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
        
        <li class="nav-item"><a class="nav-link" href="inscripcion.php">Inscripción</a></li>
        <li class="nav-item"><a class="nav-link" href="reservas.php">Reservas</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#">Catalogo</a></li>
        
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
      <?php if(!$usuario): ?>
          <li class="nav-item"><a class="nav-link" href="registro.php">Registro</a></li>
        <?php endif; ?>
        <?php if($usuario): ?>
          <li class="nav-item">
            <a class="nav-link" href="perfil.php">👤 <?= htmlspecialchars($usuario['nombre']) ?></a>
          </li>
          <?php if($role === 'admin'): ?>
          <li class="nav-item"><a class="nav-link disabled" href="#">Stock</a></li>
          <li class="nav-item"><a class="nav-link" href="usuarios_admin.php">Usuarios</a></li>
        <?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesión</a></li>
        <?php endif; ?>
        
      </ul>
    </div>
  </div>
</nav>
