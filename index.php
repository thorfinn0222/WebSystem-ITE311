<?php
/**
 * This file is used when the .htaccess rewrite rules are not working
 * or when mod_rewrite is not available. It redirects to the public folder.
 */

// Check if we're already in the public directory
if (basename(__DIR__) !== 'public') {
    // Redirect to public folder
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    
    // Redirect to public folder
    header("Location: {$protocol}{$host}{$uri}/public/");
    exit();
}
