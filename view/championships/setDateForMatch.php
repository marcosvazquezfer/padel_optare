<?php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$match = $view->getVariable("match");
$dates = $view->getVariable("dates");

?>
<div class="formulario">
	<h1><?= i18n("Set Date For Match")?></h1>

	<form action="index.php?controller=championships&amp;action=setDateForMatch" method="POST">
	<?php if(array_key_exists(0, $dates)) list($date, $time) = split(' ', $dates[0]); ?>
		<select name="date1">
		<?php
		if(array_key_exists(0, $dates)){?> 
			<option selected value="<?php echo $date?>"><?php echo $date?></option> 
		<?php }  
                for ($day=0; $day < 7; $day++){
                    $actualDate = new DateTime();
                    $date = $actualDate->add(new DateInterval("P".$day."D"));
                    ?>
                    <option value="<?php echo $date->format('Y-m-d')?>"><?php echo $date->format('Y-m-d')?></option>
                    <?php
				}
            ?>
		</select>
		<select name="hour1">
		<?php
		if(array_key_exists(0, $dates)){?> 
			<option selected value="<?php echo $time?>"><?php echo substr($time, 0, 5)?></option>
		<?php }?>
			<option value="08:00:00">08:00</option>
			<option value="09:30:00">09:30</option>
			<option value="11:00:00">11:00</option>
			<option value="12:30:00">12:30</option>
			<option value="14:00:00">14:00</option>
			<option value="15:30:00">15:30</option>
			<option value="17:00:00">17:00</option>
			<option value="18:30:00">18:30</option>
		</select>
		<?php if(array_key_exists(1, $dates)) list($date, $time) = split(' ', $dates[1]); ?>
		<select name="date2">
		<?php
		if(array_key_exists(1, $dates)){?> 
			<option selected value="<?php echo $date?>"><?php echo $date?></option> 
		<?php }  
                for ($day=0; $day < 7; $day++){
                    $actualDate = new DateTime();
                    $date = $actualDate->add(new DateInterval("P".$day."D"));
                    ?>
                    <option value="<?php echo $date->format('Y-m-d')?>"><?php echo $date->format('Y-m-d')?></option>
                    <?php
                }
            ?>
		</select>
		<select name="hour2">
		<?php
		if(array_key_exists(1, $dates)){?> 
			<option selected value="<?php echo $time?>"><?php echo substr($time, 0, 5)?></option>
		<?php } ?>
			<option value="08:00:00">08:00</option>
			<option value="09:30:00">09:30</option>
			<option value="11:00:00">11:00</option>
			<option value="12:30:00">12:30</option>
			<option value="14:00:00">14:00</option>
			<option value="15:30:00">15:30</option>
			<option value="17:00:00">17:00</option>
			<option value="18:30:00">18:30</option>
		</select>

		<?php if(array_key_exists(2, $dates)) list($date, $time) = split(' ', $dates[2]); ?>
       <select name="date3">
	   <?php
		if(array_key_exists(2, $dates)){?> 
			<option selected value="<?php echo $date?>"><?php echo $date?></option> 
		<?php } 
                for ($day=0; $day < 7; $day++){
                    $actualDate = new DateTime();
                    $date = $actualDate->add(new DateInterval("P".$day."D"));
                    ?>
                    <option value="<?php echo $date->format('Y-m-d')?>"><?php echo $date->format('Y-m-d')?></option>
                    <?php
                }
            ?>
		</select>
		<select name="hour3">
		<?php
		if(array_key_exists(2, $dates)){?> 
			<option selected value="<?php echo $time?>"><?php echo substr($time, 0, 5)?></option>
		<?php } ?>
			<option value="08:00:00">08:00</option>
			<option value="09:30:00">09:30</option>
			<option value="11:00:00">11:00</option>
			<option value="12:30:00">12:30</option>
			<option value="14:00:00">14:00</option>
			<option value="15:30:00">15:30</option>
			<option value="17:00:00">17:00</option>
			<option value="18:30:00">18:30</option>
		</select>
		<input type="hidden" name="idMatch" value="<?= $match->getMatchId() ?>">
		<input class="submit-btn fas fa-user-plus" type="submit" name="submit" value="<?= i18n("Set Date")?>">
	</form>
</div>