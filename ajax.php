<?php
include_once "connect.php";
include_once "jdf.php";
if(isset($_POST["category_id"]) && !empty($_POST["category_id"]) &&
    isset($_POST["game_id"]) && !empty($_POST["game_id"])) {
    $category_id = (int) $_POST["category_id"];
    $game_id = (int) $_POST["game_id"];

    $result = $connect->query("SELECT * FROM `tbl_register` WHERE `game_id` = {$game_id} AND `win` = 'yes' ORDER BY rand() LIMIT 1");
    if($result->rowCount() >= 1) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $game_id = $row["game_id"];
        $r = $connect->query("SELECT `team1`, team2 FROM `tbl_game` WHERE `id` = {$game_id}")->fetch(PDO::FETCH_ASSOC);
        $winner = $connect->prepare("INSERT INTO `tbl_winner` SET `game_id` = ?, `tel` = ?, `category_id` = ? ");
        $winner->execute(array($game_id, $row["tel"], $category_id));

        echo json_encode(array("id"=>$row["id"], "tel"=>tr_num($row["tel"], 'fa'), "team1"=>$r["team1"], "team2"=>$r["team2"],
           "team1_goal"=>tr_num($row["team1_goal"], 'fa'), "team2_goal"=>tr_num($row["team2_goal"], 'fa')));
    } else {
        echo json_encode(array("status"=>false));
    }
}
?>