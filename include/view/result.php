<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入完了ページ</title>
    <link rel="stylesheet" href="./css/style.css">
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
        <h1>Order History</h1>

        <?php if (count($err_msg) === 0): ?>

            <div class="blue">
                <p>ご購入ありがとうございます</p>
            </div>

            <table>
                <tr>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格(税別)</th>
                    <th>数量</th>
                </tr>

                <?php foreach ($result_data as $result): ?>
                    <tr>
                        <td><img class=img_size src="./img/<?= $result['img']; ?>"></td>
                        <td><?= $result['name']; ?></td>
                        <td>¥<?= number_format($result['price']); ?></td>
                        <td><?= $result['amount']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <p>
                小計: <?= number_format($tax_included_price); ?>円 (本体価格: <?= number_format($tax_excluded_price); ?>円, 消費税: <?= number_format($tax); ?>円)
            </p>

            <a href="home.php">ショッピングを続ける</a>

        <?php else: ?>
            <div class="red">
                <p>在庫数が不足しています</p>
            </div>

            <?php foreach ($err_msg as $err): ?>
                <p><?= $err; ?></p>
            <?php endforeach; ?>
            
        <?php endif; ?>
    </main>
</body>
</html>
