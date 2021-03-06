<?php

    session_start();
    require '../db.php';

    if($_SESSION['logged_in'] !== 'logged_in') {
        header('Location: ../index.php');
    }

    //日付セッションがないか、ブランチセッションがない場合はトップページに
    if(!$_SESSION['date'] || !$_SESSION['branch']) {
        session_destroy();
        header('Location: ../index.php');
    }


    //当店舗と日付セッションを両方含んでいるデータがデータベースにない場合はトップページに
    $stmt = $myPDO->prepare("SELECT * FROM okasato WHERE date = :date AND branch = :branch");
    $stmt->execute(array(
        ':date' => $_SESSION['date'],
        ':branch' => $_SESSION['branch']
    ));
    $matchedRowsArray = $stmt->fetchAll();//データを配列にする
    $rowCount = count($matchedRowsArray);


    if($rowCount == 0) {

        session_destroy();
        header('Location: ../index.php');

    } else {

        //データがある場合は、一番最近入力したデータを探す
        $record;
        $time_created = 0;
        foreach($matchedRowsArray as $row) {
            global $record;
            global $time_created;
            if($row['time_created'] > $time_created) {
                $time_created = $row['time_created'];
                $record = $row;
            }
        }
    

        //表示する項目のデータを変数に入れる
        if(!$_POST['from_edit_form']) {

        $_SESSION['name'] = $record['name'];

        $unixtime = strtotime($_SESSION['date']);
        $_SESSION['year'] = date('Y', $unixtime);
        $_SESSION['month'] = date('m', $unixtime);
        $_SESSION['displayDate'] = date('d', $unixtime);


        $_SESSION['change'] = $record['change1'];
        $_SESSION['earning'] = $record['earning'];
        $_SESSION['received_from'] = unserialize($record['received_from']);
        $_SESSION['total_received'] = unserialize($record['total_received']);
        $_SESSION['content_received'] = unserialize($record['content_received']);
        $_SESSION['sent_to'] = unserialize($record['sent_to']);
        $_SESSION['total_sent'] = unserialize($record['total_sent']);
        $_SESSION['content_sent'] = unserialize($record['content_sent']);
        $_SESSION['next_day_change'] = $record['next_day_change'];
        $_SESSION['jisen_total'] = $record['jisen_total'];
        $_SESSION['next_day_deposit'] = $record['next_day_deposit'];
        $_SESSION['prem_count'] = $record['prem_count'];
        $_SESSION['prem_total'] = $record['prem_total'];
        $_SESSION['for_selling_count'] = $record['for_selling_count'];
        $_SESSION['for_selling_total'] = $record['for_selling_total'];
        $_SESSION['thousand_count'] = $record['thousand_count'];
        $_SESSION['thousand_total'] = $record['thousand_total'];
        $_SESSION['five_count'] = $record['five_count'];
        $_SESSION['five_total'] = $record['five_total'];
        $_SESSION['two_count'] = $record['two_count'];
        $_SESSION['two_total'] = $record['two_total'];
        $_SESSION['client_name'] = unserialize($record['client_name']);
        $_SESSION['urikake_total'] = unserialize($record['urikake_total']);
        $_SESSION['dc_how_much'] = unserialize($record['dc_how_much']);
        $_SESSION['jcb_how_much'] = unserialize($record['jcb_how_much']);
        $_SESSION['paypay_count'] = $record['paypay_count'];
        $_SESSION['paypay_total'] = $record['paypay_total'];
        $_SESSION['nanaco_count'] = $record['nanaco_count'];
        $_SESSION['nanaco_total'] = $record['nanaco_total'];
        $_SESSION['edy_count'] = $record['edy_count'];
        $_SESSION['edy_total'] = $record['edy_total'];
        $_SESSION['transport_ic_count'] = $record['transport_ic_count'];
        $_SESSION['transport_ic_total'] = $record['transport_ic_total'];
        $_SESSION['quick_pay_count'] = $record['quick_pay_count'];
        $_SESSION['quick_pay_total'] = $record['quick_pay_total'];
        $_SESSION['waon_count'] = $record['waon_count'];
        $_SESSION['waon_total'] = $record['waon_total'];

        }
    }


        if($_POST['name']) {
            $_SESSION['name'] = $_POST['name'];
        }

        if($_POST['change']){
            $_SESSION['change'] = $_POST['change'];
        }

        if($_POST['earning']) {
            $_SESSION['earning'] = $_POST['earning'];
        }

        if($_POST['received_from'] || $_POST['first_modal']){
            $_SESSION['received_from'] = $_POST['received_from'];
        }

        if($_POST['total_received'] || $_POST['first_modal']) {
            $_SESSION['total_received'] = $_POST['total_received'];
        }

        if($_POST['content_received'] || $_POST['first_modal']) {
            $_SESSION['content_received'] = $_POST['content_received'];
        }

        if($_POST['sent_to']  || $_POST['first_modal']){
            $_SESSION['sent_to'] = $_POST['sent_to'];
        }

        if($_POST['total_sent'] || $_POST['first_modal']) {
            $_SESSION['total_sent'] = $_POST['total_sent'];
        }

        if($_POST['content_sent'] || $_POST['first_modal']) {
            $_SESSION['content_sent'] = $_POST['content_sent'];
        }

        if($_POST['next_day_change']) {
            $_SESSION['next_day_change'] = $_POST['next_day_change'];
        }

        if($_POST['jisen_total']) {
            $_SESSION['jisen_total'] = $_POST['jisen_total'];
        }

        if($_POST['next_day_deposit']) {
            $_SESSION['next_day_deposit'] = $_POST['next_day_deposit'];
        }

        if($_POST['prem_count']) {
            $_SESSION['prem_count'] = $_POST['prem_count'];
        }

        if($_POST['prem_total']) {
            $_SESSION['prem_total'] = $_POST['prem_total'];
        }

        if($_POST['for_selling_count']) {
            $_SESSION['for_selling_count'] = $_POST['for_selling_count'];
        }

        if($_POST['for_selling_total']) {
            $_SESSION['for_selling_total'] = $_POST['for_selling_total'];
        }

        if($_POST['thousand_count']) {
            $_SESSION['thousand_count'] = $_POST['thousand_count'];
            $_SESSION['thousand_total'] = $_POST['thousand_count'] * 1000;
        }

        if($_POST['five_count']) {
            $_SESSION['five_count'] = $_POST['five_count'];
            $_SESSION['five_total'] = $_POST['five_count'] * 500;
        }

        if($_POST['two_count']) {
            $_SESSION['two_count'] = $_POST['two_count'];
            $_SESSION['two_total'] = $_POST['two_count'] * 200;
        }

        if($_POST['client_name'] || $_POST['third_modal']) {
            $_SESSION['client_name'] = $_POST['client_name'];
        }

        if($_POST['urikake_total'] || $_POST['third_modal']) {
            $_SESSION['urikake_total'] = $_POST['urikake_total'];
        }

        if($_POST['dc_how_much'] || $_POST['fifth_modal']) {
            $_SESSION['dc_how_much'] = $_POST['dc_how_much'];
        }

        if($_POST['jcb_how_much'] || $_POST['fifth_modal']) {
            $_SESSION['jcb_how_much'] = $_POST['jcb_how_much'];
        }

        if($_POST['paypay_count']) {
            $_SESSION['paypay_count'] = $_POST['paypay_count'];
        }

        if($_POST['paypay_total']) {
            $_SESSION['paypay_total'] = $_POST['paypay_total'];
        }

        if($_POST['nanaco_count']) {
            $_SESSION['nanaco_count'] = $_POST['nanaco_count'];
        }

        if($_POST['nanaco_total']) {
            $_SESSION['nanaco_total'] = $_POST['nanaco_total'];
        }

        if($_POST['edy_count']) {
            $_SESSION['edy_count'] = $_POST['edy_count'];
        }

        if($_POST['edy_total']) {
            $_SESSION['edy_total'] = $_POST['edy_total'];
        }

        if($_POST['transport_ic_count']) {
            $_SESSION['transport_ic_count'] = $_POST['transport_ic_count'];
        }

        if($_POST['transport_ic_total']) {
            $_SESSION['transport_ic_total'] = $_POST['transport_ic_total'];
        }

        if($_POST['quick_pay_count']) {
            $_SESSION['quick_pay_count'] = $_POST['quick_pay_count'];
        }

        if($_POST['quick_pay_total']) {
            $_SESSION['quick_pay_total'] = $_SESSION['quick_pay_total'];
        }

        if($_POST['waon_count']){
            $_SESSION['waon_count'] = $_POST['waon_count'];
        }

        if($_POST['waon_total']) {
            $_SESSION['waon_total'] = $_POST['waon_total'];
        }


?>
<html>
<head>
<?php require './form-head.php';?>
</head>
<body>

    <div class="confirmation-container">
        <h2 class="ui header">
            <span class="item-name">記入者：</span>
            <span class="item-value"><?php echo $_SESSION['name'];?></span>
            <button class="edit name" id="edit-btn">編集</button>
        </h2>

        <h2 class="ui header">
            <span class="item-name">日付：</span>
            <span><?php echo $_SESSION['year'];?>月<?php echo $_SESSION['month'];?>月<?php echo $_SESSION['displayDate'];?>日</span>
        </h2>

        <h2 class="ui header">店舗名：<?php echo $_SESSION['branch'];?></h2>

        <div>

            <table>
                <tr class="row-1">
                    <td class="item_name">釣り銭</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['change']);?>円</td>
                    <td class="item_name">内訳</td>
                </tr>

                <tr class="row-2">
                    <td class="item_name">現金売上</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['earning']);?>円</td>
                    <td class="item_name">購入取引先名</td>
                    <td class="item_name">明細</td>
                </tr>

       
                <?php if($_SESSION['received_from'] == ''):?>
                
                    <tr class="row-2">
                        <td class="item_name">入金</td>
                        <td class="number_cell"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                
                <?php else :?>
                    <?php for($i = 0; $i < count($_SESSION['received_from']); $i++):?>
                    <tr class="row-2">
                        <td class="item_name">入金</td>
                        <td class="number_cell"><?php echo number_format($_SESSION['total_received'][$i]);?>円</td>
                        <td><?php echo $_SESSION['received_from'][$i];?></td>
                        <td><?php echo $_SESSION['content_received'][$i];?></td>
                    </tr>
                    <?php endfor;?>
                <?php endif;?>

                <?php
                    if(count($_SESSION['received_from']) < 5) {
                        $num_of_blank_received_rows = 5 - count($_SESSION['received_from']);
                        for($i = 0; $i < $num_of_blank_received_rows; $i++) { ?>
                            <tr class="row-2">
                                <td class="item_name">入金</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php
                        }
                    }
                ?>

                <?php for($i = 0; $i < count($_SESSION['sent_to']); $i++):?>
                    <tr class="<?php 
                        if($i == 0){
                            echo "row-2 first-sent";
                        } else {
                            echo "row-2";
                        };
                    ?>">
                        <td class="item_name">出金</td>
                        <td class="number_cell"><?php echo number_format($_SESSION['total_sent'][$i]);?>円</td>
                        <td><?php echo $_SESSION['sent_to'][$i];?></td>
                        <td><?php echo $_SESSION['content_sent'][$i];?></td>
                    </tr>
                <?php endfor;?>

                <?php
                    if(count($_SESSION['sent_to']) < 10) {
                        $num_of_blank_sent_to = 10 - count($_SESSION['sent_to']);
                        for($i = 0; $i < $num_of_blank_sent_to; $i++) { ?>
                            <tr class="row-2">
                                <td class="item_name">出金</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php
                        }
                    }
                ?>

                <tr class="row-2">
                    <td class="item_name">支払い計</td>
                    <td class="number_cell"><?php echo number_format(array_sum($_SESSION['total_sent']));?>円</td>
                    <td></td>
                    <td></td>
                </tr>

                <?php
                    $reji_zankei = $_SESSION['change'] + $_SESSION['earning'] 
                    + array_sum($_SESSION['total_received']) - array_sum($_SESSION['total_sent']);
                ?>

                <tr class="row-2">
                    <td class="item_name">レジ残計</td>
                    <td class="number_cell"><?php echo number_format($reji_zankei);?>円</td>
                    <td></td>
                    <td></td>
                </tr>

                <?php
                    $kabusoku = $reji_zankei - $_SESSION['jisen_total'];
                ?>

                <tr class="row-2">
                    <td class="item_name">現金過不足</td>
                    <td class="number_cell"><?php echo number_format($kabusoku);?>円</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name">実残合計</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['jisen_total']);?>円</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name">翌日つり銭</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['next_day_change']);?>円</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr class="row-2">
                    <td class="item_name">翌日預入</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['next_day_deposit']);?>円</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div class="edit-button-container">
                <button class="edit firstTable" id="edit-section-btn">ここまで編集</button>
            </div>


            <table>
            <?php
                    $shokuji = $_SESSION['prem_total'] + $_SESSION['for_selling_total'] +
                    $_SESSION['thousand_total'] + $_SESSION['five_total'] + $_SESSION['two_total'];
                ?>

                <tr class="table-2-row-1">
                    <td></td>
                    <td class="item_name">食事券計</td>
                    <td class="number_cell"><?php echo number_format($shokuji);?>円</td>
                </tr>

                <tr class="table-2-row-2">
                    <td></td>
                    <td class="item_name">プレミアム食事券</td>
                    <td class="item_name">販売用回収</td>
                    <td class="item_name">サービス用回収</td>
                </tr>

                <tr class="table-2-row-3">
                    <td class="item_name">千円券</td>
                    <td><?php echo $_SESSION['prem_count'];?>枚</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['prem_total']);?>円</td>
                    <td><?php echo $_SESSION['for_selling_count'];?>枚</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['for_selling_total']);?>円</td>
                    <td><?php echo $_SESSION['thousand_count'];?>枚</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['thousand_total']);?>円</td>
                </tr>

                <tr class="table-2-row-4">
                    <td class="item_name">500円券</td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td><?php echo $_SESSION['five_count'];?>枚</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['five_total']);?>円</td>
                </tr>

                <tr class="table-2-row-5">
                    <td class="item_name">200円券</td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td class="null"></td>
                    <td><?php echo $_SESSION['two_count'];?>枚</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['two_total']);?>円</td>
                </tr>

            </table>
            <div class="edit-button-container">
            <button class="edit secondTable" id="edit-section-btn">ここまで編集</button>
            </div>


            <table>
                <div class="table-title">売掛金</div>

                <?php if(count($_SESSION['client_name']) === 0):?>
                    <tr><td class="no_client">データなし</td></tr>
                <?php else:?>
                    <?php for($i = 0; $i < count($_SESSION['client_name']); $i++):?>
                        <tr class="client-row">
                            <td><?php echo $_SESSION['client_name'][$i];?>様</td>
                            <td class="number_cell"><?php echo number_format($_SESSION['urikake_total'][$i]);?>円</td>
                        </tr>
                    <?php endfor;?>
                <?php endif ;?>
                
            </table>
            <div class="edit-button-container">
            <button class="edit thirdTable" id="edit-section-btn">ここまで編集</button>
            </div>


            <table>
            <tr class="other-total">
                    <th>種別</th>
                    <th>件数</th>
                    <th>金額</th>
                </tr>

                <?php for($i = 0; $i < count($_SESSION['dc_how_much']); $i++):?>
                    <tr class="other-total">
                        <td>DC</td>
                        <td>1件</td>
                        <td class="number_cell"><?php echo number_format($_SESSION['dc_how_much'][$i]);?>円</td>
                    </tr>
                <?php endfor;?>

                <tr class="other-total sum">
                    <td>DC合計</td>
                    <td><?php echo count($_SESSION['dc_how_much']);?>件</td>
                    <td class="number_cell"><?php echo number_format(array_sum($_SESSION['dc_how_much']));?>円</td>
                </tr>

                <?php for($i = 0; $i < count($_SESSION['jcb_how_much']); $i++):?>
                    <tr class="other-total">
                        <td>JCB</td>
                        <td>1件</td>
                        <td class="number_cell"><?php echo number_format($_SESSION['jcb_how_much'][$i]);?>円</td>
                    </tr>
                <?php endfor;?>

                <tr class="other-total sum">
                    <td>JCB合計</td>
                    <td><?php echo count($_SESSION['jcb_how_much']);?>件</td>
                    <td class="number_cell"><?php echo number_format(array_sum($_SESSION['jcb_how_much']));?>円</td>
                </tr>

                <tr class="other-total sum">
                    <td>PayPay</td>
                    <td><?php echo $_SESSION['paypay_count'];?>件</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['paypay_total']);?>円</td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">nanaco</td>
                    <td><?php echo $_SESSION['nanaco_count'];?>件</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['nanaco_total']);?>円</td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">edy</td>
                    <td><?php echo $_SESSION['edy_count'];?>件</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['edy_total']);?>円</td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">交通IC</td>
                    <td><?php echo $_SESSION['transport_ic_count'];?>件</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['transport_ic_total']);?>円</td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">Quick Pay</td>
                    <td><?php echo $_SESSION['quick_pay_count'];?>件</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['quick_pay_total']);?>円</td>
                </tr>

                <tr class="other-total sum">
                    <td class="item_name">WAON</td>
                    <td><?php echo $_SESSION['waon_count'];?>件</td>
                    <td class="number_cell"><?php echo number_format($_SESSION['waon_total']);?>円</td>
                </tr>
            </table>
            <div class="edit-button-container">
            <button class="edit fifthTable center" id="edit-section-btn">ここまで編集</button>
            </div>

        </div>

        <div class="submit-container">
        <a href="date.php" class="back_to_date">戻る</a>
        <a href="submit.php" id="send-btn" class="send-data">送信</a>
        </div>

    </div>



    <!-- modal for name -->
    <div class="ui modal name">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            記入者
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="field">
                    <input type="text" name="name" value="<?php echo $_SESSION['name'];?>" required>
                </div>
                <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                <button class="ui button" type="submit" >編集を完了</button>
            </form>
        </div>
    </div>

    <!-- modal for first-table -->
    <div class="ui modal firstTable">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            釣り銭〜翌日預け入れ
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="edit_section">
                    <div class="field">
                        <label for="change">釣り銭</label>
                        <input type="number" name="change" id="change" value="<?php echo $_SESSION['change'];?>" required>
                    </div>
                    <div class="field">
                        <label for="earning">現金売上</label>
                        <input type="number" name="earning" id="earning" value="<?php echo $_SESSION['earning'];?>" required>
                    </div>
                </div>
                
                <div class="received_form_container edit_section">
                    <?php for($i = 0; $i < count($_SESSION['received_from']); $i++):?>
                        <div class="each_section">
                            <div class="field">
                                <label for="total_received">入金額</label>
                                <input type="number" id="total_received" name="total_received[]" value="<?php echo $_SESSION['total_received'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="received_from">入金相手</label>
                                <input type="text" id="received_from" name="received_from[]" value="<?php echo $_SESSION['received_from'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="content_received">入金内容</label>
                                <input type="text" id="content_received" name="content_received[]" value="<?php echo $_SESSION['content_received'][$i];?>" required>
                            </div>
                            <img class="delete_received" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>
                        </div>
                    <?php endfor ;?>
                </div>
                <div><button class="add-received">入金を追加</button></div>
                <div class="sent-form-container edit_section">
                    <?php for($i = 0; $i < count($_SESSION['sent_to']); $i++):?>
                        <div class="each_section">
                            <div class="field">
                                <label for="total_sent">出金額</label>
                                <input type="number" id="total_sent" name="total_sent[]" value="<?php echo $_SESSION['total_sent'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="sent-to">出金先</label>
                                <input type="text" id="sent_to" name="sent_to[]" value="<?php echo $_SESSION['sent_to'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="content_sent">出金内容</label>
                                <input type="text" id="content_sent" name="content_sent[]" value="<?php echo $_SESSION['content_sent'][$i];?>" required>
                            </div>
                            <img class="delete_sent" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>
                        </div>
                    <?php endfor ;?>
                </div>
                <div><button class="add-sent">出金を追加</button></div>
                <div class="edit_section">
                    <div class="field">
                        <label for="next_day_change">翌日つり銭</label>
                        <input type="number" id="next_day_change" name="next_day_change" value="<?php echo $_SESSION['next_day_change'];?>" required>
                    </div>
                    <div class="field">
                        <label for="jisen_total">実践合計</label>
                        <input type="number" id="jisen_total" name="jisen_total" value="<?php echo $_SESSION['jisen_total'];?>" required>
                    </div>
                    <div class="field">
                        <label for="next_day_deposit">翌日預入</label>
                        <input type="number" id="next_day_deposit" name="next_day_deposit" value="<?php echo $_SESSION['next_day_deposit'];?>" required>
                    </div>
                    </div>

                    <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                    <input type="hidden" name="first_modal" value="<?php echo true;?>">
                
                <button class="ui button" type="submit" >編集を完了</button>
            </form>
        </div>
    </div>

    <!-- modal for secondTable -->
    <div class="ui modal secondTable">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            食事券
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="edit_section">
                    <div class="field">
                        <label for="prem_count">プレミアム枚数</label>
                        <input type="number" name="prem_count" value="<?php echo $_SESSION['prem_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="prem_total">プレミアム金額</label>
                        <input type="number" name="prem_total" value="<?php echo $_SESSION['prem_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="for_selling_count">販売用枚数</label>
                        <input type="number" name="for_selling_count" value="<?php echo $_SESSION['for_selling_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="for_selling_total">販売用金額</label>
                        <input type="number" name="for_selling_total" value="<?php echo $_SESSION['for_selling_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="thousand_count">サービス千円枚数</label>
                        <input type="number" name="thousand_count" value="<?php echo $_SESSION['thousand_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="five_count">サービス500円枚数</label>
                        <input type="number" name="five_count" value="<?php echo $_SESSION['five_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="two_count">サービス200円枚数</label>
                        <input type="number" name="two_count" value="<?php echo $_SESSION['two_count'];?>" required>
                    </div>
                </div>
                <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                <button class="ui button" type="submit" >編集を完了</button>
            </form>
        </div>
    </div>

    <!-- modal for thirdTable -->
    <div class="ui modal thirdTable">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            売掛金
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="client_form_container">
                    <?php for($i = 0; $i < count($_SESSION['client_name']); $i++):?>
                        <div class="each_section">
                            <div class="field">
                                <label for="client_name">お客様</label>
                                <input type="text" name="client_name[]" id="client_name" value="<?php echo $_SESSION['client_name'][$i];?>" required>
                            </div>
                            <div class="field">
                                <label for="urikake_total">金額</label>
                                <input type="number" name="urikake_total[]" id="urikake_total" value="<?php echo $_SESSION['urikake_total'][$i];?>" required>
                            </div>
                            <img class="delete_client" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>
                        </div>
                    <?php endfor ;?>
                </div>
                <div><button  class="add_client">追加</button></div>
                <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                <input type="hidden" name="third_modal" value="<?php echo true;?>">
                <button class="ui button" type="submit" >編集を完了</button>
            </form>
        </div>
    </div>

    

    <!-- modal for fifthTable -->
    <div class="ui modal fifthTable">
        <i id="close_edit" class="massive close icon"></i>
        <div class="header">
            その他
        </div>
        <div class="content">
            <form class="ui form" action="" method="post">
                <div class="dc_form_container edit_section">
                    <?php for($i = 0; $i < count($_SESSION['dc_how_much']); $i++):?>
                        <div class="field">
                        <img class="delete_dc" src="https://img.icons8.com/ios-glyphs/30/000000/multiply.png"/>
                            <label for="dc_how_much">DC</label>
                            <input type="number" name="dc_how_much[]" value="<?php echo $_SESSION['dc_how_much'][$i];?>" required>
                        </div>
                    <?php endfor;?>
                </div>
                <div><button class="edit_add_dc">DCを追加</button></div>
                <div class="jcb_form_container edit_section">
                    <?php for($i = 0; $i < count($_SESSION['jcb_how_much']); $i++):?>
                        <div class="field">
                            <img class="delete_jcb" src="https://img.icons8.com/ios-glyphs/30/000000/multiply.png"/>
                            <label for="jcb_how_much">JCB</label>
                            <input type="number" name="jcb_how_much[]" value="<?php echo $_SESSION['jcb_how_much'][$i];?>" required>
                        </div>
                    <?php endfor;?>
                </div>
                <div><button class="edit_add_jcb">JCBを追加</button></div>
                <div class="edit_section">
                    <div class="field">
                        <label for="paypay_count">PAYPAY件数</label>
                        <input type="number" id="paypay_count" name="paypay_count" value="<?php echo $_SESSION['paypay_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="paypay_total">PAYPAY合計額</label>
                        <input type="number" id="paypay_total" name="paypay_total" value="<?php echo $_SESSION['paypay_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="nanaco_count">nanaco件数</label>
                        <input type="number" name="nanaco_count" id="nanaco_count" value="<?php echo $_SESSION['nanaco_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="nanaco_total">nanaco金額</label>
                        <input type="number" name="nanaco_total" id="nanaco_total" value="<?php echo $_SESSION['nanaco_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="edy_count">edy件数</label>
                        <input type="number" name="edy_count" id="edy_count" value="<?php echo $_SESSION['edy_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="edy_total">edy金額</label>
                        <input type="number" name="edy_total" id="edy_total" value="<?php echo $_SESSION['edy_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="transport_ic_count">交通IC件数</label>
                        <input type="number" name="transport_ic_count" id="transport_ic_count" value="<?php echo $_SESSION['transport_ic_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="transport_ic_total">交通IC金額</label>
                        <input type="number" name="transport_ic_total" id="transport_ic_total" value="<?php echo $_SESSION['transport_ic_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="quick_pay_count">Quick Pay件数</label>
                        <input type="number" name="quick_pay_count" id="quick_pay_count" value="<?php echo $_SESSION['quick_pay_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="quick_pay_total">Quick Pay金額</label>
                        <input type="number" name="quick_pay_total" id="quick_pay_total" value="<?php echo $_SESSION['quick_pay_total'];?>" required>
                    </div>
                </div>
                <div class="edit_section">
                    <div class="field">
                        <label for="waon_count">WAON件数</label>
                        <input type="number" name="waon_count" id="waon_count" value="<?php echo $_SESSION['waon_count'];?>" required>
                    </div>
                    <div class="field">
                        <label for="waon_total">WAON金額</label>
                        <input type="number" name="waon_total" id="waon_total" value="<?php echo $_SESSION['waon_total'];?>" required>
                    </div>
                </div>

                <input type="hidden" value=<?php echo true;?> name="from_edit_form">
                <input type="hidden" name="fifth_modal" value="<?php echo true;?>">
                
                <button class="ui button" type="submit" >編集を完了</button>
            </form>
        </div>
    </div>


    <script>

        $(document).ready(function(){
            var edit = $(".edit");

            $(edit).on('click', function(e){
                e.preventDefault();

                if($(this).hasClass('name')){
                    $('.ui.modal.name').modal('show');
                } else if($(this).hasClass('firstTable')) {
                    $('.ui.modal.firstTable').modal('show');
                } else if($(this).hasClass('secondTable')) {
                    $('.ui.modal.secondTable').modal('show');
                } else if($(this).hasClass('thirdTable')) {
                    $('.ui.modal.thirdTable').modal('show');
                } else if($(this).hasClass('fourthTable')) {
                    $('.ui.modal.fourthTable').modal('show');
                } else if($(this).hasClass('fifthTable')) {
                    $('.ui.modal.fifthTable').modal('show');
                }

            });

            var add_received = $(".add-received");
            var received_form_container = $(".received_form_container");
            $(add_received).on('click', function(e){
                e.preventDefault();
                $(received_form_container).append(
                    '<div class="each_section">' +
                        '<div class="field">' +
                            '<label for="total_received">入金額</label>' +
                            '<input type="number" id="total_received" name="total_received[]" required>' +
                        '</div>' +
                        '<div class="field">' +
                            '<label for="received_from">出金先</label>' +
                            '<input type="text" id="received_from" name="received_from[]" required>' +
                        '</div>' +
                        '<div class="field">' +
                            '<label for="content_received">出金内容</label>' +
                            '<input type="text" id="content_received" name="content_received[]" required>' +
                        '</div>'+
                        '<img class="delete_received" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>' +
                    '</div>'
                );
            });

            $(received_form_container).on('click', '.delete_received', function(e){
                e.preventDefault();
                $(this).parent('.each_section').remove();
            });

            var add_sent = $(".add-sent");
            var sent_form_container = $(".sent-form-container");
            $(add_sent).on('click', function(e){
                e.preventDefault();
                $(sent_form_container).append(
                    '<div class="each_section">' +
                            '<div class="field">' +
                                '<label for="total_sent">出金額</label>' +
                                '<input type="number" id="total_sent" name="total_sent[]" required>' +
                            '</div>' +
                            '<div class="field">' +
                                '<label for="sent-to">出金先</label>' +
                                '<input type="text" id="sent_to" name="sent_to[]" required>' +
                            '</div>' +
                            '<div class="field">' +
                                '<label for="content_sent">出金内容</label>' +
                                '<input type="text" id="content_sent" name="content_sent[]" required>' +
                            '</div>' +
                            '<img class="delete_sent" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>' +
                    '</div>' 
                );
            });

            $(sent_form_container).on('click', '.delete_sent', function(e){
                e.preventDefault();
                $(this).parent('.each_section').remove();
            });

            var add_client = $(".add_client");
            var client_form_container = $(".client_form_container");
            $(add_client).on('click', function(e) {
                e.preventDefault();
                $(client_form_container).append(
                    '<div class="each_section">' +
                        '<div class="field">' +
                            '<label for="client_name">お客様</label>' +
                            '<input type="text" name="client_name[]" id="client_name" required>' +
                        '</div>' +
                        '<div class="field">' +
                           '<label for="urikake_total">金額</label>' +
                            '<input type="number" name="urikake_total[]" id="urikake_total" required>' +
                        '</div>'  +
                        '<img class="delete_client" src="https://img.icons8.com/ios-glyphs/24/000000/multiply.png"/>' +
                    '</div>'
                );
            });

            $(client_form_container).on('click', '.delete_client', function(e){
                e.preventDefault();
                $(this).parent('.each_section').remove();
            })

            var add_dc = $('.edit_add_dc');
            var dc_form_container = $('.dc_form_container');
            $(add_dc).on('click', function(e) {
                e.preventDefault();
                $(dc_form_container).append(
                    '<div class="field">' +
                        '<label for="dc_how_much">DC</label>' +
                        '<img class="delete_dc" src="https://img.icons8.com/ios-glyphs/25/000000/multiply.png"/>' +
                        '<input type="number" name="dc_how_much[]" required>' +
                    '</div>'
                );
            });

            $(dc_form_container).on('click', '.delete_dc', function(e){
                e.preventDefault();
                $(this).parent('.field').remove();
            });

            var add_jcb = $('.edit_add_jcb');
            var jcb_form_container = $('.jcb_form_container');
            $(add_jcb).on('click', function(e) {
                e.preventDefault();
                $(jcb_form_container).append(
                    '<div class="field">' +
                            '<label for="jcb_how_much">JCB</label>' +
                            '<img class="delete_jcb" src="https://img.icons8.com/ios-glyphs/25/000000/multiply.png"/>' +
                            '<input type="number" name="jcb_how_much[]" required>' +
                        '</div>'
                );
            });

            $(jcb_form_container).on('click', '.delete_jcb', function(e){
                e.preventDefault();
                $(this).parent('.field').remove();
            });


        });

        

    </script>
</body>
</html>
<?php
$_SESSION['previousURI'] = $_SERVER['REQUEST_URI'];
?>
