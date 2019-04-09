<?php
//file: view/users/register.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>
<div class="formulario">
	<h1><?= i18n("Register")?></h1>
	<form action="index.php?controller=users&amp;action=register" method="POST">
		<input type="text" name="dni" placeholder="DNI">
		<input type="text" name="nombre" placeholder="nombre">
		<input type="password" name="password" placeholder="password">
		<input type="password" name="password_confirm" placeholder="confirm password">
		<input type="text" name="email" placeholder="email">
		<select name="genero">
			<option value="M"><?= i18n("Male")?></option>
			<option value="F"><?= i18n("Female")?></option>
		</select>
		<input class="submit-btn fas fa-user-plus" type="submit" value="<?= i18n("Register")?>">
	</form>
</div>
