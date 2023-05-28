<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザ管理ページ</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
      <div class="header_title">
         <a href="home.php">K's Style STORE</a>
      </div>

      <ul>
         <li><a href="tool.php">商品管理</a></li>
         <li>
            <a href="logout.php">ログアウト</a>
         </li>
      </ul>
   </header>
    <main>
        <h1>ユーザ管理</h1>
        <section>
            <h2 class="section_title">ユーザ情報</h2>
            <table>
                <caption>ユーザ一覧</caption>
                <tr>
                    <th>ユーザ名</th>
                    <th>登録日時</th>
                </tr>
                <?php foreach ($user_data as $user): ?>
                    <tr>
                        <td><?= $user['user_name']; ?></td>
                        <td><?= $user['created_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>

</body>
</html>