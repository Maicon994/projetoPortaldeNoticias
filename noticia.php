<?php 
require_once 'header.php'; 

$noticia_id = $_GET['id'] ?? null;

// Lógica de LIKES (Acionada se clicarem no botão curtir)
if (isset($_POST['like']) && isset($_SESSION['user_id'])) {
    try {
        $stmtLike = $pdo->prepare("INSERT INTO likes_noticia (noticia_id, usuario_id) VALUES (?, ?)");
        $stmtLike->execute([$noticia_id, $_SESSION['user_id']]);
    } catch(PDOException $e) {
        // Se o usuário já tiver curtido, desfaz a curtida (Toggle)
        $stmtDeslike = $pdo->prepare("DELETE FROM likes_noticia WHERE noticia_id = ? AND usuario_id = ?");
        $stmtDeslike->execute([$noticia_id, $_SESSION['user_id']]);
    }
    header("Location: noticia.php?id=" . $noticia_id);
    exit;
}

// Lógica de COMENTÁRIOS
if (isset($_POST['comentar']) && isset($_SESSION['user_id']) && !empty(trim($_POST['comentario']))) {
    $stmtCom = $pdo->prepare("INSERT INTO comentarios (noticia_id, usuario_id, comentario) VALUES (?, ?, ?)");
    $stmtCom->execute([$noticia_id, $_SESSION['user_id'], trim($_POST['comentario'])]);
    header("Location: noticia.php?id=" . $noticia_id);
    exit;
}

// Puxar dados da notícia e autor
$stmt = $pdo->prepare("SELECT n.*, u.nome as autor_nome FROM noticias n JOIN usuarios u ON n.autor = u.id WHERE n.id = ?");
$stmt->execute([$noticia_id]);
$n = $stmt->fetch();

if(!$n) { die("<div class='container'><h2>Notícia não encontrada!</h2></div>"); }

// Contagem total de likes
$stmtLikesCount = $pdo->prepare("SELECT COUNT(*) FROM likes_noticia WHERE noticia_id = ?");
$stmtLikesCount->execute([$noticia_id]);
$total_likes = $stmtLikesCount->fetchColumn();

// Puxar comentários associados usando JOIN
$stmtComentarios = $pdo->prepare("SELECT c.*, u.nome FROM comentarios c JOIN usuarios u ON c.usuario_id = u.id WHERE c.noticia_id = ? ORDER BY c.data DESC");
$stmtComentarios->execute([$noticia_id]);
$comentarios = $stmtComentarios->fetchAll();
?>

<div class="container noticia-completa" style="background: white; padding: 2.5rem; border-radius: 8px;">
    <h1><?= htmlspecialchars($n['titulo']) ?></h1>
    <div class="meta">Por: <strong><?= htmlspecialchars($n['autor_nome']) ?></strong> | Em: <?= date('d/m/Y H:i', strtotime($n['data'])) ?></div>
    
    <?php if(!empty($n['imagem'])): ?>
        <img src="<?= htmlspecialchars($n['imagem']) ?>" class="img-noticia" alt="Imagem da notícia">
    <?php endif; ?>

    <div class="noticia-corpo">
        <?= nl2br(htmlspecialchars($n['noticia'])) ?>
    </div>

    <div class="like-box">
        <span>👍 <strong><?= $total_likes ?></strong> pessoas acreditaram nesse boato</span>
        <?php if(isset($_SESSION['user_id'])): ?>
            <form method="POST" style="display:inline;">
                <button type="submit" name="like" class="btn btn-primary btn-sm">Curtir / Descurtir</button>
            </form>
        <?php else: ?>
            <small style="color: gray;">(Faça login para curtir)</small>
        <?php endif; ?>
    </div>

    <div class="comments-section">
        <h3>Comentários (<?= count($comentarios) ?>)</h3>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <form method="POST" style="margin-top: 1rem;">
                <textarea name="comentario" rows="3" placeholder="Deixe sua opinião irônica sobre isso..." required></textarea>
                <button type="submit" name="comentar" class="btn btn-primary">Enviar Comentário</button>
            </form>
        <?php else: ?>
            <p style="margin: 1rem 0; color: gray;">💡 Você precisa estar logado para comentar.</p>
        <?php endif; ?>

        <div style="margin-top: 2rem;">
            <?php foreach($comentarios as $c): ?>
                <div class="comment">
                    <div class="comment-meta"><?= htmlspecialchars($c['nome']) ?> • <span style="font-weight:normal; color:#a0aec0;"><?= date('d/m/Y H:i', strtotime($c['data'])) ?></span></div>
                    <p style="margin-top:0.25rem;"><?= nl2br(htmlspecialchars($c['comentario'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>