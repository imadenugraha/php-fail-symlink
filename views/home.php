<?php ob_start(); ?>

<h2>Welcome to Simple Blog</h2>

<div style="margin: 20px 0;">
    <h3>Recent Posts</h3>
    
    <?php if (empty($posts)): ?>
        <p>No posts available.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px;">
                <h4><?= htmlspecialchars($post['title']) ?></h4>
                <p style="color: #666; font-size: 0.9em;">
                    Posted on <?= $post['date'] ?> by <?= htmlspecialchars($post['author']) ?>
                </p>
                <p><?= htmlspecialchars(substr($post['content'], 0, 150)) ?>...</p>
                <a href="/post.php?id=<?= $post['id'] ?>" style="color: #007bff; text-decoration: none;">Read more →</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php 
$content = ob_get_clean();
require VIEWS_PATH . '/layout.php';
?>
