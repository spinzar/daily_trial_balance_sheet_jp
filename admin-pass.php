<?php
    session_start();

    require 'db.php';

    if(empty($_POST['branch']) || empty($_POST['newpass'])) {
        $message = '入力漏れがありました';
    } else {
        $statement = $myPDO->prepare('UPDATE branch_list SET password = :password WHERE name = :name');
        $statement->execute(array(
            ':password' => password_hash($_POST['newpass'], PASSWORD_BCRYPT),
            ':name' => $_POST['branch']
        ));
        header('Location: passchanged.php');
    }
    
?>

<html>
<head>
        <?php require 'head.php'; ?>
    </head>
    <body class="flex-body">
    <div class="ui pointing stackable menu">
        <a class="item" href="admin-dashboard.php">管理トップ</a>
        <a class="item" href="list.php">ダウンロード</a>
        <a class="item" href="add_branch.php">店舗追加</a>
        <div class="right menu">
            <a class="ui item" href="admin-logout.php">ログアウト</a>
        </div>
    </div>

        <div class="home-container">
        <p><?php echo $wrongpass;?></p>
            <form action="" method="post" class="ui form">
                <div class="field">
                    <label for="branch">店舗</label>
                    <select class="ui dropdown select" name="branch" id="branch">
                        <?php foreach($myPDO->query('SELECT * FROM branch_list') as $branch):?>
                            <option value="<?php echo $branch['name'];?>"><?php echo $branch['name'];?></option>
                        <?php endforeach ;?>
                    </select>
                </div>

                <div class="field">
                    <label for="newpass">新しいパスワード</label>
                    <input type="password" name="newpass" id="newpass" required>
                </div>

                <button class="ui button" type="submit">送信</button>
            </form>
        </div>

        <script>
        $(document).ready(function(){
            $('.select.dropdown').dropdown();
        });
    </script>
    </body>
</html>