<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");

$categories = get_categories($con);

$page_404 = include_template("404.php", [
    "categories" => $categories
]);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    $sql = get_query_lot($id);
} else {
    print($page_404);
    die();
};

$res = mysqli_query($con, $sql);
if ($res) {
    $lot = get_arrow($res);
} else {
    $error = mysqli_error($con);
}

if (!$lot) {
    print($page_404);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = filter_input_array(INPUT_POST, ["cost" => FILTER_DEFAULT]);
    $last_bet_price = get_last_bet_price($con, $id)["price_bet"];
    $current_price = ($last_bet_price) ? $last_bet_price + $lot["step"] : $lot["start_price"];

    $error = validate_bet($data["cost"], $current_price);


    if (!$error) {
        $sql = get_query_create_bet($user_id, $id);
        $stmt = db_get_prepare_stmt_version($con, $sql, $data);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            header("Location: /bets.php");
        } else {
            $error = mysqli_error($con);
        }
    }

}


$page_content = include_template("main-lot.php", [
    "categories" => $categories,
    "lot" => $lot,
    "error" => $error,
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);
$layout_content = include_template("layout-pages.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => $lot["title"],
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);

print($layout_content);



