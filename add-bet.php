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

$bets = get_bets($con);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = filter_input(INPUT_POST, "cost", FILTER_DEFAULT);

    if ($data) {
        $data = validate_bet($data);
        console_log($data);
        console_log($bets);
    } else {
        console_log("no data given");
    }

}

$categories = get_categories($con);


$layout_content = include_template("layout-pages.php", [
    "content" => $page_content,
    "categories" => $categories,
    "is_auth" => $is_auth,
    "title" => "Добавить лот",
    "user_name" => $user_name
]);


print($page_head);
print($layout_content);


