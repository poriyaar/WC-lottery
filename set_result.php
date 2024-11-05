<?php
include_once "connect.php";
if(!isset($_GET["id"])) {
    header("Location:games.php");
    exit();
}

$id = (int) $_GET["id"];
$result = $connect->query("SELECT * FROM `tbl_game` WHERE `id` = {$id} AND `active` = 'yes' ");
if($result->rowCount() == 0) {
    header("Location:games.php");
    exit();
}
$errMsg = "";
if(isset($_POST["send"])) {
    if(isset($_POST["id"]) && $_POST["id"] != "" &&
        isset($_POST["team1_goal"]) && $_POST["team1_goal"] != "" &&
        isset($_POST["team2_goal"]) && $_POST["team2_goal"] != "" ) {
            $game_id = (int) $_POST["id"];
            $team1_goal = (int) $_POST["team1_goal"];
            $team2_goal = (int) $_POST["team2_goal"];
            $result = $connect->prepare("UPDATE `tbl_game` SET `team1_goal` = ?,`team2_goal` = ?, `active` = 'no' WHERE `id` = ?");
            if($result->execute(array($team1_goal, $team2_goal, $game_id))) {
                $connect->query("UPDATE `tbl_register` SET `win` = 'yes' WHERE `game_id` = {$game_id} AND `team1_goal` = {$team1_goal} AND `team2_goal` = {$team2_goal}");
               header("Location:games.php?set_result=1");
               exit();
            } else {
                $errMsg = "خطا در ثبت نتیجه بازی - با پشتیبان ارتباط برقرار کنید";
            }
    } else {
        $errMsg = "تعداد گل ها را مشخص کنید";
    }
}

$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ثبت نتیجه بازی</title>
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
                            <div class="panel-heading">ثبت نتیجه بازی</div>
                            <div class="panel-body">
                                <span class="error"><?=$errMsg;?></span>
                                <form class="form-horizontal" method="post" style="margin-top:11px;">
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="number" min="0" value="0" style="width:10% !important;" class="form-control" id="team1" name="team1_goal">
                                        </div>
                                        <label class="control-label col-sm-2" for="team1">تعداد گل های تیم <?=$row["team1"];?> :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="number" min="0" value="0" style="width:10% !important;" class="form-control" id="team2" name="team2_goal">
                                        </div>
                                        <label class="control-label col-sm-2" for="team1">تعداد گل های تیم <?=$row["team2"];?> :</label>
                                    </div>
                                    <input type="hidden" name="id" value="<?=$id;?>">
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success" name="send">ثبت و ذخیره</button>
                                        </div>
                                    </div>
                                </form>
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
