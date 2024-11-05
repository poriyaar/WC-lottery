<?php
include_once "connect.php";
if(isset($_GET["id"]) && $_GET["id"] > 0) {
    $id = (int) $_GET["id"];
    $result = $connect->query("SELECT `game_id`, `tel` FROM `tbl_register` WHERE `id` = {$id} AND `win` = 'yes'");
    if($result->rowCount() == 1) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $tel = $row["tel"];
        $game_id = $row["game_id"];
        $r = $connect->query("SELECT `sms_verify` FROM `tbl_winner` WHERE `tel` = {$tel} AND `game_id` = {$game_id}");
        $sms_verify = $r->fetch(PDO::FETCH_ASSOC)["sms_verify"];
        if($sms_verify=="no") {
            $sms = SendSMS($tel, "جدید");
            $smsResult = SmsErrString($sms);
            if ($smsResult === true) {
                $connect->query("UPDATE `tbl_winner` SET `sms_verify` = 'yes' WHERE `tel` = {$tel} AND `game_id` = {$game_id}");
            }
        } else {
            $smsResult = "پیامک تبریک قبلا برای این شخص ارسال شده است";
        }
    } else {
        header("Location:lottery.php");
        exit();
    }
} else {
    header("Location:lottery.php");
    exit();
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

    <title>نتیجه ارسال پیامک</title>
    <?php include_once "_header.php"; ?>
</head>
<body>
<div id="wrapper">
    <!-- Sidebar -->
    <?php include_once "_menu.php"; ?>
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid" style="margin-top:80px;">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-5">
                    <div class="panel-group">
                        <div class="panel panel-primary">
                            <div class="panel-heading" style="text-align:center;">نتیجه ارسال پیامک</div>
                            <div class="panel-body" style="text-align:center;">
                                <?php if($smsResult===true) { ?>
                                <span class="success">پیامک ارسال شد</span>
                                <?php } else { ?>
                                <span class="error"><?=$smsResult;?></span>
                                <?php } ?>
                                <br>
                                <a href="winners.php">بازگشت به فهرست برندگان</a>
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

