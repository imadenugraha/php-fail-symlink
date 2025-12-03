<?php ob_start(); ?>

<div style="margin: 20px 0;">
    <h2><?= htmlspecialchars($post['title']) ?></h2>
    
    <p style="color: #666; font-size: 0.9em; margin: 10px 0;">
        Posted on <?= $post['date'] ?> by <?= htmlspecialchars($post['author']) ?>
    </p>
    
    <div style="margin: 20px 0; line-height: 1.8;">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>
    
    <a href="/index.php" style="color: #007bff; text-decoration: none;">← Back to home</a>
</div>

<?php 
$content = ob_get_clean();
require VIEWS_PATH . '/layout.php';
?>
