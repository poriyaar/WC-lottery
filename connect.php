<?php
date_default_timezone_set("Asia/Tehran");
$DBName = "lottery";
define("API_URL", "http://api.payamak-panel.com/post/Send.asmx?wsdl");
define("USERNAME", "09158930106");
define("PASSWORD", "9336");

try {
    $connect = new PDO("mysql:host=localhost;dbname={$DBName}", "root", "");
    $connect->exec("SET CHARSET SET UTF8");
    $connect->exec("SET NAMES UTF8");
} catch (PDOException $error) {
    echo $error->__toString();
}

function escpae_input($value)
{
    return addslashes(htmlentities(trim($value)));
}

function farsiDateTime($date)
{
    $array = explode(' ', $date);
    list($year, $month, $day) = explode('-', $array[0]);
    list($hour, $minute, $second) = explode(':', $array[1]);
    $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    $fdate = jdate("Y/m/d H:i:s", $timestamp);
    return $fdate;
}

function SendSMS($tel_list, $content)
{
    ini_set("soap.wsdl_cache_enabled", "0");
    try {
        $client = new SoapClient(API_URL);
        $param["username"] = USERNAME;
        $param["password"] = PASSWORD;
        $param["from"] = "500010605862";
        $param["to"] = $tel_list;
        $param["text"] = $content;
        $param["isflash"] = false;
        return $client->SendSimpleSMS2($param)->SendSimpleSMS2Result;
    } catch (SoapFault $err) {
        echo $err->faultstring;
    }
}

function GetMyCredit()
{
    $client = new SoapClient(API_URL);
    $param["username"] = USERNAME;
    $param["password"] = PASSWORD;
    return ceil($client->GetCredit($param)->GetCreditResult);
}

function SmsErrString($code)
{
    switch ($code) {
        case 0:
            return "نام کاربری رمز عبور اشتباه است";
            break;
        case 2:
            return "اعتبار کافی نمی باشد.";
            break;
        case 3:
            return "محدودیت در ارسال روزانه";
            break;
        case 4:
            return "محدودیت در حجم ارسال";
            break;
        case 5:
            return ".شماره فرستنده معتبر نمی باشد.";
            break;
        case 6:
            return "سامانه در حال بروزرسانی می باشد.";
            break;
        case 7:
            return "متن حاوی کلمه فیلتر شده می باشد.";
            break;
        case 9:
            return "ارسال از خطوط عمومی از طریق وب سرویس امکان پذیر نمی باشد.";
            break;
        case 10:
            return "کاربر مورد نظر فعال نمی باشد";
            break;
        case 11:
            return "خطا در ارسال";
            break;
        case 12:
            return "مدارک کاربر کامل نمی باشد";
            break;

        default:
            return true;
    }
}
