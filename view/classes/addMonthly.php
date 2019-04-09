<?php
//file: view/classes/add.php
require_once __DIR__ . "/../../core/ViewManager.php";
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
?>
<div class="formulario">
	<h1><?=i18n("Add a Class")?></h1>
	<form action="index.php?controller=classes&amp;action=addMonthly" method="POST">
		<input type="text" name="trainer" placeholder="Trainer">
		<select name="level">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
        <select name="month">
			<option value="01">January</option>
			<option value="02">February</option>
			<option value="03">March</option>
			<option value="04">April</option>
			<option value="05">May</option>
			<option value="06">June</option>
            <option value="07">July</option>
			<option value="08">August</option>
			<option value="09">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
		</select>
        <select name="weekday">
			<option value="Monday">Monday</option>
			<option value="Tuesday">Tuesday</option>
			<option value="Wednesday">Wednesday</option>
			<option value="Thursday">Thursday</option>
			<option value="Friday">Friday</option>
			<option value="Saturday">Saturday</option>
			<option value="Sunday">Sunday</option>
		</select>
        <select name="begin">
			<option value="08:00:00">08:00</option>
			<option value="09:30:00">09:30</option>
			<option value="11:00:00">11:00</option>
			<option value="12:30:00">12:30</option>
			<option value="14:00:00">14:00</option>
			<option value="15:30:00">15:30</option>
			<option value="17:00:00">17:00</option>
			<option value="18:30:00">18:30</option>
		</select>
		<input class="submit-btn fas fa-user-plus" type="submit" value="<?=i18n("Add")?>">
	</form>
</div>
