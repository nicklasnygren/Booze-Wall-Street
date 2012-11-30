<?php 
//WALLSTREET PARTY!

$command = $_GET["f"];

global $con;
$con = mysql_connect("localhost","root","Arn3balle");
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("wallstreet", $con);


function getLatestPrices () {
	global $con;
	$res = mysql_query("SELECT * FROM prices ORDER BY id DESC LIMIT 0,1", $con) or die(mysql_error());
	$row = mysql_fetch_array($res);
	$returnString = "";
	for ($i = 0; $i < 4; $i++) {
		$returnString .= $row["price_$i"];
		if ($i < 3) $returnString .= ",";
	}
	echo $returnString;
}

function postPrices ($p1,$p2,$p3,$p4) {
	global $con;
	mysql_query("INSERT INTO prices (price_0, price_1, price_2, price_3) VALUES ($p1, $p2, $p3, $p4)", $con) or die(mysql_error());
}

switch ($command) {
	case "latest":
		getLatestPrices();
		break;
		
	case "post":
		$p1 = $_GET["p1"];
		$p2 = $_GET["p2"];
		$p3 = $_GET["p3"];
		$p4 = $_GET["p4"];
		postPrices($p1,$p2,$p3,$p4);
		
	default:
		break;
}

?>