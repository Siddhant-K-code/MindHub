<?php
require_once( "common.inc.php" );
session_start();
if (!(isset($_SESSION['member']) && $_SESSION['member'] != '')) {
    header ("Location: login.php");
}

displayPageHeader('News',true);
startWrapper();

$newsList = News::getAllNews();

echo '<div class="page-header" style="margin-left: 100px;"><big>Verify News from all around You.</big ></div>';


echo '<section id="news" style="margin-top: 20px;"><style>a:hover {text-decoration: none;} </style>';
if($newsList!=null){
    date_default_timezone_set("Asia/Kolkata");
    foreach ($newsList as $news) {
		if ($news["news_id"]<5){
        $date = date("F jS, Y", strtotime($news["date_posted"]));
        echo '<a href="newsitem.php?itemId='.$news["news_id"].'" class="article">
    <h1>'.$news["news_title"].'</h1>
    <span class="timestamp">'.$date.'</span>
    <p class="sample">'.$news["news_author"].'</p>
    <h3>Discuss</h3>
  </a>';
    }}
}else{
    echo 'There are no news to read right now. Publish the first news post to get the spark going.';
}
echo '</div>';

endWrapper();
displayPageFooter();