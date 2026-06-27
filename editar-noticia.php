<?php 
require_once 'header.php'; 

if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch();

// Regra de segurança: Apenas o autor edita
if(!$noticia || $noticia['autor'] != $_SESSION['user_id']) {
    die("Você não tem permissão para editar essa notícia.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $corpo = trim($_POST['noticia']);
    $imagem = trim($_POST['imagem']);

    if(!empty($titulo) && !empty($corpo)) {
        $stmt = $pdo->prepare("UPDATE noticias SET titulo = ?, noticia = ?, imagem = ? WHERE id = ?");
        $stmt->execute([$titulo, $corpo, !empty($imagem) ? $imagem : null, $id]);
        header("Location: index.php");
        exit;
    }
}
?>

<div class="container" style="max-width: 700px; background: white; padding: 2rem; border-radius:8px;">
    <h2>Corrigir Boato (Editar Notícia)</h2>
    <form method="POST">
        <label>Título</label>
        <input type="text" name="titulo" value="<?= htmlspecialchars($noticia['titulo']) ?>" required>
        
        <label>URL da Imagem</label>
        <input type="url" name="imagem" value="<?= htmlspecialchars($noticia['imagem'] ?? '') ?>">
        
        <label>Corpo da Notícia</label>
        <textarea name="noticia" rows="8" required><?= htmlspecialchars($noticia['noticia']) ?></textarea>
        
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>