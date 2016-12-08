<?php
  
include "include/db_connect.php";
include "functions/functions.php";
session_start();
include "include/auth_cookie.php";
?>
<!DOCTYPE html>
<html ng-app='myApp' lang="pl">
 <head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />

	<link href="css/reset.css" rel="stylesheet" type="text/css" />
	  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css"> 
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link href="trackbar/trackbar.css" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.3/angular.js"></script>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.3/angular-route.js"></script>
	<script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="/js/jcarousellite_1.0.1.js"></script>
	<script type="text/javascript" src="/js/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="/trackbar/jquery.trackbar.js"></script>
	<script type="text/javascript" src="/js/shop-script.js"></script>

	<!-- <script type="text/javascript" src="/js/jquery.form.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.js"></script> -->
	<script type="text/javascript" src="/js/TextChange.js"></script>
	<script type="text/javascript">
	//----- fix -------
	var matched, browser;

	jQuery.uaMatch = function( ua ) {
		ua = ua.toLowerCase();

		var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
		/(webkit)[ \/]([\w.]+)/.exec( ua ) ||
		/(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
		/(msie) ([\w.]+)/.exec( ua ) ||
		ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
		[];

		return {
			browser: match[ 1 ] || "",
			version: match[ 2 ] || "0"
		};
	};

	matched = jQuery.uaMatch( navigator.userAgent );
	browser = {};

	if ( matched.browser ) {
		browser[ matched.browser ] = true;
		browser.version = matched.version;
	}

	if ( browser.chrome ) {
		browser.webkit = true;
	} else if ( browser.webkit ) {
		browser.safari = true;
	}

	jQuery.browser = browser;
</script>

<title>Rejestracja</title>
</head>
<body ng-controller="ProductController">

	<div id="block-body">
		<?php
		include "include/block-header.php";
		?>
		<div id="block-right">
			<?php
			include "include/block-category.php";
			include "include/block-parameter.php";
			include "include/block-news.php";
			?>
		</div>
		<div id="block-content">

			<h2 class="h2-title">Rejestracja</h2>
			<form  id="form_reg" ng-submit="reghandler()" name="userReg" novalidate>
			<p id="reg_message" ng-show="stopshow==1">Jesteś pomyślnie zarejestrowany!</p>
				<div id="block-form-registration" ng-init="stopshow=2" ng-show="stopshow==2">
					<ul id="form-registration" > 
						<li ng-class="{ 'has-error' : userReg.reg_login.$invalid && !userReg.reg_login.$pristine }" class="form-group">
							<label>Login</label>
							<span class="star" >*</span>
							<input type="text" name="reg_login" id="reg_login" class="form-control"  ng-model="customer.reg_login" ng-minlength="5" ng-maxlength="15" ng-blur="top=logcheck() " required/>
							<p ng-show="top" class="help-block">Login zajęty!</p>
							<p ng-show="userReg.reg_login.$error.minlength" class="help-block">Od 5 do 15 symboli!</p>
            				<p ng-show="userReg.reg_login.$error.maxlength" class="help-block">Od 5 do 15 symboli!</p>
						</li>

						<li ng-class="{ 'has-error' : userReg.reg_pass.$invalid && !userReg.reg_pass.$pristine }" class="form-group">
							<label>Hasło</label>
							<span class="star" >*</span>
							<input type="text" name="reg_pass" id="reg_pass" class="form-control" ng-model="customer.reg_pass" ng-minlength="7" ng-maxlength="15" required/><span id="genpass" ng-click="generate()">Zgenerować</span>
							
							
						</li>

						<li ng-class="{ 'has-error' : userReg.reg_surname.$invalid && !userReg.reg_surname.$pristine }" class="form-group">
							<label>Nazwisko</label>
							<span class="star" >*</span>
							<input type="text" name="reg_surname" id="reg_surname" class="form-control" ng-model="customer.reg_surname" ng-minlength="3" ng-maxlength="15" required/>
							<p ng-show="userReg.reg_surname.$invalid && !userReg.reg_surname.$pristine" class="help-block">Podaj nazwisko! </p>
							<p ng-show="userReg.reg_surname.$error.minlength" class="help-block">Od 3 do 15 symboli!</p>
            				<p ng-show="userReg.reg_surname.$error.maxlength" class="help-block">Od 3 do 15 symboli!</p>
						</li>

						<li ng-class="{ 'has-error' : userReg.reg_name.$invalid && !userReg.name.$pristine }" class="form-group">
							<label>Imię</label>
							<span class="star" >*</span>
							<input type="text" name="reg_name" id="reg_name" class="form-control" ng-model="customer.reg_name" ng-minlength="3" ng-maxlength="15" required/>
							<p ng-show="userReg.reg_name.$invalid && !userReg.reg_name.$pristine" class="help-block">Podaj imię! </p>
							<p ng-show="userReg.reg_name.$error.minlength" class="help-block">Od 3 do 15 symboli!</p>
            				<p ng-show="userReg.reg_name.$error.maxlength" class="help-block">Od 3 do 15 symboli!</p>
						</li>

						<li ng-class="{ 'has-error' : userReg.reg_email.$invalid && !userReg.reg_email.$pristine }" class="form-group">
							<label>E-mail</label>
							<span class="star" >*</span>
							<input type="text" name="reg_email" id="reg_email" class="form-control" ng-model="customer.reg_email" ng-minlength="10" ng-maxlength="30" ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/" required/>
							<p ng-show="userReg.reg_email.$invalid && !userReg.reg_email.$pristine" class="help-block">Podaj swój E-mail </p>
							<p ng-show="userReg.reg_email.$error.minlength" class="help-block">Od 10 do 30 symboli!</p>
            				<p ng-show="userReg.reg_email.$error.maxlength" class="help-block">Od 10 do 30 symboli!</p>
						</li>

						<li ng-class="{ 'has-error' : userReg.reg_phone.$invalid && !userReg.reg_phone.$pristine }" class="form-group">
							<label>Telefon</label>
							<span class="star" >*</span>
							<input type="text" name="reg_phone" id="reg_phone" class="form-control" ng-model="customer.reg_phone" ng-minlength="8" ng-maxlength="14" required/>
							<p ng-show="userReg.reg_phone.$invalid && !userReg.reg_phone.$pristine" class="help-block">Podaj numer telefonu! </p>
							<p ng-show="userReg.reg_phone.$error.minlength" class="help-block">Od 7 do 14 liczeb!</p>
            				<p ng-show="userReg.reg_phone.$error.maxlength" class="help-block">Od 7 do 14 lieczeb!</p>
						</li>

						<li ng-class="{ 'has-error' : userReg.reg_address.$invalid && !userReg.reg_address.$pristine }" class="form-group">
							<label>Adres dostawy</label>
							<span class="star" >*</span>
							<input type="text" name="reg_address" id="reg_address" class="form-control" ng-model="customer.reg_address" ng-minlength="8" ng-maxlength="50" required/>
							<p ng-show="userReg.reg_address.$invalid && !userReg.reg_address.$pristine" class="help-block">Masz podać adres dostawy! </p>
							
						</li>

						<li ng-class="{ 'has-error' : userReg.reg_captcha.$invalid && !userReg.reg_captcha.$pristine }" class="form-group">
							<div id="block-captcha">

								<img src="/reg/reg_captcha.php" />
								<input type="text" name="reg_captcha" id="reg_captcha" required/>
								<p id="reloadcaptcha">Aktualizować</p>
							</div>
						</li>

					</ul>
				</div>

				<p align="right" ><input class="btn btn-primary" type="submit" name="reg_submit"  value="Rejestracja" ng-click="stopshow=1" ng-disabled="userReg.$invalid"/></p>

			</form>

		</div>

		<?php
		include "include/block-footer.php";
		?>
	</div>

</body>
</html>
