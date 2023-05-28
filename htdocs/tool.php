<?php

// 設定ファイル読み込み
require_once '../include/conf/const.php';

// 関数ファイル読み込み
require_once '../include/model/function.php';
require_once '../include/model/tool.php';

// データベース接続
$link = get_db_connect();

// リクエストメソッド確認
if (get_request_method() === 'POST') {

    // 日付を取得
    date_default_timezone_set('Asia/Tokyo');
    $date = date('Y-m-d H:i:s');

    // POSTデータを取得
    $sql_kind = get_post_data('sql_kind');
    $item_id = get_post_data('item_id');

    // 新規商品を追加する処理
    if ($sql_kind === 'insert') {

        // POSTデータを取得
        $new_name = get_post_data('new_name');
        $new_price = get_post_data('new_price');
        $new_stock = get_post_data('new_stock');
        $new_status = get_post_data('new_status');

        // ファイルのアップロード
        list($new_img, $file_err) = get_file_data('new_img');

        // エラーチェック
        $err_msg = check_new_item($new_name, $new_price, $new_stock, $file_err, $new_status);

        // エラーがなければ新規商品を追加
        if (count($err_msg) === 0) {
            $msg = insert_item_data($link, $new_name, $new_price, $new_img, $new_status, $new_stock, $date);
        } 
    }

    //在庫数を変更する処理
    if ($sql_kind === 'update') {

        // POSTデータを取得
        $update_stock = get_post_data('update_stock');

        // 在庫数を変更
        list($msg, $err_msg) = change_stock($link, $item_id, $date, $update_stock);
    }

    //ステータスを変更する処理
    if ($sql_kind === 'change') {

        // POSTデータを取得
        $change_status = get_post_data('change_status');

        // ステータスを変更
        $msg = change_status($link, $item_id, $date, $change_status);
    }

    // データを削除する処理
    if ($sql_kind === 'delete') {

        //データを削除
        $msg = delete_item_data($link, $item_id);
    }
}
    
//商品一覧を取得
$item_data = get_item_list($link);

// データベース切断
close_db_connect($link);

// 特殊文字をHTMLエンティティに変換する
$item_data = entity_assoc_array($item_data);

// テンプレートファイル読み込み
include_once '../include/view/tool.php';