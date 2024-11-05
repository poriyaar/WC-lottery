<?php
include_once "connect.php";
include_once "jdf.php";
$errMsg = "";
if(isset($_POST["send"])) {
    if(isset($_POST["team1"]) && !empty($_POST["team1"])
        && isset($_POST["team2"]) && !empty($_POST["team2"])) {
        $team1 = escpae_input($_POST["team1"]);
        $team2 = escpae_input($_POST["team2"]);

        $connect->query("UPDATE `tbl_game` SET `active` = 'no' WHERE `active` = 'yes'");
        $result = $connect->prepare("INSERT INTO `tbl_game` SET `team1` = ?, `team2` = ?, `active` = 'yes'");
        if($result->execute(array($team1, $team2))) {
            header("Location:games.php?status=1");
            exit();
        } else {
            $errMsg = "خطا در ثبت مسابقه - با پشتیبان سیستم ارتباط برقرار کنید";
        }
    } else {
        $errMsg = "مقادیر را تکمیل کنید";
    }
}

if(isset($_GET["remove_id"]) && !empty($_GET["remove_id"]) && $_GET["remove_id"] > 0) {
    $id = (int) $_GET["remove_id"];
    $connect->query("DELETE FROM `tbl_game` WHERE `id` = {$id}");
}

if(isset($_GET["active_id"]) && !empty($_GET["active_id"]) && $_GET["active_id"] > 0) {
    $id = (int) $_GET["active_id"];
    $connect->query("UPDATE `tbl_game` SET `active` = 'yes' WHERE `id` = {$id}");

    $connect->query("UPDATE `tbl_game` SET `active` = 'yes' WHERE `id` = {$id}");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>مسابقات</title>
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
                        <div class="panel panel-primary">
                            <div class="panel-heading">تعریف مسابقه</div>
                            <div class="panel-body">
                                <span class="error"><?=$errMsg;?></span>
                                <?php if(isset($_GET["status"]) && $_GET["status"] == 1) { ?>
                                    <span class="success">موضوع جدید با موفقیت ثبت شد</span>
                                <?php } ?>
                                <form class="form-horizontal" method="post" style="margin-top:11px;">
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="text" style="width:48% !important;" class="form-control" id="team1" name="team1">
                                        </div>
                                        <label class="control-label col-sm-2" for="team1">تیم اول :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="text" style="width:48% !important;" class="form-control" id="team2" name="team2">
                                        </div>
                                        <label class="control-label col-sm-2" for="team1">تیم دوم :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success" name="send">ثبت و ذخیره</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="panel panel-primary" style="margin-top: 40px !important;">
                            <div class="panel-heading">فهرست مسابقات</div>
                            <div class="panel-body">
                                <?php if(isset($_GET["set_result"]) && $_GET["set_result"] == 1) { ?>
                                    <span class="success">نتیجه بازی با موفقیت ثبت گردید</span>
                                <?php
                                }
                                $result = $connect->query("SELECT id,team1,team2,team1_goal,team2_goal,active FROM `tbl_game` ORDER BY `id` DESC");
                                if($result->rowCount() >= 1) { ?>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">عنوان مسابقه</th>
                                        <th scope="col">نتیجه مسابقه</th>
                                        <th scope="col">وضعیت</th>
                                        <th scope="col">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($rows = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?=$rows["team1"]." - ".$rows["team2"];?></th>
                                        <td scope="row"><?=($rows["team1_goal"]==-1)?"بازی تمام نشده":$rows["team1"]." ".tr_num($rows["team1_goal"], 'fa')." - ".
                                                $rows["team2"]." ".tr_num($rows["team2_goal"], 'fa');?>
                                        </td>
                                        <td scope="row"><?=($rows["active"]=="yes")?"فعال":"غیر فعال";?></td>
                                        <td scope="row"><a href="?remove_id=<?=$rows["id"];?>">حذف</a>
                                            &nbsp;
                                            <?php if($rows["active"]=="no") {
                                                if($rows["team1_goal"] == -1) {
                                                ?>
                                            <a href="?active_id=<?=$rows["id"];?>">فعال سازی</a>
                                            <?php }
                                            } else { ?>
                                                <a href="set_result.php?id=<?=$rows["id"];?>">ثبت نتیجه</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php } else {
                                    ?>
                                    <span class="error">مسابقه ای تا کنون تعریف نشده است</span>
                                    <?php
                                } ?>
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
