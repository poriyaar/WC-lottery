<?php
include_once "connect.php";
if(isset($_GET["to"]) && isset($_GET["from"]) && isset($_GET["body"])) {
    if($_GET["from"] != "" && $_GET["body"] != "") {
        $body = $_GET["body"];
        if(preg_match("/^[0-9]{2}$/", $body)) {
            $bodyArr = str_split($body);
            $tel = $_GET["from"];
            $team1_goal = $bodyArr[0];
            $team2_goal = $bodyArr[1];
            $gameResult = $connect->query("SELECT `id` FROM `tbl_game` WHERE `active` = 'yes' ");
            $game_id = $gameResult->fetch(PDO::FETCH_ASSOC)["id"];

            $r = $connect->query("SELECT `id` FROM `tbl_register` WHERE `game_id` = {$game_id} AND `tel` = {$tel}");
            if($r->rowCount() == 1) {
                $msg = "شما قبلا در این پیش بینی شرکت کرده اید";
                SendSMS($tel, $msg);
            } else {
                $result = $connect->query("INSERT INTO `tbl_register` SET `game_id` = {$game_id}, `tel` ={$tel}, `team1_goal`={$team1_goal}, `team2_goal`={$team2_goal}");
                if($result) {
                    $msg = "سپاس از پیش بینی شما";
                    SendSMS($tel, $msg);
                } else {
                    SendSMS($tel, "خطا");
                }
            }
        }
    }
}