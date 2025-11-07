<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $telefono = trim($_POST['telefono'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $plan = $_POST['plan'] ?? 'Mensual Basico';

    if (!$nombre || !$apellido || !$email || !$usuario || !$password) {
        $mensaje = "Completa todos los campos obligatorios.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email");
        $stmt->execute(['usuario' => $usuario, 'email' => $email]);
        if ($stmt->fetch()) {
            $mensaje = "El usuario o email ya existen.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, telefono, usuario, password, plan, role) VALUES (:nombre,:apellido,:email,:telefono,:usuario,:password,:plan,'client')");
            $ins->execute([ 'nombre'=>$nombre,'apellido'=>$apellido,'email'=>$email,'telefono'=>$telefono,'usuario'=>$usuario,'password'=>$hash,'plan'=>$plan ]);
            $mensaje = "Registro exitoso. Ya podés iniciar sesión.";
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>
<div class="row">
  <div class="col-md-6">
    <h2>Crear cuenta</h2>
    <?php if($mensaje): ?><div class="alert alert-info"><?=htmlspecialchars($mensaje)?></div><?php endif; ?>
    <form method="post" class="row g-3">
      <div class="col-md-6"><label class="form-label">Nombre</label><input name="nombre" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label">Apellido</label><input name="apellido" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label">Teléfono</label><input name="telefono" class="form-control"></div>
      <div class="col-md-6"><label class="form-label">Usuario</label><input name="usuario" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label">Contraseña</label><input type="password" name="password" class="form-control" required minlength="4"></div>
      <div class="col-md-6"><label class="form-label">Plan</label>
        <select name="plan" class="form-select"><option>Mensual Basico</option><option>Mensual Pro</option><option>Mensual Premium</option></select></div>
      <div class="col-12"><button class="btn btn-primary" type="submit">Registrarse</button></div>
    </form>
  </div>
  <div class="col-md-6">
    <h3>¿Ya tenés cuenta?</h3>
    <p><a href="login.php" class="btn btn-outline-primary">Iniciar sesión</a></p>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
