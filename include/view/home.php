<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>商品一覧ページ</title>
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
      <div class="box">
         <h1>New Arrival</h1>

         <div class="blue">
            <?php if ($msg !== ''): ?>
                  <p><?= $msg; ?></p>
            <?php endif; ?>
         </div>

         <div class="item_flex">
            <?php foreach ($item_data as $item): ?>
               <div class="item">
                  <form method="post">
                     <span><img class="large_img_size" src="./img/<?= $item['img']; ?>"></span>
                     <span><?= $item['name']; ?></span>  
                     <span>¥<?= number_format($item['price']); ?></span>
                     <?php if ((int)$item['stock'] > 0): ?>
                        <input type="submit" value="カートに入れる">
                        <input type="hidden" name="item_id" value="<?= $item['id']; ?>">
                     <?php else: ?>
                        <span class="red">SOLD OUT</span>
                     <?php endif; ?>
                  </form>
               </div>
            <?php endforeach; ?>
         </div>
      </div>

      <div class="box">
         <h1>Ranking</h1>
         <div class="rank_flex">
            <?php foreach ($ranking_data  as $index => $ranking): ?>
               <div class="rank">
                  <form method="post">
                     <span><img class="rank_img_size" src="./img/<?= $ranking['img']; ?>"></span>
                     <span><?= $ranking['name']; ?></span> 
                     <span><?= $index+1; ?></span> 
                     <span>¥<?= number_format($ranking['price']); ?></span>
                  </form>
               </div>
            <?php endforeach; ?>
         </div>
      </div>

      <div class="box">
         <h1>Check</h1>
         <ul class="snsbtniti2">
            <li><a class="flowbtn11 fl_tw1" href="https://twitter.com/ks_style2019"><i class="fab fa-twitter"></i><span>Twitter</span></a></li>
            <li><a class="flowbtn11 insta_btn11" href="https://www.instagram.com/ks_style2019/"><i class="fab fa-instagram"></i><span>Instagram</span></a></li>
            <li><a class="flowbtn11 fl_fb1" href="https://www.facebook.com/ks_style2019-104581594341901"><i class="fab fa-facebook-f"></i><span>Facebook</span></a></li>
         </ul>
      </div>
   </main>
</body>
</html>
