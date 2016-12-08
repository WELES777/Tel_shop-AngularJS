<div id="block-header">
	<div id="header-top-block">
		<ul id="header-top-menu" >
			<li>Wasze miasto - <span>Częstochowa</span></li>
			<li><a href="#">O nas</a></li>
			<li><a href="#">Nasze sklepy</a></li>
			<li><a href="feedback.php">Kontakt</a></li>
		</ul>
		<?php
		if ($_SESSION['auth'] == 'yes_auth')
		{
			echo '<p id="auth-user-info" align="right"><img src="/images/user.png" />Cześć, '.$_SESSION['auth_name'].'!</p>';   
		}else{
			echo '<p id="reg-auth-title" align="right"><a class="top-auth">Zaloguj</a><a href="registration.php">Rejestracja</a></p>';   
		}
		?>
		<div id="block-top-auth">
			<div class="corner"></div>
			<form method="post" name="userForm" ng-submit="submitForm(userForm.$valid)" novalidate>
				<ul id="input-email-pass">
					<h3><strong>Zaloguj</strong></h3>
					<p id="message-auth">Nieprawidłowy Login lub Hasło</p>
					<li class="form-group" ng-class="{ 'has-error' : userForm.username.$invalid && !userForm.username.$pristine }"><center>
						<input type="text" id="auth_login" placeholder="Login lub E-mail"  name="username" class="form-control" ng-model="user.username" ng-minlength="3" ng-maxlength="30" />
					</center></li>
					<p ng-show="userForm.username.$invalid && !userForm.username.$pristine" class="help-block">Login jest wymagany</p>
					<li class="form-group" ng-class="{ 'has-error' : userForm.userpass.$invalid && !userForm.userpass.$pristine }"><center>
						<input type="password" id="auth_pass" placeholder="Hasło"  name="userpass" class="form-control" ng-model="user.userpass" ng-minlength="3" ng-maxlength="15" />
						<span id="button-pass-show-hide"></span></center></li>
						<p ng-show="userForm.userpass.$invalid && !userForm.userpass.$pristine" class="help-block">Hasło jest wymagane.</p>
						<p ng-show="userForm.userpass.$error.maxlength" class="help-block">Hasło zbyt długie.</p> -->
					<ul id="list-auth" class="form-group">
						<li ><input type="checkbox" name="rememberme" id="rememberme" /><label for="rememberme">  Zapamiętaj mnie</label></li>
						<li><a id="remindpass" href="#">Nie pamiętasz hasła?</a></li>
					</ul>
					<button align="right" id="button-auth" ng-disabled="userForm.$invalid" ng-click="buttonAuth()" class="btn btn-primary" ><a>Zaloguj</a></button>
				</ul>
			</form>  
			<form name="userCallback" id="block-remind" ng-class="{ 'has-error' : userCallback.email.$invalid && !userCallback.email.$pristine }" novalidate>
				<h3><strong>Przypomnij hasło</strong></h3>
				<p id="message-remind" class="message-remind-success" ></p>
				<center><input id="remind-email" placeholder="Twój E-mail" type="email" name="email" class="form-control" ng-model="user.email" /></center>
				<p ng-show="userCallback.email.$invalid && !userCallback.email.$pristine" class="help-block">Wpisz poprawny email.</p>
				<p class="response"></p>
				<button  type="submit" id="button-remind" ng-click="remind()" class="btn btn-primary" ><a>Gotowe</a></button>
				<button id="prev-auth" class="btn btn-primary" >Wstecz</button>
			</form>
		</div>
	</div>
	<div id="top-line"></div>
	<div id="block-user" >
		<div class="corner2"></div>
		<ul>
			<li><img src="/images/user_info.png" /><a href="profile.php">Profil</a></li>
			<li><img src="/images/logout.png" /><a id="logout" ng-click="logout()" >Wyloguj</a></li>
		</ul>
	</div>
	<img id="img-logo" src="/images/logo.png" />
	<div id="personal-info" >
		<p align="right">Skontaktuj się z nami</p>
		<h3 align="right">812 258 633</h3>
		<img src="/images/phone-icon.png" />
		<p align="right">Godziny otwarcia:</p>
		<p align="right">Poniedziałek - Sobota: 8:00 - 21:00</p>
		<p align="right">Niedziela: 9:00 - 19:00</p>
		<img src="/images/time-icon.png" />
	</div>
<!--Filtr-->
	<div id="block-search" ng-show="true">
		<div class="row">
			<div class="col-md-3">
				<select ng-model="entryLimit" class="form-control" name="liczba towarów">
					<option>4</option>
					<option>8</option>
					<option>12</option>
					<option>20</option>
					<option>80</option>
				</select>
			</div>
			<div class="col-md-9">
				<input type="text" id="input-search" ng-model="search" ng-change="filter()" placeholder="Wpisz nazwę towaru" class="form-control" />

			</div>
			<div class="col-md-9" class="form-control" >
				<h5>Wyświetlono {{ filtered.length }} towarów z {{ totalItems}} obecnych</h5>
			</div>
		</div>
	</div>
</div>
<div id="top-menu">
	<ul>
		<li><img src="/images/shop.png" /><span ><a href="index.php">Strona główna</a></span></li>
		<li><img src="/images/new-32.png" /><span ng-click="sort_by('new');">Nowości</span></li>
		<li><img src="/images/bestprice-32.png" /><span ng-click="sort_by('leader');">Lider sprzedaż</span></li>
		<li><img src="/images/sale-32.png" /><span ng-click="sort_by('sale');">Wyprzedaż</span></li>
	</ul>
	<p align="right" id="block-basket"><img src="/images/cart-icon.png" /><a href="cart.php?action=oneclick" >Koszyk pusty</a></p>
	<div id="nav-line"></div>
</div>
