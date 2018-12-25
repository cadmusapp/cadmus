<?php

/**
 * Define an accessible path to the root
 * of the application.
 */
define("APP_ROOT", "./");

/**
 * Require a bootstrap file.
 */
require APP_ROOT . "bootstrap.php";

/**
 * Start the body
 */
$identifier = $_SERVER['REQUEST_URI'];
$identifier_plain = preg_replace('/\\?.*/', '', $identifier);
if (empty($identifier_plain) || $identifier_plain == '/') {
    /**
     * Require the header partial file.
     */
    require APP_ROOT . "partials/header.php";
    require APP_ROOT . "partials/home.php";
} else {
    // Determine if a published post with this slug exists
    $slug = trim($identifier_plain, "/");
    $file = $slug . ".1.txt";
    $path = APP_ROOT . "content/" . $file;
    if (!is_file($path)) {
        echo "<p>This page does not exist. Perhaps you followed a broken link?</p>";
        echo "<a href=\"" . APP_ROOT . "\">Return Home</a>";
        exit;
    }
    $title = get_meta($path, "Title");
    /**
     * Require the header partial file.
     */
    require APP_ROOT . "partials/header.php";
    require APP_ROOT . "partials/view.php";
}

/**
 * Include the footer
 */
require APP_ROOT . "partials/footer.php";
