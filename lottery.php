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

    <title>قرعه کشی آنلاین</title>
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
                            <div class="panel-heading">قرعه کشی آنلاین</div>
                            <div class="panel-body">
                                <form class="form-horizontal" action="/action_page.php">
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <select class="form-control" name="category_id" id="category_id">
                                                <?php
                                                $result = $connect->query("SELECT * FROM `tbl_category` ORDER BY `id` DESC");
                                                while($rows = $result->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <option value="<?=$rows["id"];?>"><?=tr_num($rows["title"], 'fa');?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-2" for="category_id">نوع قرعه کشی :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <select class="form-control" name="game_id" id="game_id">
                                                <?php
                                                $result = $connect->query("SELECT * FROM `tbl_game` ORDER BY `id` DESC");
                                                while($rows = $result->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                    <option value="<?=$rows["id"];?>"><?=$rows["team1"]." - ".$rows["team2"];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-2" for="game">مسابقه :</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="button" class="btn btn-success" id="send">انجام قرعه کشی</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="panel panel-primary" style="margin-top: 40px !important;display:none;" id="winbox">
                            <div class="panel-heading">برنده قرعه کشی</div>
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">شماره تماس</th>
                                        <th scope="col">پیش بینی</th>
                                        <th scope="col">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row" id="wintel">09158930106</th>
                                        <td scope="row" id="winteam">اسپانیا 2 - ایران 1</td>
                                        <td scope="row"><a href="sendsms.php?id=" id="winsms">ارسال پیامک تبریک</a></td>
                                    </tr>
                                    </tbody>
                                </table>
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
<script>
    $(document).ready(function() {
        $("#send").click(function() {
            //$("#winbox").css("display", "block");
            var category_id = $("#category_id").val();
            var game_id = $("#game_id").val();
            $.post("ajax.php", {category_id:category_id, game_id:game_id}, function(response) {
                var data = JSON.parse(response);
                if(data.status===false) {
                    alert("شرکت کننده ای وجود ندارد");
                } else {
                    //alert(data.team1 + " " + data.team2 + " " + data.tel);
                    $("#winbox").css("display", "block");
                    $("#wintel").html(data.tel);
                    $("#winteam").html(data.team1 + " " + data.team1_goal + " - " + data.team2 + " " + data.team2_goal);
                    $("#winsms").attr("href", "sendsms.php?id=" + data.id);
                }
            });
        });
    });
</script>
</body>
</html>
