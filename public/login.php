<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioEmail = strtolower(trim($_POST['usuarioEmail'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($usuarioEmail && $password) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE LOWER(usuario)=:usuario OR LOWER(email)=:email");
        $stmt->execute([
            'usuario' => $usuarioEmail,
            'email' => $usuarioEmail
        ]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // ESTA ES LA CLAVE: Establece la variable de sesión 'usuario'
            $_SESSION['usuario'] = [ 
                'id' => $user['id'],
                'nombre' => $user['nombre'],
                'apellido' => $user['apellido'],
                'usuario' => $user['usuario'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            header('Location: index.php');
            exit;
        } else {
            $msg = 'Usuario/Email o contraseña incorrectos.';
        }
    } else {
        $msg = 'Completa usuario/email y contraseña.';
    }
}

include __DIR__ . '/../includes/header.php';
?>
<div class="row">
    <div class="col-md-6">
        <h2>Iniciar sesión</h2>
        <?php if($msg): ?><div class="alert alert-danger"><?=htmlspecialchars($msg)?></div><?php endif; ?>
        <form method="post" class="row g-3">
            <div class="col-md-6"><input name="usuarioEmail" class="form-control" placeholder="Usuario o Email" required></div>
            <div class="col-md-6"><input type="password" name="password" class="form-control" placeholder="Contraseña" required></div>
            <div class="col-12"><button class="btn btn-primary">Ingresar</button></div>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
