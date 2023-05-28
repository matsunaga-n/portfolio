<?php

//商品一覧を取得
function get_item_list($link) {
    $sql = "SELECT stock.item_id, item.img, item.name, item.price, stock.stock, item.status FROM item
        LEFT JOIN stock ON item.id = stock.item_id";
    $item_data = get_as_array($link, $sql);
    return $item_data;
}

// ファイルのアップロード
function get_file_data($key) {
    $file_err = '';

    $tmp_file = $_FILES[$key]['tmp_name'];
    if (is_uploaded_file($tmp_file)) {
        if (count($err_msg) === 0) {
            $new_img = sha1(uniqid(mt_rand(), true)) . '.' . $_FILES[$key]['name'];
            $upload = '../img/' . $new_img;
            $extension = pathinfo($new_img, PATHINFO_EXTENSION);

            if ($extension === 'jpeg' || $extension === 'png') {
                if (file_exists($upload) ) {
                    $file_err = '同名のファイルが存在します';
                } else {
                    move_uploaded_file($tmp_file, $upload);
                }
            } else {
                $file_err = 'ファイル形式が異なります。画像ファイルはJPEG又はPNGのみ利用可能です';
            }
        }
    } else {
        $file_err = 'ファイルを選択してください';
    }
    return array($new_img, $file_err);
}

//入力値をチェック
function check_new_item($new_name, $new_price, $new_stock, $file_err, $new_status) {
    $err_msg = [];

    //　商品名
    if (mb_strlen($new_name) === 0) {
        $err_msg[] = '名前を入力してください';
    }

    // 価格
    if (mb_strlen($new_price) === 0) {
        $err_msg[] = '価格を入力してください';
    } elseif (preg_match('/^([1-9]\d*)$/', $new_price) !== 1) {
        $err_msg[] = '価格は0以上の整数を入力してください';
    }
    
    // 在庫数
    if (mb_strlen($new_stock) === 0) {
        $err_msg[] = '在庫数を入力してください';
    } elseif (preg_match('/^([1-9]\d*)$/', $new_stock) !== 1) {
        $err_msg[] = '在庫数は0以上の整数を入力してください';
    }

    // 画像ファイル
    if ($file_err !== '') {
        $err_msg[] = $file_err;
    }

    // 公開ステータス
    if ($new_status !== '0' && $new_status !== '1') {
        $err_msg[] = 'ステータスを選択してください';   
    }

    return $err_msg;
}

// 新規商品を追加
function insert_item_data($link, $new_name, $new_price, $new_img, $new_status, $new_stock, $date) {
    $msg = '';

    mysqli_autocommit($link, false); //トランザクション開始(オートコミットをオフ)

    $data = [
        'name' => $new_name,
        'price'  => $new_price,
        'img' => $new_img,
        'status' => $new_status,
        'created_date' => $date,
        'updated_date' => $date
    ];

    $sql = 'INSERT INTO item (name, price, img, status, created_date, updated_date) VALUES(\'' . implode('\',\'', $data) . '\')';
    if (mysqli_query($link, $sql) === TRUE) {

        $sql = "SELECT id FROM stock";
        if ($result = mysqli_query($link, $sql)) {
            $row = mysqli_num_rows($result);
            $item_id = $row + 1;
        }
        
        $data = [
            'item_id' => $item_id,
            'stock' => $new_stock,
            'created_date' => $date,
            'updated_date' => $date
        ];
        $sql = 'INSERT INTO stock (item_id, stock, created_date, updated_date) VALUES(\'' . implode('\',\'', $data) . '\')';
        if (mysqli_query($link, $sql) === TRUE) {
            $msg = '商品を追加しました';
            mysqli_commit($link); //処理確定(コミット)
        } else {
            mysqli_rollback($link); //処理取消(ロールバック)
        }
    } else {
        mysqli_rollback($link); //処理取消(ロールバック)
    }
    return $msg;
}


//在庫数変更
function change_stock($link, $item_id, $date, $update_stock) {
    $msg = '';
    $err_msg = [];

    if (mb_strlen($update_stock) === 0) {
        $err_msg[] = '個数を入力してください';
    } elseif (preg_match('/^([1-9]\d*)$/', $update_stock) !== 1) {
        $err_msg[] = '個数は0以上の整数を入力してください';
    } else {
        $sql = "UPDATE stock SET stock = '$update_stock', updated_date = '$date' WHERE item_id = '$item_id'";
        if (mysqli_query($link, $sql) === TRUE) {
            $msg = '在庫数を変更しました';
        }
    }
    return array($msg, $err_msg);
}

// ステータス変更
function change_status($link, $item_id, $date, $change_status) {
    $msg = '';

    $sql = "UPDATE item SET status = $change_status, updated_date = '$date' WHERE id = '$item_id'";
    if (mysqli_query($link, $sql) === TRUE) {
        $msg = 'ステータスを変更しました';
    }
    return $msg;
}

// 商品データ削除
function delete_item_data($link, $item_id) {
    $msg = '';

    mysqli_autocommit($link, false); //トランザクション開始(オートコミットをオフ)

    $sql = "DELETE FROM item WHERE id = $item_id";
    if (mysqli_query($link, $sql) === TRUE) {
        $sql = "DELETE FROM stock WHERE item_id = $item_id";
        if (mysqli_query($link, $sql) === TRUE) {
            $msg = '商品データを削除しました';
            mysqli_commit($link); //処理確定(コミット)
        } else {
            mysqli_rollback($link); //処理取消(ロールバック)
        }
    } else {
        mysqli_rollback($link); //処理取消(ロールバック)
    }
    return $msg;
}