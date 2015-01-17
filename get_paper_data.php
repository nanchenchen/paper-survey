<?php
header("Content-Type: application/json");
include("mysql_connect.inc.php");

if ( !isset($_GET['id']) )
    exit;

$id = $_GET['id'];
$query = "SELECT `title`, `authors`, `date`, `publication`, `attachments`, `finished` FROM `social_science_papers` WHERE `id`=$id ";
$result = mysql_query($query);
if ( mysql_num_rows($result) == 0 ){
    echo "No this paper!";
    exit;
}


$data = mysql_fetch_assoc($result);
$response = $data;
echo json_encode($response);
?>
