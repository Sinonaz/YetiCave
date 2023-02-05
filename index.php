<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');

$content = include_template('main.php', [
    'categories' => $categories,
    'advertisements' => $advertisements,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'title' => 'Главная',
]);

print($layout);

