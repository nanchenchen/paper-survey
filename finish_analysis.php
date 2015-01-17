<?php
header("Content-Type: application/json");
include("mysql_connect.inc.php");

if ( !isset($_POST['id']) )
    exit;

$id = $_POST['id'];
$finished = $_POST['finished'];
$query = "UPDATE `social_science_papers` SET `finished` = $finished WHERE `id`=$id ";
//echo $query;
if ( mysql_query($query) ){
    echo json_encode(array("finished"=>$finished));
}

?>
