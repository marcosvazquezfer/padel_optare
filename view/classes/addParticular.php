<?php
//file: view/classes/add.php
require_once __DIR__ . "/../../core/ViewManager.php";
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
?>
<div class="formulario">
	<h1><?=i18n("Add a Class")?></h1>
	<form action="index.php?controller=classes&amp;action=addParticular" method="POST">
		<input type="text" name="trainer" placeholder="Trainer">
		<select name="level">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
		<input type="datetime-local" name="begin">
		<input class="submit-btn fas fa-user-plus" type="submit" value="<?=i18n("Add")?>">
	</form>
</div>
