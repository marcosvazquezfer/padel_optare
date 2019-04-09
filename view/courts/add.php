<?php
//file: view/courts/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$errors = $view->getVariable("errors");

$view->setVariable("title", "Add Court");

?>

<div class="formulario">

	<h1><?= i18n("Add Court")?></h1>

	<form action="index.php?controller=courts&amp;action=add" method="POST">

        <!-- POSIBLE LISTA SELECCIONABLE CON TIPOS PREDEFINIDOS -->
		<input type="text" name="courtType" value="" placeholder="<?= i18n("Court Type") ?>">
		<?= isset($errors["courtType"])?i18n($errors["courtType"]):"" ?><br>

		<input type="time" name="timeStart" value="" placeholder="<?= i18n("Time Start") ?>">
		<?= isset($errors["timeStart"])?i18n($errors["timeStart"]):"" ?><br>

		<input type="time" name="timeEnd" value="" placeholder="<?= i18n("Time End") ?>">
		<?= isset($errors["timeEnd"])?i18n($errors["timeEnd"]):"" ?><br>

		<div>

			<input class="form-btn" type="submit" name="submit" value="<?= i18n("Add") ?>">
			<a class="submit-btn fas fa-hand-point-left" href="index.php?controller=courts&amp;action=index"></a>

		</div>

	</form>

</div>
