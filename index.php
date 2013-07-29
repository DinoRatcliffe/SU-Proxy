<?php
$defaultUserAgent = "Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30";
$ch = curl_init();
if (isset($_GET['url'])) {
	$pageurl = $_GET['url'];
} else {
	echo "ERROR: no url given";
	exit(0);
}

if (isset($_GET['ua']) && $_GET['ua'] !== "") {
	$userAgent = $_GET['ua'];
} else {
	$userAgent = $defaultUserAgent;
}

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch,CURLOPT_USERAGENT,$userAgent);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt ($ch, CURLOPT_URL, $pageurl );
$html = curl_exec ( $ch );
curl_close($ch);

$pageurl = str_replace("http://", "", $pageurl);
$pageurl = str_replace("www.", "", $pageurl);

$urlroot = "http://www.".explode("/", $pageurl)[0];
$urlrootesc = str_replace(".", "\.", $urlroot);

$html = preg_replace ("#href=\"(?!http)#", "href=\"".$urlroot."/", $html);
$html = preg_replace ("#src=\"(?!http)#", "src=\"".$urlroot, $html);

$html = str_replace ("href=\"http", "href=\"/?ua=".$userAgent."&url=http", $html);

if ($html == "") {
	echo "ERROR: no site found";
} else {
	echo $html;
}

