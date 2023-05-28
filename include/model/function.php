<?php

/*
--------------------共通--------------------
*/

// DBハンドルを取得
function get_db_connect() {
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
    mysqli_set_charset($link, DB_CHARACTER_SET);
    return $link;
}

// DBとのコネクション切断
function close_db_connect($link) {
    mysqli_close($link);
}

// 特殊文字をHTMLエンティティに変換する
function entity_str($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

// 特殊文字をHTMLエンティティに変換する
function entity_assoc_array($assoc_array) {
    foreach ($assoc_array as $key => $value) {
        foreach ($value as $keys => $values) {
            $assoc_array[$key][$keys] = entity_str($values);
        }
    }
    return $assoc_array;
}

// リクエストメソッドを取得
function get_request_method() {
    return $_SERVER['REQUEST_METHOD'];
}

// POSTデータを取得
function get_post_data($key) {
    $str = '';
    if (isset($_POST[$key]) === TRUE) {
        $str = trim($_POST[$key]);
    }
    return $str;
}

// クエリを実行しその結果を配列で取得する
function get_as_array($link, $sql) {
    $data = [];
    if ($result = mysqli_query($link, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        mysqli_free_result($result);
    }
    return $data;
}

// セッション変数からuser_id取得
function get_user_id() {
    if (isset($_SESSION['user_id']) === TRUE) {
       $user_id = $_SESSION['user_id'];
    } else {
       // 非ログインの場合、ログインページへリダイレクト
       header('Location: top.php');
       exit;
    }
    return $user_id;
}

// ユーザ名を取得
function get_user_name($link, $user_id) {
    $sql = "SELECT user_name FROM user WHERE id = $user_id";
    $data = get_as_array($link, $sql);
    if (isset($data[0]['user_name'])) {
       $user_name = $data[0]['user_name'];
    } else {
       header('Location: logout.php');
       exit;
    }
    return $user_name;
}

// 合計金額を取得
function get_total_price($data) {
    foreach ($data as $value) {
          $price = $value['price'] * $value['amount'];
          $tax_excluded_price += $price;
          $tax = $tax_excluded_price * 0.1;
          $tax_included_price = $tax_excluded_price + $tax;
    }
    return array($tax_included_price, $tax_excluded_price, $tax);
}