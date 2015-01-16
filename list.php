
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel=stylesheet type=text/css media=all href=style.css />
<script src='http://code.jquery.com/jquery-1.10.2.min.js'></script>
<script type='text/javascript'>
$(function(){
	$(".item").click(function(){
		var id = $(this).attr("value");
		$("#note"+id).slideToggle();
	});
	$("#category_title").click(function(){
		$("#category_table").slideToggle();
	});
});
</script>
<style type="text/css">
body {
    font-family: "Times New Roman";
    font: 10px;
}
</style>
<?php

include("mysql_connect.inc.php");
if ( isset($_GET['theme_id'] ) )
    $theme_id = $_GET['theme_id'];
?>

<table class=bordered>
<?php

$sql = "SELECT `id`, `theme` FROM `emoticon_papers_themes` WHERE id <=6 ORDER BY id";
$query = mysql_query($sql);
$themes = array();
while ( $row = mysql_fetch_row($query) ){
    array_push($themes, array("id"=>$row[0], "theme"=>$row[1]));
}
$query = "SELECT `id`, `Title`, `Author(s)`, `Year` FROM `emoticon_papers`";
$result = mysql_query($query);
$numfields = mysql_num_fields($result);
echo "<tr>";
for ( $i = 0 ; $i < $numfields ; $i++ ){
    if ( $i == 1 )
        echo '<th width=40%>';
    else if ( $i == 2 )
        echo '<th width=15%>';
    else
        echo '<th>';
    echo mysql_field_name($result, $i) . '</th>';
}

foreach ($themes as $theme){
    echo '<th class=theme width=1%>';
    echo '<a href="list.php?theme_id=' . $theme['id'] . '">';
    echo $theme['theme'];
    echo '</a>';
    echo '</th>';
}

echo "</tr>";

while ( $row = mysql_fetch_row($result) ){

    $sql2 = "SELECT `theme_id` FROM `emoticon_papers_theme_connections` WHERE `paper_id`=$row[0]";
    
    $query2 = mysql_query($sql2);
    $pthemes = array();
    while ( $row2 = mysql_fetch_row($query2) ){
        $pthemes[$row2[0]] = 1;
    }

    if ( isset($theme_id) && !isset($pthemes[$theme_id]) )
        continue;
    echo '<tr>';
    for ( $i = 0 ; $i < $numfields ; $i++ ) { // Header

        echo '<td>';
        if ( $i == 0 )
            echo "<a href='label_themes.php?id=$row[$i]'>";
        echo nl2br($row[$i]);
        if ( $i == 0 )
            echo "</a>";
        echo '</td>';
    }

    foreach ($themes as $theme){
        echo '<td>';
        if ( isset($pthemes[$theme['id']]) ) echo "v";
        echo '</td>';
    }

    echo '</tr>';
    
}


?>

</table>
