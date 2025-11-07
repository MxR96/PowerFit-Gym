<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
$usuario = $_SESSION['usuario'] ?? null;
$role = $usuario['role'] ?? null;
$mensaje = '';
// crear reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'crear') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $actividad = $_POST['actividad'] ?? '';
    $fecha = $_POST['fecha'] ?? null;
    $hora = $_POST['hora'] ?? null;
    if ($nombre && $email && $actividad && $fecha && $hora) {
        $ins = $pdo->prepare("INSERT INTO reservas (nombre, email, actividad, fecha, hora) VALUES (:nombre,:email,:actividad,:fecha,:hora)");
        $ins->execute(['nombre'=>$nombre,'email'=>$email,'actividad'=>$actividad,'fecha'=>$fecha,'hora'=>$hora]);
        $mensaje = 'Reserva registrada correctamente.';
    } else { $mensaje = 'Completa todos los campos.'; }
}
// eliminar (solo admin)
if (isset($_GET['delete']) && $role === 'admin') {
    $id = (int)$_GET['delete'];
    $del = $pdo->prepare('DELETE FROM reservas WHERE id = :id');
    $del->execute(['id'=>$id]);
    header('Location: reservas.php'); exit;
}
// listar reservas: if admin all, else only own by email if logged in, otherwise all for visibility
if ($role === 'admin') {
    $stmt = $pdo->query('SELECT * FROM reservas ORDER BY fecha DESC, hora DESC');
    $reservas = $stmt->fetchAll();
} else {
    if ($usuario) {
        $stmt = $pdo->prepare('SELECT * FROM reservas WHERE email = :email ORDER BY fecha DESC, hora DESC');
        $stmt->execute(['email'=>$usuario['email']]);
        $reservas = $stmt->fetchAll();
    } else {
        $stmt = $pdo->query('SELECT * FROM reservas ORDER BY fecha DESC, hora DESC');
        $reservas = $stmt->fetchAll();
    }
}
include __DIR__ . '/../includes/header.php';
?>
<div class="row">
  <div class="col-md-12">
    <h2>Reservas</h2>
    <?php if($mensaje): ?><div class="alert alert-info"><?=htmlspecialchars($mensaje)?></div><?php endif; ?>
    <div class="card mb-4"><div class="card-body">
      <form method="post" class="row g-3">
        <input type="hidden" name="accion" value="crear">
        <div class="col-md-3"><input name="nombre" class="form-control" placeholder="Nombre" required></div>
        <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="col-md-3"><select name="actividad" class="form-select"><option>Musculación</option><option>Spinning</option><option>Yoga</option><option>Pilates</option><option>CrossFit</option></select></div>
        <div class="col-md-1"><input type="date" name="fecha" class="form-control" required></div>
        <div class="col-md-1"><input type="time" name="hora" class="form-control" required></div>
        <div class="col-md-1"><button class="btn btn-success" type="submit">Reservar</button></div>
      </form>
    </div></div>
    <h4>Reservas registradas</h4>
    <?php if (empty($reservas)): ?><p>No hay reservas aún.</p>
    <?php else: ?>
      <div class="table-responsive"><table class="table table-striped">
        <thead><tr><th>Nombre</th><th>Actividad</th><th>Fecha</th><th>Hora</th><th>Email</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php foreach($reservas as $r): ?>
          <tr>
            <td><?=htmlspecialchars($r['nombre'])?></td>
            <td><?=htmlspecialchars($r['actividad'])?></td>
            <td><?=htmlspecialchars($r['fecha'])?></td>
            <td><?=htmlspecialchars(substr($r['hora'],0,5))?></td>
            <td><?=htmlspecialchars($r['email'])?></td>
            <td>
              <?php if($role === 'admin'): ?>
                <a class="btn btn-sm btn-danger" href="?delete=<?= $r['id'] ?>" onclick="return confirm('Eliminar reserva?')">Eliminar</a>
              <?php else: ?>
                <span class="text-muted">Sin permisos</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
    <?php endif; ?>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>