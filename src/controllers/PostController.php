<?php
// src/controllers/PostController.php

class PostController {
    public function show() {
        $id = $_GET['id'] ?? 1;
        $post = $this->getPost($id);
        
        if (!$post) {
            http_response_code(404);
            echo "Post not found";
            return;
        }
        
        View::render('post', ['post' => $post]);
    }
    
    private function getPost($id) {
        // PROBLEMATIC: Reading from hardcoded STORAGE_PATH
        $dataFile = STORAGE_PATH . '/posts.json';
        
        if (!file_exists($dataFile)) {
            return null;
        }
        
        $posts = json_decode(file_get_contents($dataFile), true);
        
        foreach ($posts as $post) {
            if ($post['id'] == $id) {
                return $post;
            }
        }
        
        return null;
    }
}
