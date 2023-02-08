<?php
require_once('helpers.php');
require_once('functions.php');
require_once('data.php');
require_once('init.php');

$error = mysqli_connect_error();

if ($connection) {
    $sql_category = "SELECT character_code, name_category FROM categories";
    $result_category = mysqli_query($connection, $sql_category);
    $sql_lots = "SELECT lots.title, lots.img, lots.start_price, lots.date_finish, categories.name_category FROM lots JOIN categories ON lots.category_id=categories.id WHERE lots.date_finish < NOW() ORDER BY date_creation DESC";
    $result_lots = mysqli_query($connection, $sql_lots);
    if ($result_category and $result_lots) {
        $categories = mysqli_fetch_all($result_category, MYSQLI_ASSOC);
        $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
    }
} else {
    $error = mysqli_error($connection);
}


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


