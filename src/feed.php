<?php
	
function processFeed()
{
	$content = file_get_contents('http://salud180.com.feedsportal.com/c/35415/f/667217/index.rss');
	$feed = new SimpleXmlElement($content);
	
	setData($feed);
}

function setData($feed)
{
	$sql = 'INSERT INTO feed(`id`,`guid`,`title`,`link`,`description`,`pubDate`,`comments`) VALUES';
	
	$fl = '';
	$count = 1;
	
	foreach($feed->channel->item as $entry)
	{
		$sql .= $fl.'(\''.$count.'\',\'';
		$sql .= mysql_real_escape_string($entry->guid).'\',\'';
		$sql .= mysql_real_escape_string($entry->title).'\',\'';
		$sql .= mysql_real_escape_string($entry->link).'\',\'';
		$sql .= mysql_real_escape_string($entry->description).'\',\'';
		$sql .= mysql_real_escape_string($entry->pubDate).'\',\'';
		$sql .= mysql_real_escape_string($entry->comments).'\')';
		
		$fl = ',';
		$count ++;
	}
	
	saveData($sql);
}

function saveData($sql)
{
	$link = mysql_connect('localhost','root','passwd');
	
	mysql_select_db("invent_test",$link);
	
	mysql_query('TRUNCATE TABLE feed;');
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
	
	print !mysql_query($sql,$link) ? mysql_error():'1';
	
	mysql_close($link);
}

processFeed();

?>