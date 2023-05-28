<?php

// カート一覧を取得
function get_cart_cata($link, $user_id) {
    $sql = "SELECT cart.item_id, item.img, item.name, item.price, cart.amount FROM item
        LEFT JOIN cart ON item.id = cart.item_id WHERE cart.user_id = $user_id AND cart.amount >= 1";
    $cart_data = get_as_array($link, $sql);
    return $cart_data;
}

// 数量変更
function change_amount($link, $user_id, $item_id, $date, $update_amount) {
   $msg = '';
   $err = '';

   if (mb_strlen($update_amount) === 0) {
      $err = '数量を入力してください';
   } elseif (preg_match('/^([1-9]\d*)$/', $update_amount) !== 1) {
      $err = '数量は0以上の整数を入力してください';
   } else {
      $sql = "UPDATE cart SET amount = $update_amount, updated_date = '$date' WHERE user_id = $user_id AND item_id = $item_id";
      if (mysqli_query($link, $sql) === TRUE) {
         $msg = '数量を変更しました';
      }
   }
   return array($msg, $err);
}

//カートから削除
function delete_amount($link, $user_id, $item_id) {
   $msg = '';

   $sql = "UPDATE cart SET amount = 0 WHERE user_id = $user_id AND item_id = $item_id";
   if (mysqli_query($link, $sql) === TRUE) {
      $msg = 'カートから削除しました';
   }
   return $msg;   
}