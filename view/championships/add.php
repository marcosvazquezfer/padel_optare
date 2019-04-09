<?php
//file: view/championships/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$championship = $view->getVariable("championship");
$categories = $view->getVariable("categories");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Add Championship");

?>

<div class="formulario">

	<h1><?= i18n("Create championship")?></h1>

	<form action="index.php?controller=championships&amp;action=add" method="POST" enctype="multipart/form-data">

		<input type="text" name="name" value="<?= $championship->getName() ?>" placeholder="<?= i18n("Name") ?>">
		<?= isset($errors["name"])?i18n($errors["name"]):"" ?><br>

		<input type="number" name="maxParticipants" value="<?= $championship->getMaxParticipants() ?>" placeholder="<?= i18n("Max Participants") ?>">
		<?= isset($errors["maxParticipants"])?i18n($errors["maxParticipants"]):"" ?><br>

		<input type="file" name="normative" value="<?= $championship->getNormative() ?>" placeholder="<?= i18n("Normative") ?>">
		<?= isset($errors["normative"])?i18n($errors["normative"]):"" ?><br>

		<input type="datetime-local" name="deadLine" value="<?= $championship->getDeadLine() ?>" placeholder="<?= i18n("Dead Line") ?>">
		<?= isset($errors["deadLine"])?i18n($errors["deadLine"]):"" ?><br>

		<?php $cont = 0; ?>

		<?php foreach($categories as $category){ ?>

			<?php $check = "checkbox" . $cont; ?>

			<div class="check">

				<label>

					<input type="checkbox" name="checkbox[]" id="<?php echo $check ?>" value="<?php echo $category->getCategoryId() ?>">
					<?php echo $category->getLevel().$category->getGender() ?>
					<label for="<?php echo $check ?>"></label>
					
				</label>

			</div>

			<?php $cont = $cont+1; ?>

		<?php } ?>

		<div>

			<input class="form-btn" type="submit" name="submit" value="<?= i18n("Add") ?>">
			<a class="submit-btn fas fa-hand-point-left" href="index.php?controller=championships&amp;action=index&amp;championshipId=<?= $championship->getChampionshipId() ?>"></a>

		</div>

	</form>

</div>
