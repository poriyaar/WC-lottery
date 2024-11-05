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

    <title>فهرست ثبت نام کنندگان</title>
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
                            <div class="panel-heading">فهرست شرکت کنندگان</div>
                            <div class="panel-body">
                                <?php
                                $result = $connect->query("SELECT game_id,tel,team1_goal,team2_goal, win FROM `tbl_register` ORDER BY `id` DESC");
                                if($result->rowCount() >= 1) {
                                ?>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">عنوان مسابقه</th>
                                        <th scope="col">شماره تماس</th>
                                        <th scope="col">نتیجه پیش بینی</th>
                                        <th scope="col">وضعیت برد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($rows = $result->fetch(PDO::FETCH_ASSOC)) {
                                        $game_id = $rows["game_id"];
                                        $gameInfo = $connect->query("SELECT `team1`,team2 FROM `tbl_game` WHERE `id` = {$game_id}");
                                        $gameRow = $gameInfo->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <tr>
                                        <th scope="row"><?=$gameRow["team1"]." - ".$gameRow["team2"];?></th>
                                        <td scope="row"><?=tr_num($rows["tel"], 'fa');?></td>
                                        <td scope="row"><?=$gameRow["team1"]." ".tr_num($rows["team1_goal"], 'fa')." - ".$gameRow["team2"]." ".tr_num($rows["team2_goal"], 'fa');?></td>
                                        <td scope="row"><?=($rows["win"]=='yes')?"برنده شده":"-";?></td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php } else {
                                    ?>
                                    <span class="error">تا کنون شرکت کننده ای وجود نداشته است</span>
                                    <?php
                                }?>
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
