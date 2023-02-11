<?php

require_once('helpers.php');
require_once('functions.php');
require_once('data.php');
require_once('init.php');

$categories = get_categories($connection);

$page_404 = include_template("404.php", [
    "categories" => $categories
]);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id) {
    print($page_404);
    die();
} else {
    $sql = get_query_lot($id);
}

$result = mysqli_query($connection, $sql);

if ($result) {
    $lot = mysqli_fetch_assoc($result);
} else {
    $error = mysqli_error($connection);
}

if (!$lot) {
    print($page_404);
    die();
}

$page_content = include_template('lot/lot.php', [
    'categories' => $categories,
    'lot' => $lot
]);

$layout = include_template('lot/layout-lot.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $lot['title']
]);

print($layout);