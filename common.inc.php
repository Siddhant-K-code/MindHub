<?php
require_once( "config.php" );
require_once( "Member.class.php" );
require_once( "LogEntry.class.php");
require_once( "News.class.php" );
require_once( "Debate.class.php" );
require_once( "DebateComments.class.php" );
require_once( "Query.class.php" );
require_once( "Answer.class.php" );
require_once( "Notice.class.php" );

function displayPageHeader( $pageTitle,$membersArea = false ) {

echo '<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>'.$pageTitle.' - MindHub.</title>

<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/main.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/js.js"></script>

</head>

<body>
';

}

function startWrapper(){

echo '
<div id="wrapper">

<!-- Sidebar -->

<link href="css/simple-sidebar.css" rel="stylesheet">

<header class="cd-header">
	<div class="header-wrapper">
		<div class="logo-wrap">
			<a href="#" class="hover-target"><span>SG</span>PA</a>
			</div>
			<div class="nav-but-wrap">
				<div class="menu-icon hover-target">
					<span class="menu-icon__line menu-icon__line-left"></span>
					<span class="menu-icon__line"></span>
					<span class="menu-icon__line menu-icon__line-right"></span>
				</div>					
			</div>					
		</div>
  </div>				
</header>

	<div class="nav">
		<div class="nav__content">
			<ul class="nav__list">
				<li class="nav__list-item active-nav"><a href="home.php" class="hover-target">Home</a></li>
				<li class="nav__list-item"><a href="news.php" class="hover-target">News</a></li>
				<li class="nav__list-item"><a href="debate.php" class="hover-target">Discussion</a></li>
				<li class="nav__list-item"><a href="profile.php" class="hover-target">Profile</a></li>
				<li class="nav__list-item"><a href="logout.php" class="hover-target">Log Out</a></li>
			</ul>
		</div>
	</div>

	
	
	</style>

<script>
(function($) { "use strict";
	
	//Navigation

	var app = function () {
		var body = undefined;
		var menu = undefined;
		var menuItems = undefined;
		var init = function init() {
			body = document.querySelector("body");
			menu = document.querySelector(".menu-icon");
			menuItems = document.querySelectorAll(".nav__list-item");
			applyListeners();
		};
		var applyListeners = function applyListeners() {
			menu.addEventListener("click", function () {
				return toggleClass(body, "nav-active");
			});
		};
		var toggleClass = function toggleClass(element, stringClass) {
			if (element.classList.contains(stringClass)) element.classList.remove(stringClass);else element.classList.add(stringClass);
		};
		init();
	}();

         
              
})(jQuery); 
</script>

<!-- /#sidebar-wrapper -->

 <!-- Page Content -->
<div id="page-content-wrapper">
<div class="container-fluid">
<div class="row" style="margin-top: 80px;">
<div class="col-lg-12">

';

}

function endWrapper(){

echo '
</div>
</div>
</div>
</div>
<!-- /#page-content-wrapper -->
        
</div>
<!-- /#wrapper -->
';

}

function displayPageFooter() {

echo '

<!-- Menu Toggle Script -->
<script>



</script>



</body>
</html>
	';
}

function validateField( $fieldName, $missingFields ) {
	if ( in_array( $fieldName, $missingFields ) ) {
		echo ' class="error"';
	}
}

function setChecked( DataObject $obj, $fieldName, $fieldValue ) {
	if ( $obj->getValue( $fieldName ) == $fieldValue ) {
		echo ' checked="checked"';
	}
}

function setSelected( DataObject $obj, $fieldName, $fieldValue ) {
	if ( $obj->getValue( $fieldName ) == $fieldValue ) {
		echo ' selected="selected"';
	}
}

function checkLogin() {
	session_start();
	if ( !$_SESSION["member"] or !$_SESSION["member"] = Member::getMember(  $_SESSION["member"]->getValue( "ID" ) ) ) {
		$_SESSION["member"] = "";
		header( "Location: login.bkp.php" );
		exit;
	}	else {
		$logEntry = new LogEntry( array (
			"memberId" => $_SESSION["member"]->getValue( "ID" ),
			"pageUrl" => basename( $_SERVER["PHP_SELF"] )
		) );
		$logEntry->record();
	}
}