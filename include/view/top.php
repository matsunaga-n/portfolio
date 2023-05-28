<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインページ</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <div class="header_title">
            <a href="home.php">K's Style STORE</a>
        </div>
    </header>

    <main>
        <h1>Sign In</h1>
        
        <div class="red">
            <?php if ($login_err_flag === TRUE): ?>
                <p>メールアドレス又はパスワードが違います</p>
            <?php endif; ?>
        </div>

        <form action="login.php" method="post">
            <div class="input_form">
                <label for="user_name">ユーザー名</label>
                <input type="text" id="user_name" name="user_name" placeholder="user name" value="<?= $user_name; ?>">
            </div>
            <div class="input_form">
                <label for="passwd">パスワード</label>
                <input type="password" id="passwd" name="passwd" placeholder="password" value="">
            </div>
            <input class="button" type="submit" value="ログイン">
        </form>

        <div class="link_text">
            <a href="signup.php">新規登録はこちら</a>
        </div>
    </main>
</body>
</html>