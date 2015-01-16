<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.css">
<link rel=stylesheet type="text/css" media=all href=style.css />
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/angular.min.js"></script>
<title>Social Science Papers</title>

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
</head>
<body>
<h1>Social Science Papers</h1>
<?php

include("mysql_connect.inc.php");

$sort_c = "date";
$order = "ASC";

if (isset($_GET['sort']) )
{
	$sort_c = preg_replace("/[\']+/" , '' ,$_GET['sort']);

}
if ( isset($_GET['order']) )
{
	$o = preg_replace("/[\']+/", '', $_GET['order']);
	if ( (!strcmp($o, "ASC")) || (!strcmp($o, "DESC")) )
		$order = $o;
}

$sort = "`$sort_c` $order";
if (strcmp($sort_c, "date") != 0)
	$sort .= " , `date`";


echo "<table class=bordered>";
echo "<tr>";
$th   = array("Last Edit", "id", "Title", "Year", "Authors", "Type", "Publication", "Citation Count", "");
$th_v = array("analyzed", "id", "title", "date", "authors", "type", "publication", "citation_count", "");
$th_w = array("12%", "3%", "39.3%", "3%", "16.1%", "8.1%", "19.8%", "3%", "2%");
$th_n = count($th);
for ($i = 0 ; $i < $th_n ; $i++)
{
	echo "<th width=". $th_w[$i] . ">";
	$o = "ASC";
	if ( ((!strcmp($th_v[$i], $sort_c)) && !strcmp($order, "ASC")) ||
		(!strcmp($th_v[$i], "citation_count")) && (strcmp($sort_c, "citation_count") != 0) )
		$o = "DESC";
	echo "<a href='view_list.php?sort=".$th_v[$i] . "&order=$o'>";
	echo "<div>";

	echo $th[$i];
	echo "</div>";
	echo "</a>";
	echo "</th>";
}
echo "</tr>";

$sql = "SELECT * FROM `social_science_papers` ORDER BY $sort";
$query = mysql_query($sql);
while ($row = mysql_fetch_assoc($query))
{
	$id = $row['id'];
	echo "<tr id='item$id' value=$id class='item' >";
    echo "<td>";
    //if ( $row['analyzed'] ) echo "v";
    $sql2 = "SELECT `user`, `timestamp` FROM `social_science_paper_analysis` WHERE `paper_id`=$id";
    $query2 = mysql_query($sql2);
    if ( $query2 && $row2 = mysql_fetch_assoc($query2) ){
        echo $row2['timestamp'] . " <br />by " . $row2['user'];
    }
    echo "</td>";
    
    echo "<td>" . $row['id'] . "</td>";
	echo "<td>" . $row['title'] . "</td>";
	echo "<td>" . $row['date'] . "</td>";
	echo "<td>" . $row['authors'] . "</td>";
	echo "<td>" . $row['type'] . "</td>";
	echo "<td>" . $row['publication'] . "</td>";
	echo "<td>" . $row['citation_count'] . "</td>";
    echo "<td>" . "<a class='btn btn-primary' href='analyze.php?id=" . $row['id'] . "'>" . "Analyze→" . "</a>" . "</td>";
	echo "</tr>\n";
	echo "<tr class=note_tr id=note_tr$id>";
	echo "<td colspan=8>";
	echo "<div class=note id=note$id>" . $row['abstract'] . "</div>";
	echo "</td>";
    
	echo "</tr>";
}
	echo "</table>";

?>
</body>
</html>