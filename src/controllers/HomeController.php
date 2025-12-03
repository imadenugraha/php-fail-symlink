<?php
// src/controllers/HomeController.php

class HomeController {
    public function index() {
        $posts = $this->getPosts();
        View::render('home', ['posts' => $posts]);
    }
    
    private function getPosts() {
        // PROBLEMATIC: Reading from hardcoded STORAGE_PATH
        $dataFile = STORAGE_PATH . '/posts.json';
        
        if (!file_exists($dataFile)) {
            return [];
        }
        
        $json = file_get_contents($dataFile);
        return json_decode($json, true);
    }
}
