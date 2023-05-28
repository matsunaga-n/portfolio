<?php

// 設定ファイル読み込み
require_once '../include/conf/const.php';

// 関数ファイル読み込み
require_once '../include/model/function.php';
require_once '../include/model/cart.php';

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
   $sql_kind = get_post_data('sql_kind');
   $item_id = get_post_data('item_id');

   //数量を変更する処理
   if ($sql_kind === 'update') {

      // POSTデータを取得
      $update_amount = get_post_data('update_amount');

      // 数量を変更
      list($msg, $err) = change_amount($link, $user_id, $item_id, $date, $update_amount);
   }

   // カートから商品を削除する処理
   if ($sql_kind === 'delete') {

      // 商品を削除
      $msg = delete_amount($link, $user_id, $item_id);
   }
}

// カート一覧を取得
$cart_data = get_cart_cata($link, $user_id);

// 合計金額を取得
list($tax_included_price, $tax_excluded_price, $tax) = get_total_price($cart_data);

// データベース切断
close_db_connect($link);

// 特殊文字をHTMLエンティティに変換する
$cart_data = entity_assoc_array($cart_data);

// テンプレートファイル読み込み
include_once '../include/view/cart.php';