<?php

// 設定ファイル読み込み
require_once '../include/conf/const.php';

// 関数ファイル読み込み
require_once '../include/model/function.php';
require_once '../include/model/home.php';

// セッション開始
session_start();

// ユーザIDを取得
$user_id = get_user_id();

// データベース接続
$link = get_db_connect();

// ユーザ名を取得
$user_name = get_user_name($link, $user_id);

// リクエストメソッド確認
if (get_request_method() === 'POST') {
   
   // 日付を取得
   date_default_timezone_set('Asia/Tokyo');
   $date = date('Y-m-d H:i:s');

   // POSTデータを取得
   $item_id = get_post_data('item_id');

   // カートに追加
   $msg = add_to_cart($link, $user_id, $item_id, $date);
}

// 商品一覧を取得
$item_data = get_item_data($link);

// ランキングを取得
$ranking_data = get_ranking_data($link);

// データベース切断
close_db_connect($link);

// 特殊文字をHTMLエンティティに変換する
$item_data = entity_assoc_array($item_data);

// テンプレートファイル読み込み
include_once '../include/view/home.php';