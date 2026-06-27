<?php 
require_once 'header.php'; 

if(isset($_SESSION['user_id'])) { header("Location: index.php"); exit; }

$erro = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];
        header("Location: index.php");
        exit;
    } else {
        $erro = "E-mail ou senha incorretos!";
    }
}
?>

<div class="form-container">
    <h2>Entrar no Portal</h2>
    <?php if(isset($_GET['sucesso'])): ?><p style="color:green;">Cadastro feito! Faça login.</p><?php endif; ?>
    <?php if($erro): ?><p style="color:var(--accent);"><?= $erro ?></p><?php endif; ?>
    
    <form method="POST">
        <label>E-mail</label>
        <input type="email" name="email" required>
        
        <label>Senha</label>
        <input type="password" name="senha" required>
        
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>