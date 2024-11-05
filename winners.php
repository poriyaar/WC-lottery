<?php
include_once "connect.php";
include_once "jdf.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>برندگان پیش بینی</title>
    <?php include_once "_header.php"; ?>
</head>
<body>
<div id="wrapper">
    <!-- Sidebar -->
    <?php include_once "_menu.php"; ?>


    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group">
                        <div class="panel panel-primary" style="margin-top: 40px !important;">
                            <div class="panel-heading">فهرست برندگان قرعه کشی</div>
                            <div class="panel-body">
                                <?php
                                $result = $connect->query("SELECT * FROM `tbl_winner` ORDER BY `id` DESC");
                                if($result->rowCount() >= 1) {
                                    ?>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">عنوان مسابقه</th>
                                            <th scope="col">شماره تماس</th>
                                            <th scope="col">نتیجه پیش بینی</th>
                                            <th scope="col">نوع قرعه کشی</th>
                                            <th scope="col">پیامک تبریک</th>
                                            <th scope="col">عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($rows=$result->fetch(PDO::FETCH_ASSOC)) {
                                            $game_id = $rows["game_id"];
                                            $gameInfo = $connect->query("SELECT team1,team2,team1_goal,team2_goal FROM `tbl_game` WHERE `id` = {$game_id}");
                                            $gameRow = $gameInfo->fetch(PDO::FETCH_ASSOC);
                                            $tel = $rows["tel"];
                                            $category_id = $rows["category_id"];
                                            $catInfo = $connect->query("SELECT `title` FROM `tbl_category` WHERE `id` = {$category_id}");
                                            $catRow = $catInfo->fetch(PDO::FETCH_ASSOC);
                                            $sms_verify = $rows["sms_verify"];
                                            $register = $connect->query("SELECT `id` FROM `tbl_register` WHERE `tel` = {$tel} AND `game_id` = {$game_id}");
                                            $register_id = $register->fetch(PDO::FETCH_ASSOC)["id"];
                                        ?>
                                        <tr>
                                            <th scope="row"><?=$gameRow["team1"]." - ".$gameRow["team2"];?></th>
                                            <td scope="row"><?=tr_num($tel, 'fa');?></td>
                                            <td scope="row"><?=$gameRow["team1"]." ".tr_num($gameRow["team1_goal"],'fa')." - ".$gameRow["team2"]." ".tr_num($gameRow["team2_goal"], 'fa');?></td>
                                            <td scope="row"><?=tr_num($catRow["title"]);?></td>
                                            <td scope="row"><?=($sms_verify=="yes")?"ارسال شده":"ارسال نشده";?></td>
                                            <td scope="row">
                                                <?php if($sms_verify=="no") { ?>
                                                <a href="sendsms.php?id=<?=$register_id;?>">ارسال پیامک تبریک</a>
                                                <?php } else { echo "-"; }?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php
                                } else {
                                    ?>
                                    <span class="error">تا کنون برنده ای ثبت نشده است</span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php include_once "_footer.php"; ?>
</body>
</html>
