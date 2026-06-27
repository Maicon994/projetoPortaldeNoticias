<?php require_once 'config/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>The Fake Times - Portal Satírico</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header>
    <a href="index.php"><h1>The <span>Fake</span> Times</h1></a>
    <nav>
        <a href="index.php">Início</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="nova-noticia.php">Publicar Notícia</a>
            <a href="perfil.php">👤 Meu Perfil (<?= htmlspecialchars($_SESSION['user_nome']) ?>)</a>
            <a href="logout.php" style="color: var(--accent)">Sair</a>
        <?php else: ?>
            <a href="login.php">Entrar</a>
            <a href="cadastro.php">Cadastrar-se</a>
        <?php endif; ?>
    </nav>
</header>