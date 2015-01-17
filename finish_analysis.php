<?php
header("Content-Type: application/json");
include("mysql_connect.inc.php");

if ( !isset($_POST['id']) )
    exit;

$id = $_POST['id'];
$finished = $_POST['finished'];
$query = "UPDATE `social_science_papers` SET `finished` = $finished WHERE `id`=$id ";
//echo $query;
$result = mysql_query($query);
if ( mysql_num_rows($result) == 0 ){
    echo "No this paper!";
    exit;
}

?>
