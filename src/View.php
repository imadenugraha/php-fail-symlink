<?php
// src/View.php
// View renderer using hardcoded paths from config

class View {
    public static function render($viewName, $data = []) {
        // Uses hardcoded VIEWS_PATH from config
        $viewFile = VIEWS_PATH . '/' . $viewName . '.php';
        
        if (!file_exists($viewFile)) {
            throw new Exception("View file not found: $viewFile (VIEWS_PATH: " . VIEWS_PATH . ")");
        }
        
        extract($data);
        require $viewFile;
    }
    
    public static function renderPartial($partialName, $data = []) {
        self::render('partials/' . $partialName, $data);
    }
}
