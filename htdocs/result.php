<?php

// 設定ファイル読み込み
require_once '../include/conf/const.php';

// 関数ファイル読み込み
require_once '../include/model/function.php';
require_once '../include/model/result.php';

// セッション開始
session_start();

// ユーザIDを取得
$user_id = get_user_id();

// データベース接続
$link = get_db_connect();

// ユーザ名を取得
$user_name = get_user_name($link, $user_id);

// 購入履歴一覧を取得
$result_data = get_result_data($link, $user_id);

// 合計金額を取得
list($tax_included_price, $tax_excluded_price, $tax) = get_total_price($result_data);

// 在庫数が足りているか確認
$err_msg = check_item_stock($link, $result_data);

// エラーがなければ購入後の処理を実行
if (count($err_msg) === 0) {
    after_ordering($link, $user_id, $result_data);
}

// データベース切断
close_db_connect($link);

// 特殊文字をHTMLエンティティに変換する
$result_data = entity_assoc_array($result_data);

// テンプレートファイル読み込み
include_once '../include/view/result.php';