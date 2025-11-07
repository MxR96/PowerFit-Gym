<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
$usuario = $_SESSION['usuario'] ?? null;
if (!$usuario || ($usuario['role'] ?? '') !== 'admin') {
    header('Location: login.php'); exit;
}
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id === (int)$usuario['id']) { header('Location: usuarios_admin.php'); exit; }
    $del = $pdo->prepare('DELETE FROM usuarios WHERE id = :id');
    $del->execute(['id'=>$id]);
    header('Location: usuarios_admin.php'); exit;
}
$stmt = $pdo->query('SELECT id, nombre, apellido, email, telefono, usuario, plan, role FROM usuarios ORDER BY id DESC');
$usuarios = $stmt->fetchAll();
include __DIR__ . '/../includes/header.php';
?>
<h2>Panel de Usuarios</h2>
<table class="table table-bordered table-responsive">
  <thead><tr><th>ID</th><th>Usuario</th><th>Nombre</th><th>Email</th><th>Tel</th><th>Plan</th><th>Role</th><th>Acción</th></tr></thead>
  <tbody>
    <?php foreach($usuarios as $u): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['usuario']) ?></td>
        <td><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['telefono']) ?></td>
        <td><?= htmlspecialchars($u['plan']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
        <td>
          <?php if($u['id'] !== $usuario['id']): ?>
            <a class="btn btn-sm btn-danger" href="?delete=<?= $u['id'] ?>" onclick="return confirm('Eliminar usuario?')">Eliminar</a>
          <?php else: ?>
            <span class="text-muted">Cuenta propia</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>