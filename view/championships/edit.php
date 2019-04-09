<?php
//file: view/championships/edit.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$championship = $view->getVariable("championship");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Edit Championship");

?>

<div class="formulario">

	<h1><?= i18n("Modify Championship") ?></h1>

	<form action="index.php?controller=championships&amp;action=edit" method="POST" enctype="multipart/form-data">

		<input type="text" name="name" 
		value="<?= isset($_POST["name"])?$_POST["name"]:$championship->getName() ?>" 
		placeholder="<?= i18n("Name") ?>">
		<?= isset($errors["name"])?i18n($errors["name"]):"" ?><br>

		<input type="number" name="maxParticipants"
		value="<?= isset($_POST["maxParticipants"])?$_POST["maxParticipants"]:$championship->getMaxParticipants()?>"
		placeholder="<?= i18n("Max Participants") ?>">
		<?= isset($errors["maxParticipants"])?i18n($errors["maxParticipants"]):"" ?><br>
		
		<input type="file" name="normative" value="<?= $championship->getNormative() ?>" placeholder="<?= i18n("Normative") ?>">
		<?= isset($errors["normative"])?i18n($errors["normative"]):"" ?><br>

		<input type="datetime-local" name="deadLine"
		value="<?= isset($_POST["deadLine"])?$_POST["deadLine"]:$championship->getDeadLine() ?>"
		placeholder="<?= i18n("Dead Line") ?>">
		<?= isset($errors["deadLine"])?i18n($errors["deadLine"]):"" ?><br>

		<input type="hidden" name="championshipId" value="<?= $championship->getChampionshipId() ?>">

		<div>
			<input class="form-btn" type="submit" name="submit" value="<?= i18n("Modify") ?>">
			<a class="submit-btn fas fa-hand-point-left" href="index.php?controller=championships&amp;action=index&amp;championshipId=<?= $championship->getChampionshipId() ?>"></a>
		</div>

	</form>

</div>
