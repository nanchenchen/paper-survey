<?php
header("Content-Type: application/json");
include("mysql_connect.inc.php");

if ( !isset($_GET['id']) )
    exit;

$id = $_GET['id'];
$query = "SELECT `user`, `timestamp`, `is_target`, `analysis` FROM `social_science_paper_analysis` WHERE `paper_id`=$id ORDER BY `timestamp` DESC LIMIT 0, 1 ";
//echo $query;
$result = mysql_query($query);
$response = new stdClass;
if ( $result && mysql_num_rows($result) > 0 ){
    $data = mysql_fetch_assoc($result);
    $response = $data;
}

echo json_encode($response);
?>
