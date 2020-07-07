<?php

session_start();

require 'db.php';

$statement = $myPDO->prepare("SELECT * FROM admin_password WHERE store = ?");

    $statement->execute(array('ibaraki'));//店ごとに名前を変える

    $row = $statement -> fetch();
   

    if($_POST['login']) {
        if(password_verify($_POST['admin-pass'], $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin-dashboard.php');
        } else {
            $incorrect_password = '<p>パスワードが違います</p>';
        }
    }

?>
<html>
<head>
<?php require 'head.php'; ?>
</head>
<body class="flex-body">
<div class="home-container">
    <?php echo $incorrect_password;?>
        <form action="" method="post" class="ui form"  name="login">
            <div class="field">
                <input type="password" name="admin-pass" placeholder="管理者パスワードを入力">
            </div>
            <input type="hidden" name="login" value="login">
            <div class="submit-container">
                <button type="submit" class="submit-btn">ログイン</button>
            </div>
        </form>
</div>
</body>
</html>

