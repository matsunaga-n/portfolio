<?php

//  購入結果を取得
function get_result_data($link, $user_id) {
    $sql = "SELECT cart.item_id, item.img, item.name, item.price, cart.amount, stock.stock FROM item
          LEFT JOIN cart ON item.id = cart.item_id
          LEFT JOIN stock ON cart.item_id = stock.item_id
          WHERE cart.user_id = $user_id AND cart.amount >= 1";
    $result_data = get_as_array($link, $sql);
    return $result_data;
}

// 在庫数が足りているか確認
function check_item_stock($link, $result_data) {
   $err_msg = [];

   foreach ($result_data as $result) {
      $name = $result['name'];
      $stock = $result['stock'];
      $amount = $result['amount'];

      if ($amount > $stock) {
         $err_msg[] = '「'.$name.'」は'.$stock.'点のみ購入可能です';
      }
   }
   return $err_msg;
}

// 購入後の処理
function after_ordering($link, $user_id, $result_data) {

   foreach ($result_data as $result) {
 
      date_default_timezone_set('Asia/Tokyo');
      $date = date('Y-m-d H:i:s');
   
      $item_id = $result['item_id'];
      $amount = $result['amount'];
      $stock = $result['stock'];

      mysqli_autocommit($link, false); //トランザクション開始(オートコミットをオフ)

      $sql = "UPDATE stock SET stock = $stock - $amount, updated_date = '$date' WHERE item_id = $item_id";
      if (mysqli_query($link, $sql) === TRUE) {
         $sql = "UPDATE cart SET amount = 0, updated_date = '$date' WHERE user_id = $user_id AND item_id = $item_id";
         if (mysqli_query($link, $sql) === TRUE) {
            $data = [
               'user_id' => $user_id,
               'item_id'  => $item_id,
               'amount' => $amount,
               'purchased_date' => $date,
           ];
            $sql = 'INSERT INTO history (user_id, item_id, amount, purchased_date) VALUES(\'' . implode('\',\'', $data) . '\')';
            if (mysqli_query($link, $sql) === TRUE) {
               mysqli_commit($link); //処理確定(コミット)
            } else {
               mysqli_rollback($link); //処理取消(ロールバック)
            }
         } else {
            mysqli_rollback($link); //処理取消(ロールバック)
         }
      } else {
         mysqli_rollback($link); //処理取消(ロールバック)
      }
   }
}