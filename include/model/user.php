<?php

// ユーザ一覧を取得
function get_user_data($link) {
    $sql = 'SELECT user_name, created_date FROM user';
    $user_data = get_as_array($link, $sql);
    return $user_data;
}