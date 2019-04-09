<?php
//file: view/matches/add.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$groupId = $view->getVariable("groupId");
$coupleId1 = $view->getVariable("coupleId1");
$coupleId2 = $view->getVariable("coupleId2");
$couples = $view->getVariable("couples");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Add Match");

?>

<div class="formulario">

	<h1><?= i18n("Add Result")?></h1>

	<form action="index.php?controller=matches&amp;action=add" method="POST">

		<input type="text" name="result" placeholder="<?= i18n("Result (3 Sets)") ?>">
		<?= isset($errors["result"])?i18n($errors["result"]):"" ?><br>

		<select name="winner" >

			<option value="<?php echo $coupleId1 ?>"><?php echo $couples[$coupleId1] ?></option>
			<option value="<?php echo $coupleId2 ?>"><?php echo $couples[$coupleId2] ?></option>

		</select>
		<?= isset($errors["winner"])?i18n($errors["winner"]):"" ?><br>

		<input type="hidden" name="groupId" value="<?= $groupId ?>">
		<input type="hidden" name="coupleId1" value="<?= $coupleId1 ?>">
		<input type="hidden" name="coupleId2" value="<?= $coupleId2 ?>">

		<div>
			<input class="form-btn" type="submit" name="submit" value="<?= i18n("Add") ?>">
			<a class="submit-btn fas fa-hand-point-left" href="index.php?controller=matches&amp;action=index&amp;groupId=<?= $groupId ?>"></a>
		</div>

	</form>

</div>
