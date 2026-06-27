<?php
require_once 'config/config.php';

if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT autor FROM noticias WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch();

// Regra de segurança: Apenas o autor deleta
if($noticia && $noticia['autor'] == $_SESSION['user_id']) {
    $stmt = $pdo->prepare("DELETE FROM noticias WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
?>