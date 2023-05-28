<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショッピングカートページ</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
</head>
<body>
    <header>
        <div class="header_title">
            <a href="home.php">K's Style STORE</a>
        </div>

        <ul>
            <li><i class="fas fa-user"></i><?= $user_name; ?></li>
            <li><a href="cart.php"><i class="fas fa-shopping-cart"></i></a></li>
            <li>
                <a href="logout.php">ログアウト</a>
            </li>
        </ul>
   </header>
    <main>
        <h1>Shopping Cart</h1>

        <?php if ($tax_included_price === NULL): ?>
            <p>カートに商品は入っていません</p>
        <?php else: ?>

            <div>
                <div class="blue">
                    <?php if ($msg !== ''): ?>
                        <p><?= $msg; ?></p>
                    <?php endif; ?>
                </div>

                <div class="red">
                    <?php if ($err !== ''): ?>
                        <p><?= $err; ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <table>
                <tr>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格(税別)</th>
                    <th>数量</th>
                    <th>削除</th>
                </tr>

                <?php foreach ($cart_data as $cart): ?>
                    <tr>
                        <td><img class=img_size src="./img/<?= $cart['img']; ?>"></td>
                        <td><?= $cart['name']; ?></td>
                        <td>¥<?= number_format($cart['price']); ?></td>

                        <!-- 数量変更　-->
                        <form method="post">
                            <td>
                                <input class="num_input" type="text" name="update_amount" value="<?= $cart['amount']; ?>">点
                                <input type="submit"  value="変更">
                            </td>
                            <input type="hidden" name="item_id" value="<?= $cart['item_id']; ?>">
                            <input type="hidden" name="sql_kind" value="update">
                        </form>

                        <!-- 商品削除　-->
                        <form method="post">
                            <td>
                                <input type="submit"  value="削除">
                            </td>
                            <input type="hidden" name="item_id" value="<?= $cart['item_id']; ?>">
                            <input type="hidden" name="sql_kind" value="delete">
                        </form>
                    </tr>
                <?php endforeach; ?>
            </table>

            <p>
                小計: <?= number_format($tax_included_price); ?>円 (本体価格: <?= number_format($tax_excluded_price); ?>円, 消費税: <?= number_format($tax); ?>円)
            </p>

            <form action="result.php" method="post">
                <input class="button" type="submit" value="購入">
            </form>

        <?php endif; ?>
    </main>
</body>
</html>
