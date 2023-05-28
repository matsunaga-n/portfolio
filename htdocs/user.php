<?php

// 設定ファイル読み込み
require_once '../include/conf/const.php';

// 関数ファイル読み込み
require_once '../include/model/function.php';
require_once '../include/model/user.php';

// データベース接続
$link = get_db_connect();

// ユーザ一覧を取得
$user_data = get_user_data($link);

// データベース切断
close_db_connect($link);

// 特殊文字をHTMLエンティティに変換する
$user_data = entity_assoc_array($user_data);

// テンプレートファイル読み込み
include_once '../include/view/user.php';