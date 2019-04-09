<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
$classId = $view->getVariable("classId");
?>
<div class="formulario">
	<h1><?= i18n("Send Message") ?></h1>
	<?= isset($errors["general"])?$errors["general"]:"" ?>

	<form action="index.php?controller=classes&amp;action=sendNotification" method="POST">
		<input hidden type="text" name="classId" value="<?php echo $classId;?>">
        <textarea name="message" rows="5" cols="60"></textarea>
		<div>
			<input class="form-btn" type="submit" value="<?= i18n("Send Message") ?>">
		</div>
	</form>

</div>
