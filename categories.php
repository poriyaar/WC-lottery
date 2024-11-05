<?php
include_once "connect.php";
include_once "jdf.php";
$errMsg = "";
if(isset($_POST["send"])) {
    if(isset($_POST["title"]) && !empty($_POST["title"])) {
        $title = escpae_input($_POST["title"]);
        $result = $connect->prepare("INSERT INTO `tbl_category` SET `title` = ?");
        if($result->execute(array($title))) {
            header("Location:categories.php?status=1");
            exit();
        } else {
            $errMsg = "خطا در ثبت موضوع - با پشتیبان سیستم ارتباط برقرار کنید";
        }
    } else {
        $errMsg = "عنوان را وارد کنید";
    }
}

if(isset($_GET["remove_id"]) && !empty($_GET["remove_id"]) && $_GET["remove_id"] > 0) {
    $id = (int) $_GET["remove_id"];
    $connect->query("DELETE FROM `tbl_category` WHERE `id` = {$id}");
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

    <title>موضوعات</title>
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
                            <div class="panel-heading">تعریف موضوع قرعه کشی</div>
                            <div class="panel-body">
                                <span class="error"><?=$errMsg;?></span>
                                <?php if(isset($_GET["status"]) && $_GET["status"] == 1) { ?>
                                    <span class="success">موضوع جدید با موفقیت ثبت شد</span>
                                <?php } ?>
                                <form class="form-horizontal" method="post" style="margin-top:11px;">
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <input type="text" style="width:48% !important;" class="form-control" id="title" name="title">
                                        </div>
                                        <label class="control-label col-sm-2" for="email">عنوان موضوع :</label>
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
                            <div class="panel-heading">فهرست موضوعات</div>
                            <div class="panel-body">
                                <?php
                                $result = $connect->query("SELECT * FROM `tbl_category`");
                                if($result->rowCount() >= 1) {
                                    ?>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">عنوان موضوع</th>
                                            <th scope="col">زمان ایجاد</th>
                                            <th scope="col">عملیات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while ($rows = $result->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?= tr_num($rows["title"], 'fa'); ?></th>
                                                <td><?=farsiDateTime($rows["created_time"]); ?></td>
                                                <td><a href="?remove_id=<?= $rows["id"]; ?>">حذف</a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    } else {
                                    ?>
                                    <span class="error">تا کنون موضوع قرعه کشی ثبت نشده است</span>
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
