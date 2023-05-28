<?php 

// 入力値をチェック
function check_new_user($new_name, $new_password) {
    $err_msg = [];

    if (preg_match("/^[a-zA-Z0-9]{6,20}$/", $new_name) !== 1) {
        $err_msg[] = 'ユーザ名は6文字以上の半角英数字で入力してください';
    }
    if (preg_match("/^[a-zA-Z0-9]{6,20}$/", $new_password) !== 1) {
        $err_msg[] = 'パスワードは6文字以上の半角英数字で入力してください';
    }
    return $err_msg;
}

//新規会員登録
function insert_user_data($link, $new_name, $new_password, $date) {
    $msg = '';
    $err_msg = [];


    $sql = "SELECT id FROM user WHERE user_name = '$new_name'";

    // SQL実行し登録データを配列で取得
    $data = get_as_array($link, $sql);

    //ユーザ名がなければ登録
    if(!isset($data[0]['id'])) {
        $data = [
            'user_name' => $new_name,
            'password' => $new_password,
            'created_date' => $date,
            'updated_date' => $date
        ];
        $sql = 'INSERT INTO user (user_name, password, created_date, updated_date) VALUES(\'' . implode('\',\'', $data) . '\')';
        if (mysqli_query($link, $sql) === TRUE) {
            $msg = '登録が完了しました';
        }
    } else {
        $err_msg[] = '入力した名前は既に存在します';
    }
    return array($msg, $err_msg);
}