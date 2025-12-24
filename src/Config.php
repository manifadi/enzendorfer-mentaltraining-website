<?php

class Config {
    // Determine if we are on localhost or production
    // Adjust this logic if the production path is different
    public static function getBaseUrl() {
        // Simple detection: if running firmly on localhost/127.0.0.1
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        
        // You might need to adjust the path if the site is in a subdirectory
        // For Cloud86, usually it's the root.
        return $protocol . "://" . $host . "/"; 
    }

    public static function getDataPath() {
        return __DIR__ . '/../data/content.json';
    }

    public static function getUploadsPath() {
        return __DIR__ . '/../assets/uploads/';
    }
}
