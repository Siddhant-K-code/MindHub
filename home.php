<?php
require_once( "common.inc.php" );
session_start();
if (!(isset($_SESSION['member']) && $_SESSION['member'] != '')) {
    header ("Location: login.php");
}

displayPageHeader('Home',true);
startWrapper();

$member = $_SESSION["member"];
$user_id = $member->getIdString();
$notifications = Notice::getNotifications( $user_id );
$private_questions = Query::getMyPrivateQueries( $user_id );

echo '
<h1>MindHub.</h1>
<p style="font-size:20px;"> We are happy you are here.</p>
<p>We want to make your as well as everyone’s life easy. Mindhub is all about you, by you, for you and with you. We are one of the most unique networks available today. With us you can share, get, learn, discuss, socialize, grow and help everyone grow.</p>
<p>A quick glance at the left side will showcase you all the features present in MindHub. You can read News shared by the community members. You can start a debate on any interesting topic and see the reactions of the community member. You can ask for experts advice(still work in progress) to get answers of some of the toughest questions and lot more.</p>
<p>Lets kickstart your journey at MindHub!</p><br>
';

if( $notifications != null ) {
	echo '<h3>Notifications.</h3>';
    date_default_timezone_set("Asia/Kolkata");
    foreach ($notifications as $notice ) {
		echo $notice->getNoticeString().'<br />';
	}
}

if( $private_questions != null ) {
    date_default_timezone_set("Asia/Kolkata");
	echo '<h3>Questions.</h3>';
    foreach ( $private_questions as $question ) {
        echo '<a href="answer.php?itemId=' . $question->getQueryId() . '" class="list-group-item">' . $question->getQuestionString() . ' <small>posted on '. $question->getAskedDate() .' by '. $question->getFirstNameString() .' '.$question->getLastNameString().'</small></a>';

	}
}
endWrapper();
displayPageFooter();