<?php
require_once('helpers.php');
require_once('init.php');
require_once('functions.php');
require_once('data.php');

$categories = get_categories($connection);

$lots = get_lots($connection);


$content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'title' => 'Главная',
]);

print($layout);


