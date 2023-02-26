<?php
require_once("helpers.php");
require_once("functions.php");
require_once("data.php");
require_once("init.php");
require_once("models.php");


$categories = get_categories($con);

$users_data = get_users_data($con);
$emails = array_column($users_data, "email");

$page_content = include_template("main-login.php", [
    "categories" => $categories
]);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ["email", "password"];
    $errors = [];

    $rules = [
        "email" => function ($value) use ($emails) {
            return verify_email($value, $emails);
        }
    ];

    $user = filter_input_array(INPUT_POST,
        [
            "email" => FILTER_DEFAULT,
            "password" => FILTER_DEFAULT,
        ], true);

    foreach ($user as $field => $value) {
        if (isset($rules[$field])) {
            $rule = $rules[$field];
            $errors[$field] = $rule($value);
        }
        if (in_array($field, $required) && empty($value)) {
            $errors[$field] = "Поле $field нужно заполнить";
        }
    }

    $errors = array_filter($errors);


    if (count($errors)) {
        $page_content = include_template("main-login.php", [
            "categories" => $categories,
            "user" => $user,
            "errors" => $errors
        ]);
    } else {
        $user_data = get_login($con, $user["email"]);

        if (password_verify($user["password"], $user_data["user_password"])) {
            $start_session = session_start();
            $_SESSION['name'] = $user_data["user_name"];
            $_SESSION['id'] = $user_data["id"];

            header("Location: /index.php");
        } else {
            $errors["password"] = "Неверный пароль";
        }

        if (count($errors)) {
            $page_content = include_template("main-login.php", [
                "categories" => $categories,
                "user" => $user,
                "errors" => $errors,
            ]);
        }
    }
}


$layout_content = include_template("layout-pages.php", [
    "content" => $page_content,
    "categories" => $categories,
    "title" => "Войти",
    "is_auth" => $is_auth,
    "user_name" => $user_name
]);


print($layout_content);


