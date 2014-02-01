<?php

function setData($page,$items)
{
	$link = mysql_connect('localhost','root','passwd');
	
	mysql_select_db("invent_test",$link);
	
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
	
	$sql = 'SELECT * FROM feed LIMIT '.($page * $items).','.$items;
		
	$query = mysql_query($sql,$link) or die(mysql_error());
	
	$count = mysql_num_rows($query);
	
	if($count > 0)
	{
		$result = [];
		
		while ($row = mysql_fetch_assoc($query))
		{
			array_push($result,$row);
		}
		
		$result['count'] = mysql_num_rows(mysql_query('SELECT id FROM feed',$link));
		
		echo json_encode($result);
	}
	else
	{
		echo '[{}]';
	}
	
	mysql_close($link);
}

if(isset($_POST['page']) && isset($_POST['items'])){setData($_POST['page'],$_POST['items']);}

?>