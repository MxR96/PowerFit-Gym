<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
$usuario = $_SESSION['usuario'] ?? null;
$role = $usuario['role'] ?? null;
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $plan = $_POST['plan'] ?? 'Mensual Basico';
    if ($nombre && $email) {
        $ins = $pdo->prepare('INSERT INTO inscripciones (nombre, email, telefono, plan) VALUES (:nombre,:email,:telefono,:plan)');
        $ins->execute(['nombre'=>$nombre,'email'=>$email,'telefono'=>$telefono,'plan'=>$plan]);
        $mensaje = 'Inscripción registrada.';
    } else { $mensaje = 'Nombre y email obligatorios.'; }
}
if (isset($_GET['delete']) && $role === 'admin') {
    $id = (int)$_GET['delete'];
    $del = $pdo->prepare('DELETE FROM inscripciones WHERE id = :id');
    $del->execute(['id'=>$id]);
    header('Location: inscripcion.php'); exit;
}
if ($role === 'admin') {
    $stmt = $pdo->query('SELECT * FROM inscripciones ORDER BY id DESC');
    $inscripciones = $stmt->fetchAll();
} else {
    if ($usuario) {
        $stmt = $pdo->prepare('SELECT * FROM inscripciones WHERE email = :email ORDER BY id DESC');
        $stmt->execute(['email'=>$usuario['email']]);
        $inscripciones = $stmt->fetchAll();
    } else {
        $stmt = $pdo->query('SELECT * FROM inscripciones ORDER BY id DESC');
        $inscripciones = $stmt->fetchAll();
    }
}
include __DIR__ . '/../includes/header.php';
?>
<div class="row">
  <div class="col-md-6">
    <h2>Inscribite hoy</h2>
    <?php if($mensaje): ?><div class="alert alert-info"><?=htmlspecialchars($mensaje)?></div><?php endif; ?>
    <form method="post" class="row g-3 mb-4">
      <div class="col-md-12"><input name="nombre" class="form-control" placeholder="Nombre" required></div>
      <div class="col-md-12"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
      <div class="col-md-6"><input name="telefono" class="form-control" placeholder="Telefono"></div>
      <div class="col-md-6"><select name="plan" class="form-select"><option>Mensual Basico</option><option>Mensual Pro</option><option>Mensual Premium</option></select></div>
      <div class="col-12"><button class="btn btn-primary" type="submit">Enviar inscripción</button></div>
    </form>
  </div>
  <div class="col-md-6">
    <h4>Usuarios inscriptos</h4>
    <?php if (empty($inscripciones)): ?><p>No hay inscripciones.</p>
    <?php else: ?>
      <ul class="list-group">
      <?php foreach($inscripciones as $i): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div><b><?=htmlspecialchars($i['nombre'])?></b> - <?=htmlspecialchars($i['plan'])?> - <?=htmlspecialchars($i['email'])?> - <?=htmlspecialchars($i['telefono'])?></div>
          <div>
            <?php if($role === 'admin'): ?>
              <a class="btn btn-sm btn-danger" href="?delete=<?= $i['id'] ?>" onclick="return confirm('Eliminar inscripción?')">Eliminar</a>
            <?php else: ?>
              <span class="text-muted">Sin permisos</span>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>