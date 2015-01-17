<?php
header("Content-Type: application/json");
$request_body = file_get_contents('php://input');
//echo $request_body;
$json = json_decode($request_body, true);
//print_r($json);
include("mysql_connect.inc.php");

$user = $json["user"];
$paper_id = $json["paper_id"];
$is_target = $json["is_target"];

unset($json["paper_id"]);
$analysis = json_encode($json);

$sql = "INSERT INTO `social_science_paper_analysis` (`user`, `paper_id`, `is_target`, `analysis`) VALUES ";
$sql .= "('$user', $paper_id, $is_target, '" . mysql_real_escape_string($analysis) ."')";
mysql_query($sql);
$sql = "SELECT `user`, `timestamp` FROM `social_science_paper_analysis` WHERE `paper_id` = $paper_id ORDER BY `timestamp` DESC LIMIT 0, 1";
$query = mysql_query($sql);
if ( $row = mysql_fetch_row($query) )
    $data = array("user"=>$row[0], "timestamp"=>$row[1]);
echo json_encode($data);


?>
