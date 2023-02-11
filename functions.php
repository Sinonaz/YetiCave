<?php
function format_price($price): string
{
    if ($price < 1000) {
        return $price . ' ₽';
    } else {
        return number_format(ceil($price), $decimals = 0, $decimal_separator = ".", $thousands_separator = " ") . ' ₽';
    }
}

function get_time_left($date)
{
    date_default_timezone_set('Europe/Moscow');
    $final_date = date_create($date);
    $cur_date = date_create("now");
    $diff = date_diff($final_date, $cur_date);
    $format_diff = date_interval_format($diff, "%d %H %I");
    $arr = explode(" ", $format_diff);

    $hours = $arr[0] * 24 + $arr[1];
    $minutes = intval($arr[2]);
    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
    $res[] = $hours;
    $res[] = $minutes;

    return $res;
}

function get_categories($connection)
{
    if (!$connection) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT character_code, name_category FROM categories";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $categories;
        } else {
            $error = mysqli_error($connection);
            return $error;
        }
    }

}

function get_lots($connection)
{
    if (!$connection) {
        $error = mysqli_connect_error();
        return $error;
    } else {
        $sql = "SELECT lots.id, lots.title, lots.img, lots.start_price, lots.date_finish, categories.name_category FROM lots JOIN categories ON lots.category_id=categories.id WHERE lots.date_finish > NOW() ORDER BY date_creation DESC";
        $result = mysqli_query($connection, $sql);
        if ($result) {
            $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return $lots;
        } else {
            $error = mysqli_error($connection);
            return $error;
        }
    }

}

function get_query_lot($lot_id)
{
    return "SELECT lots.title, lots.start_price, lots.img, lots.date_finish, lots.lot_description, categories.name_category FROM lots JOIN categories ON lots.category_id=categories.id WHERE lots.id=$lot_id";
}