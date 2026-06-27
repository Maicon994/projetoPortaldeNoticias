<?php 
require_once 'header.php'; 

if(isset($_SESSION['user_id'])) { header("Location: index.php"); exit; }

$erro = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    if(!empty($nome) && !empty($email) && !empty($_POST['senha'])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senha]);
            header("Location: login.php?sucesso=1");
            exit;
        } catch(PDOException $e) {
            $erro = "E-mail já cadastrado!";
        }
    } else { $erro = "Preencha todos os campos!"; }
}
?>

<div class="form-container">
    <h2>Criar Conta do Detector de Sátiras</h2>
    <?php if($erro): ?><p style="color:var(--accent);"><?= $erro ?></p><?php endif; ?>
    
    <form method="POST">
        <label>Nome Completo</label>
        <input type="text" name="nome" required>
        
        <label>E-mail</label>
        <input type="email" name="email" required>
        
        <label>Senha</label>
        <input type="password" name="senha" required>
        
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>