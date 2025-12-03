<?php
// public/post.php
// Post detail page - PROBLEMATIC: Uses relative paths

// PROBLEMATIC: Relative path to config
require_once '../config/config.php';

// PROBLEMATIC: Relative paths to dependencies
require_once '../src/Router.php';
require_once '../src/View.php';

try {
    $router = new Router();
    
    // Define routes
    $router->get('/post.php', 'PostController@show');
    
    // Dispatch
    $router->dispatch('/post.php');
    
} catch (Exception $e) {
    http_response_code(500);
    echo "<h1>Error</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>This error occurs because:</strong></p>";
    echo "<ul>";
    echo "<li>Hardcoded paths in config.php don't match the deployment location</li>";
    echo "<li>Relative paths break when accessed through symlinks</li>";
    echo "</ul>";
    if (DEBUG) {
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
}
