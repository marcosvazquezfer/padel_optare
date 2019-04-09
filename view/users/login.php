<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>
<div class="formulario">
	<h1><?= i18n("Login") ?></h1>
	<?= isset($errors["general"])?$errors["general"]:"" ?>

	<form action="index.php?controller=users&amp;action=login" method="POST">
		<input type="text" name="dni" placeholder="DNI">
		<input type="password" name="passwd" placeholder="password">
		<div>
			<input class="form-btn" type="submit" value="<?= i18n("Login") ?>">
			<a class="submit-btn fas fa-user-plus" href="index.php?controller=users&amp;action=register"></a>
		</div>
	</form>

</div>
