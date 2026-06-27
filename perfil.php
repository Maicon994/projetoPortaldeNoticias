<?php 
require_once 'header.php'; 

if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$msg = "";
$userId = $_SESSION['user_id'];

// Carrega dados atuais
$stmt = $pdo->prepare("SELECT nome, email FROM usuarios WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['atualizar'])) {
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        
        if(!empty($nome) && !empty($email)) {
            $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
            $stmt->execute([$nome, $email, $userId]);
            $_SESSION['user_nome'] = $nome; // Atualiza nome da barra do topo
            $msg = "Perfil atualizado com sucesso!";
            header("Refresh:1; url=perfil.php");
        }
    } elseif (isset($_POST['deletar_conta'])) {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$userId]);
        session_destroy();
        header("Location: index.php");
        exit;
    }
}
?>

<div class="form-container">
    <h2>👤 Gerenciar Meu Perfil</h2>
    <?php if($msg): ?><p style="color:green;"><?= $msg ?></p><?php endif; ?>
    
    <form method="POST">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($user['nome']) ?>" required>
        
        <label>E-mail</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        
        <button type="submit" name="atualizar" class="btn btn-primary">Salvar Alterações</button>
        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #ccc;">
        <h3>⚠️ Zona de Perigo</h3>
        <p style="font-size:0.85rem; color: gray; margin-bottom:1rem;">Ao apagar a conta, todas as suas notícias e curtidas serão deletadas do sistema permanentemente.</p>
        <button type="submit" name="deletar_conta" class="btn btn-accent" onclick="return confirm('Certeza absoluta de que quer apagar sua conta?')">Deletar Minha Conta</button>
    </form>
</div>