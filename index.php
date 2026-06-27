<?php
require_once 'header.php';

$logado = isset($_SESSION['user_id']);

if ($logado) {
    // REQUISITO: Usuário logado vê as notícias que ele criou E as notícias padrão do sistema (Autor ID 1)
    $stmt = $pdo->prepare("
        SELECT n.*, u.nome as autor_nome,
        (SELECT COUNT(*) FROM likes_noticia WHERE noticia_id = n.id) as total_likes,
        (SELECT COUNT(*) FROM comentarios WHERE noticia_id = n.id) as total_comentarios
        FROM noticias n 
        JOIN usuarios u ON n.autor = u.id 
        WHERE n.autor = ? OR n.autor = 1
        ORDER BY n.data DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
} else {
    // REQUISITO: Usuário deslogado vê absolutamente todas as notícias do portal
    $stmt = $pdo->query("
        SELECT n.*, u.nome as autor_nome,
        (SELECT COUNT(*) FROM likes_noticia WHERE noticia_id = n.id) as total_likes,
        (SELECT COUNT(*) FROM comentarios WHERE noticia_id = n.id) as total_comentarios
        FROM noticias n 
        JOIN usuarios u ON n.autor = u.id 
        ORDER BY n.data DESC
    ");
}
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2><?= $logado ? "📰 Seu Feed (Notícias do Sistema + Suas Publicações)" : "🌍 Últimas do Mundo Inteiro (Modo Público)" ?></h2>

    <?php if (empty($noticias)): ?>
        <p style="margin-top:2rem;">Nenhuma notícia encontrada por aqui ainda...</p>
    <?php else: ?>
        <div class="news-grid">
            <?php foreach ($noticias as $n): ?>
                <div class="news-card">
                    <h2><a href="noticia.php?id=<?= $n['id'] ?>"><?= htmlspecialchars($n['titulo']) ?></a></h2>
                    <div class="meta">
                        Por: <strong><?= htmlspecialchars($n['autor_nome']) ?></strong> |
                        Postado em: <?= date('d/m/Y H:i', strtotime($n['data'])) ?> |
                        👍 <?= $n['total_likes'] ?> Likes | 💬 <?= $n['total_comentarios'] ?> Comentários
                    </div>
                    <p><?= htmlspecialchars(substr($n['noticia'], 0, 180)) ?>...</p>

                    <div class="news-actions">
                        <a href="noticia.php?id=<?= $n['id'] ?>" class="btn btn-primary btn-sm">Ler Mais</a>

                        <?php if ($logado && $n['autor'] == $_SESSION['user_id']): ?>
                            <a href="editar-noticia.php?id=<?= $n['id'] ?>" class="btn btn-sm" style="background:#ecc94b; color:black;">Editar</a>
                            <a href="deletar-noticia.php?id=<?= $n['id'] ?>" class="btn btn-accent btn-sm" onclick="return confirm('Apagar notícia de verdade?')">Excluir</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>

</html>
