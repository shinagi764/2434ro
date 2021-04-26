<head>
	<title>SERVERSTATUS</title>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="https://fonts.googleapis.com/css?family=Exo+2:300,400,600,900" rel="stylesheet">
	
</head>
<style type="text/css">
body{
	margin:0 auto;
	overflow:hidden;
	background-color:#f3f3f3;
	color:#6f6864;
	font-family: 'Exo';
	
}
.style1 {font-size: 11px; font-weight: bold}
.style2 {font-weight: bold}
.online {color: #7ca617}
.offline {color:#a40c00}
</style>
<?php
	$statusXML = 'https://renew.ragnahistory.com/?module=server&action=status-xml';
	// Do not touch from here
	@$fluxDir = dirname(dirname($scripturl));
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $statusXML);
	$data = curl_exec($ch);
	curl_close($ch);

	$xml = simplexml_load_string( $data );
	@$status = $xml->Group[0]->Server;
	$mapserver = (int)$status['mapServer'];
	$woeStatus = (int)$status['woeStatus'];
	$online_player = (int)$status['playersOnline'];
    $vendors = (int)$status['vendors'];
    $peakOnline = (int)$status['peakOnline'];
	$online = 'online';
	$offline = 'online';
?>
<body oncontextmenu="return false;">
<div class="style2" style="heght:30; width:100%; margin-left:0;">
  <div align="left" style="font-size:10px;"><b>PLAYERS <span class="<?php echo ($mapserver)? $online:$offline; ?>"><?php echo $online_player; ?></span></div>
  <div align="left" style="margin-top: -2px; font-size:10px; ">SERVER IS <span class="<?php echo ($mapserver)? $online:$offline; ?>" style="text-transform: uppercase;"> <?php echo ($mapserver)? $online:$offline; ?></span></div>
</div>
