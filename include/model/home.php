<?php

// 商品一覧を取得
function get_item_data($link) {
    $sql = 'SELECT item.id, item.img, item.name, item.price, stock.stock FROM item
            LEFT JOIN stock ON item.id = stock.item_id WHERE status = 1 ORDER BY item.id DESC';
    $item_data = get_as_array($link, $sql);
    return $item_data;
}

// ランキングを取得
function get_ranking_data($link) {
    $sql = 'SELECT item.id, item.img, item.name, item.price FROM item
        LEFT JOIN history ON item.id = history.item_id GROUP BY item.id ORDER BY SUM(history.amount) DESC LIMIT 5';
    $ranking_data = get_as_array($link, $sql);
    return $ranking_data;
}

//カートへ追加する処理
function add_to_cart($link, $user_id, $item_id, $date) {
    $msg = '';
    
    $sql = "SELECT id FROM cart WHERE user_id = $user_id AND item_id = $item_id";
    $data = get_as_array($link, $sql);
    if(!isset($data[0]['id'])) {
        $data = [
          'user_id' => $user_id,
          'item_id' => $item_id,
          'amount' => 1,
          'created_date' => $date,
          'updated_date' => $date
        ];
       $sql = 'INSERT INTO cart (user_id, item_id, amount, created_date, updated_date) VALUES(\'' . implode('\',\'', $data) . '\')';
    } else {
       $sql = "UPDATE cart SET amount = amount + 1, updated_date = '$date' WHERE user_id = $user_id AND item_id = $item_id";
    }
    if (mysqli_query($link, $sql) === TRUE) {
       $msg = '商品がカートに追加されました';
    }
    return $msg;
}