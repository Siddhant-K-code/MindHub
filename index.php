<?php
require_once( "common.inc.php" );
session_start();

if(isset($_SESSION['member'])){
    header("Location: home.php");
}
if ( isset( $_POST["action"] ) and $_POST["action"] == "login" ){
    loginForm();
} else if ( isset( $_POST["action"] ) and $_POST["action"] == "register" ){
    registerForm();
} else {
    displayForm(array(), array(), new Member(array()));
}


function displayForm( $errorMessages, $missingFields, $member ) {
    displayPageHeader( "Welcome", true );

    echo '
	<div class="form-wrap">
		<div class="tabs">
			<h3 class="signup-tab"><a href="#signup-tab-content">Sign Up</a></h3>
			<h3 class="login-tab"><a class="active" href="#login-tab-content">Login</a></h3>
		</div><!--.tabs-->

		<div class="tabs-content">
			<div id="signup-tab-content">
				<form class="signup-form" action="" method="post">
					<input type="hidden" name="action" value="register" />

					<div class="input-group" style="margin-bottom: 13px;">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input name="emailAddress" placeholder="Email Address" class="form-control"  type="email" required>
					</div>
					<div class="input-group" style="margin-bottom: 13px;">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input name="username" placeholder="Desired Username" class="form-control"  type="text" required>
					</div>
					<div class="input-group" style="margin-bottom: 13px;">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input name="password1" placeholder="Password" class="form-control"  type="password" required>
					</div>
					<div class="input-group" style="margin-bottom: 13px;">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input name="password2" placeholder="Retype Password" class="form-control"  type="password" required>
					</div>
					<div class="input-group" style="margin-bottom: 13px;">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input name="aadharNo" placeholder="Aadhar Card No." class="form-control"  type="text" required>
					</div>
					<input type="submit" class="button" value="Sign Up">
				</form><!--.signup-form-->
				<div class="help-text">
					<p style="margin-bottom: 0px;">By signing up, you agree to our</p>
					<p><a href="#">Terms of service</a></p>
				</div><!--.help-text-->
			</div><!--.signup-tab-content-->
			
			
			

			<div id="login-tab-content" class="active">
				<form class="login-form" action="" method="post" id="login_form" style="margin: 0 auto;">
					<input type="hidden" name="action" value="login" />
					<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input name="username" placeholder="Username" class="form-control"  type="text" style="margin-bottom: 13px;">
					</div>
					<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input name="password" placeholder="Password" class="form-control"  type="password">
					</div>					
					<input type="checkbox" class="checkbox" id="remember_me">
					<label for="remember_me">Remember me</label>

					<input type="submit" class="button" value="Login">
				</form><!--.login-form-->
				<div class="help-text">
					<p><a href="#">Forget your password?</a></p>
				</div><!--.help-text-->
			</div><!--.login-tab-content-->
		</div><!--.tabs-content-->
	</div><!--.form-wrap-->
	
	<script>
jQuery(document).ready(function($) {
	tab = $(".tabs h3 a");
	console.log();
	tab.on("click", function(event) {
		event.preventDefault();
		tab.removeClass("active");
		$(this).addClass("active");

		tab_content = $(this).attr("href");
		$("div[id$="tab-content"]").removeClass("active");
		$(tab_content).addClass("active");
	});
});
	</script>
';

if ( $errorMessages ) {

echo '
<!-- Error Message --> 
<div class="form-group">
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
';

    foreach ( $errorMessages as $errorMessage ) {
        echo '      '.$errorMessage;
    }

echo '
    </div>
  </div>
</div>';

}

echo '
</form>
</div>
</div>

</div>
 ';

    displayPageFooter();
}

function loginForm() {
    $requiredFields = array( "username", "password" );
    $missingFields = array();
    $errorMessages = array();

    $member = new Member( array(
        "username" => isset( $_POST["username"] ) ? preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["username"] ) : "",
        "password" => isset( $_POST["password"] ) ? preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["password"] ) : "",
    ) );

    $username = $member->getValue( "username" );
    $password = $member->getValue( "password" );

    foreach ( $requiredFields as $requiredField ) {
        if ( !$member->getValue( $requiredField ) ) {
            $missingFields[] = $requiredField;
        }
    }

    if($missingFields){
        $errorMessages[] = '<p class="error">*Enter all the necessary fields</p>';
    }	elseif (!$loggedInMember = $member->authenticate()){
        $errorMessages[] = '<p class="error">The authentication can not be made, try Again or be a <a href="register.php">New White Hat.</a></p>';
    }

    if ( $errorMessages ) {
        displayForm( $errorMessages, $missingFields, $member );
    }	else {
        $_SESSION['member'] = $loggedInMember;
        displayThanks();
    }
}

function registerForm() {
    $requiredFields = array("username", "password", "emailAddress", "aadharNo");
    $missingFields = array();
    $errorMessages = array();

    $member = new Member( array(
        "username"=>isset( $_POST["username"] ) ? preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["username"] ) : "",
        "password"=>(isset( $_POST["password1"] ) and isset( $_POST["password2"] ) and ($_POST["password1"] == $_POST["password2"])) ? preg_replace( "/[^ \'\_a-zA-Z0-9]/", "", $_POST["password1"] ) : "",
        "emailAddress"=>isset( $_POST["emailAddress"] ) ? preg_replace( "/[^ \@\.\-\_a-zA-Z0-9]/", "", $_POST["emailAddress"] ) : "",
		"aadharNo"=>isset( $_POST["aadharNo"] ) ? preg_replace( "/[^ \-\_0-9]/", "", $_POST["aadharNo"] ) : ""
    )   );

    foreach ( $requiredFields as $requiredField ) {
        if ( !$member->getValue($requiredField)) {
            $missingFields[] = $requiredField;
        }
    }

    if ( $missingFields ) {
        $errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click send details to resend the form.</p>';
    }

    if ( !isset( $_POST["password1"] ) or !isset( $_POST["password2"] ) or !$_POST["password1"] or !$_POST["password2"] or ( $_POST["password1"] != $_POST["password2"] ) ) {
        $errorMessages[] = '<p class="error">Please make sure you enter your password correctly in both password fields.</p>';
    }

    if ( Member::getByUsername( $member->getValue( "username" ) ) ) {
        $errorMessages[] = '<p class="error">A member with that username already exist. Please choose another username.</p>';
    }

    if ( Member::getByEmailAddress( $member->getValue( "emailAddress" ) ) ) {
        $errorMessages[] = '<p class="error">A member with that email address already exist. Please choose another email address, or contact webmaster to retrive your password.</p>';
    }

    if ( $errorMessages ) {
        displayForm( $errorMessages, $missingFields, $member );
    }	else {
        $member->insert();
        displayThanks();
    }
}

function displayThanks() {
    header("Location:home.php");
    exit();

    displayPageFooter();
}