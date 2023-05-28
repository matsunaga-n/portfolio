<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理ページ</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
</head>
<body>
    <header>
        <div class="header_title">
            <a href="home.php">K's Style STORE</a>
        </div>
        <ul>
            <li><a href="user.php">ユーザ管理</a></li>
            <li>
                <a href="logout.php">ログアウト</a>
            </li>
        </ul>
   </header>

    <main>
        <div class="main_title">
             <h1>商品管理</h1>
        </div>

        <div>
            <div class="blue">
                <?php if ($msg !== ''): ?>
                    <p><?= $msg; ?></p>
                <?php endif; ?>
            </div>
            <div class="red">
                <?php if (count($err_msg) !== 0): ?>
                    <?php foreach ($err_msg as $err): ?>
                        <p><?= $err; ?></p>
                    <?php endforeach; ?>    
                <?php endif; ?>
            </div>
        </div>

        <section>
            <h2 class="section_title">新規商品追加</h2>
            <form method="post" enctype="multipart/form-data">
            <ul>
                <li>
                    <label class="label_width">商品名</label>
                    <input type="text" name="new_name" value="">
                </li>
                <li>
                    <label class="label_width">価　格</label>
                    <input type="text" name="new_price" value="">
                </li>

                <li>
                    <label class="label_width">在庫数</label>
                    <input type="text" name="new_stock" value="">
                </li>

                <li>
                    <label class="label_width">画像ファイル</label>
                    <input type="file" name="new_img">
                </li>

                <li>
                    <label class="label_width">公開ステータス</label>
                    <select name="new_status">
                        <option value="未選択">選択してください</option>
                        <option value="0">非公開</option>
                        <option value="1">公開</option>
                    </select>
                </li>

                <li>
                    <input type="hidden" name="sql_kind" value="insert">
                    <input class="button" type="submit" value="新規商品を追加">
                </li>
            </ul>
            </form>
        </section>
        
        <section>
            <h2 class="section_title">商品情報変更</h2>
            <table>
                <caption>商品一覧</caption>
                <tr>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格（税抜）</th>
                    <th>在庫数</th>
                    <th>ステータス</th>
                    <th>データ削除</th>
                </tr>
                <?php foreach ($item_data as $item): ?>
                    <tr class="
                        <?php if ((int)$item['status'] === 0) { print 'status_false'; } ?>">
                        <td><img class=img_size src="./img/<?= $item['img']; ?>"></td>
                        <td><?= $item['name']; ?></td>
                        <td>¥<?= number_format($item['price']); ?></td>

                        <!-- 在庫変更　-->
                        <form method="post">
                            <td>
                                <input class="num_input" type="text" name="update_stock" value="<?= $item['stock']; ?>">点
                                <input type="submit"  value="変更">
                            </td>
                                <input type="hidden" name="item_id" value="<?= $item['item_id']; ?>">
                                <input type="hidden" name="sql_kind" value="update">
                        </form>

                        <!-- ステータス変更　-->
                        <form method="post">
                            <td>
                                <?php if ((int)$item['status'] === 0): ?>
                                    <input type="submit" value="非公開 → 公開">
                                    <input type="hidden" name="change_status" value="1">
                                <?php else: ?>
                                    <input type="submit" value="公開 → 非公開">   
                                    <input type="hidden" name="change_status" value="0">
                                <?php endif; ?>
                            </td>
                            <input type="hidden" name="item_id" value="<?= $item['item_id']; ?>">
                            <input type="hidden" name="sql_kind" value="change">
                        </form>

                        <!-- 商品削除　-->
                        <form method="post">
                            <td>
                                <input type="submit"  value="削除">
                            </td>
                            <input type="hidden" name="item_id" value="<?= $item['item_id']; ?>">
                            <input type="hidden" name="sql_kind" value="delete">
                        </form>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>
</body>
</html>