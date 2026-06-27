<?php 
require_once 'header.php'; 

if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $noticia = trim($_POST['noticia']);
    $imagem = trim($_POST['imagem']); // Pode ser uma URL de imagem do Google

    if(!empty($titulo) && !empty($noticia)) {
        $stmt = $pdo->prepare("INSERT INTO noticias (titulo, noticia, imagem, autor) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $noticia, !empty($imagem) ? $imagem : null, $_SESSION['user_id']]);
        header("Location: index.php");
        exit;
    }
}
?>

<div class="container" style="max-width: 700px; background: white; padding: 2rem; border-radius:8px;">
    <h2>Espalhar Nova Notícia Falsa</h2>
    <form method="POST">
        <label>Título Escandaloso</label>
        <input type="text" name="titulo" placeholder="Ex: ET de Varginha é eleito síndico de prédio em SP" required>
        
        <label>URL de Imagem Ilustrativa (Opcional)</label>
        <input type="url" name="imagem" placeholder="https://linkdaimagem.com/foto.jpg">
        
        <label>Corpo da Notícia</label>
        <textarea name="noticia" rows="8" placeholder="Escreva a sátira aqui..." required></textarea>
        
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>
</div>