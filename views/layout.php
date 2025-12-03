<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; max-width: 800px; margin: 0 auto; }
        header { background: #333; color: #fff; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        h1 { font-size: 2em; }
        .alert { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .alert-info { background: #d1ecf1; border: 1px solid #bee5eb; }
        .alert-danger { background: #f8d7da; border: 1px solid #f5c6cb; }
        footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; }
    </style>
</head>
<body>
    <header>
        <h1><?= APP_NAME ?></h1>
        <p>Version <?= APP_VERSION ?></p>
    </header>
    
    <?php if (DEBUG): ?>
    <div class="alert alert-info">
        <strong>Debug Mode:</strong> BASE_PATH = <?= BASE_PATH ?>
    </div>
    <?php endif; ?>
    
    <main>
        <?= $content ?>
    </main>
    
    <footer>
        <p>&copy; 2025 <?= APP_NAME ?></p>
    </footer>
</body>
</html>
