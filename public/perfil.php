<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
if(!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$id = $_SESSION['usuario']['id'];
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch();

include __DIR__ . '/../includes/header.php';
?>
<h2>Perfil de Usuario</h2>
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><?= htmlspecialchars($user['nombre']) ?> <?= htmlspecialchars($user['apellido']) ?></h5>
    <p><strong>Usuario:</strong> <?= htmlspecialchars($user['usuario']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($user['telefono']) ?: 'No especificado' ?></p>
    <p><strong>Plan actual:</strong> <?= htmlspecialchars($user['plan']) ?></p>
    <p><strong>Rol:</strong> <?= htmlspecialchars($user['role']) ?></p>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
