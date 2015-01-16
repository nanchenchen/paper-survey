<?php

include("mysql_connect.inc.php");

if ( !isset($_POST['id']) )
    exit;

$id = $_POST['id'];
$sql = "DELETE FROM `emoticon_papers_theme_connections` WHERE `paper_id`=$id";
mysql_query($sql);

if ( isset($_POST['themes']) ){

    $sql = "INSERT INTO `emoticon_papers_theme_connections` (`paper_id`, `theme_id`) VALUES ";
    $cnt = 0;
    foreach ( $_POST['themes'] as $theme_id ){
        if ( $cnt++ > 0 ) $sql .= ", ";
        $sql .= "($id, $theme_id)";
    }
    if ( mysql_query($sql) )
        echo "Success!";
    else
        echo "Fail!";
}
else{
    echo "No selection now!";
}
?>

