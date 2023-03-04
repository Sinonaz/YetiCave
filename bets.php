<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

if (!$is_auth) {
    http_response_code(403);
}

if (http_response_code() !== 200) {
    header("Location: /templates/404.html");
}

$categories = get_categories($con);

$bets = get_query_bets($con, $user_id);


console_log($bets);


$page_content = include_template("main-bets.php", [
    "bets" => $bets
]);

$layout_content = include_template("layout-pages.php", [
    "content" => $page_content,
    "categories" => $categories,
    "is_auth" => $is_auth,
    "title" => "Мои ставки",
    "user_name" => $user_name
]);


print($page_head);
print($layout_content);


