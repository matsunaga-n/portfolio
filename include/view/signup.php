<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>ユーザ登録ページ</title>
   <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <div class="header_title">
            <a href="home.php">K's Style STORE</a>
        </div>
    </header>

    <main>
        <h1>Sign Up</h1>

        <div>
            <div class="blue">
                <?php if ($msg !== ""): ?>
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

        <form method="post">
            <div class="input_form">
                <label for="new_name">ユーザー名</label>
                <input type="text" id="new_name" name="new_name" placeholder="user name" value="">
            </div>

            <div class="input_form">
                <label for="new_passwd">パスワード</label>
                <input type="password" id="new_passwd" name="new_passwd" placeholder="password" value="">
            </div>

            <input class="button" type="submit" value="登録">
        </form>

        <div class="link_text">
            <a href="top.php">ログイン画面に戻る</a>
        </div>
    </main>
</body>
</html>