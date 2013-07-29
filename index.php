<?php
$ch = curl_init();
$pageurl = $_GET['url'];
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt ($ch, CURLOPT_URL, $pageurl );
$html = curl_exec ( $ch );
curl_close($ch);

$pageurl = str_replace("http://", "", $pageurl);
$pageurl = str_replace("www.", "", $pageurl);

$urlroot = "http://www.".explode("/", $pageurl)[0];
$urlrootesc = str_replace(".", "\.", $urlroot);

$html = str_replace ("href=\"(?!http)", "href=\"".$urlroot, $html);
$html = preg_replace ("#src=\"(?!http)#", "src=\"".$urlroot, $html);

$html = str_replace ("href=\"http", "href=\"/?url=http", $html);


echo $html;

