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

    <title>پنل مدیریت</title>
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
                        <h1>قرعه کشی آنلاین مسابقات فوتبال</h1>
                        <br>
                        <p>اعتبار پنل پیامک :
                            <span>
                                <?= tr_num(28, 'fa'); ?>
                                <!-- GetMyCredit() == 28 -->
                            </span>
                        </p>
                        <br>
                        <p>با استفاده از این سامانه می توانید برای هر مسابقه فوتبال قرعه کشی برگزار کنید</p>
                        <br>
                        <p>ارسال پیامک برای کاربران : 1. پس از شرکت در قرعه کشی 2. پس از برنده شدن در قرعه کشی</p>
                        <br>
                        <p>دریافت پیامک از کاربران : 1. بابت شرکت در قرعه کشی 2. بابت مشاهده آخرین وضعیت شرکت کننده</p>
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