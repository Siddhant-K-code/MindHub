<?php
require_once( "common.inc.php" );
session_start();
date_default_timezone_set("Asia/Kolkata");

if (!(isset($_SESSION['member']) && $_SESSION['member'] != '')) {
    header ("Location: login.php");
}

displayPageHeader('News',true);
startWrapper();

$newsId = $_GET['itemId'];
$newsData = News::getNewsData($newsId);
$date = date("F jS, Y", strtotime($newsData["date_posted"]));

echo '
<a href="news.php"><button class="btn btn-default" style="border: 1px solid;"><span class="glyphicon glyphicon-chevron-left"></span>BACK</button></a><br><br>';

echo '<h4><span class="glyphicon glyphicon-align-left"></span> '.$newsData["news_title"].'</h4>';
echo '
<p>
<strong>Source</strong> : 
<a href="'.$newsData["news_url"].'" target="_blank">'.$newsData["news_url"].'</a>
<br>
<span style="color:#bbb;font-weight:300;"> '.$date.'</span>
</p>
<hr>
';
echo '
<p class="text-justify">'.$newsData["news_author"].'</p>
<button class="btn btn-default" style="border: 1px solid;">True</button><button class="btn btn-default" style="border: 1px solid; margin: 15px">False</button>
';

endWrapper();
displayPageFooter();
?>