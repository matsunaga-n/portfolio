<?php

// 設定ファイル読み込み
require_once '../include/conf/const.php';

// 関数ファイル読み込み
require_once '../include/model/function.php';

// リクエストメソッド確認
if (get_request_method() !== 'POST') {

   // POSTでなければログインページへリダイレクト
   header('Location: top.php');
   exit;
}

// セッション開始
session_start();

// POST値取得
$user_name  = get_post_data('user_name');
$passwd = get_post_data('passwd');

// ユーザ名をCookieへ保存
setcookie('user_name', $user_name, time() + 60 * 60 * 24 * 365);

// データベース接続
$link = get_db_connect();

// メールアドレスとパスワードからuser_idを取得するSQL
$sql = "SELECT id FROM user WHERE user_name = '$user_name' AND password = '$passwd'";

// SQL実行し登録データを配列で取得
$data = get_as_array($link, $sql);

// データベース切断
close_db_connect($link);

// 登録データを取得できたか確認
if (($user_name === 'root') && ($passwd === 'root')) {
   header('Location: tool.php');
} elseif (isset($data[0]['id'])) {
   // セッション変数にuser_idを保存
   $_SESSION['user_id'] = $data[0]['id'];
   // ログイン済みユーザのホームページへリダイレクト
   header('Location: home.php');
   exit;
} else {
   // セッション変数にログインのエラーフラグを保存
   $_SESSION['login_err_flag'] = TRUE;
   // ログインページへリダイレクト
   header('Location: top.php');
   exit;
}