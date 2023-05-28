<?php

// 設定ファイル読み込み
require_once '../include/conf/const.php';

// 関数ファイル読み込み
require_once '../include/model/function.php';
require_once '../include/model/signup.php';

// データベース接続
$link = get_db_connect();

// リクエストメソッド確認
if (get_request_method() === 'POST') {

    // 日付を取得
    date_default_timezone_set('Asia/Tokyo');
    $date = date('Y-m-d H:i:s');

    //POSTデータを取得
    $new_name = get_post_data('new_name');
    $new_password = get_post_data('new_passwd');

    // 入力値をチェック
    $err_msg = check_new_user($new_name, $new_password);

    //エラーがなければ新規会員登録をする
    if (count($err_msg) === 0) {
        list($msg, $err_msg) = insert_user_data($link, $new_name, $new_password, $date);
    }
}

// データベース切断
close_db_connect($link);

// テンプレートファイル読み込み
include_once '../include/view/signup.php';