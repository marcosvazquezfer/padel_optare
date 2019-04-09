<?php
//file: view/courts/view.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$courtId = $view->getVariable("courtId");
$date = $view->getVariable("date");
$time = $view->getVariable("time");
$occupations = $view->getVariable("occupations");
$hours = $view->getVariable("hours");
$busyHours = $view->getVariable("busyHours");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("title", "Court");

?>
<h1>

    <?=i18n("Court").' '.$courtId?>
      
</h1>

<table class="tbase">

	<thead>

        <tr>

            <th></th>
            <th><?php echo date_format(date_create($date),"d-m-Y");?></th>
            <?php for($i = 1; $i < 7; $i++){ ?>
                <?php 

                    $schedule = $date. ' ' .$time;
                    $startDateTime = new DateTime($schedule);
                    $nextDateTime = $startDateTime->add(new DateInterval("P".$i."D"));
                    $dateF = $nextDateTime->format('d-m-Y');
                ?>
                <th><?php echo $dateF ?></th>
            <?php } ?>
        
        </tr>

	</thead>

    <tbody>
            <!-- PONER COLORES EN FUNCION DE RESERVA -->
            <?php foreach($hours as $hour): ?>
                <tr>
                    <th><?php echo $hour ?></th>
                    <?php  $dateI = date_format(date_create($date),"d-m-Y"); ?>
                    <?php
                     $bookHour = $dateI.' '.$hour;
                     if(!array_key_exists($bookHour, $busyHours)): ?>
                        <td>FREE</td>
                    <?php else: ?>
                        <td><?php echo $busyHours[$bookHour] ?></td>
                    <?php endif; ?>
                    <?php for($i = 1; $i < 7; $i++){ ?>
                        <?php 
                            $schedule = $date. ' ' .$time;
                            $startDateTime = new DateTime($schedule);
                            $nextDateTime = $startDateTime->add(new DateInterval("P".$i."D"));
                            $dateF = $nextDateTime->format('d-m-Y');
                        ?>

                    <?php
                     $bookHour = $dateF.' '.$hour;
                     if(!array_key_exists($bookHour, $busyHours)): ?>
                            <td>FREE</td>
                        <?php else: ?>
                        <td><?php echo $busyHours[$bookHour] ?></td>
                        <?php endif; ?>
                        
                    <?php } ?>

                </tr>

                <?php foreach($occupations as $occupation): ?>

                    <?php

                        $timeStart = $occupation->getStartDate();
                        $hourO = substr($timeStart,11,5);

                    ?>

                    <?php if($hour == $hourO): ?>

                        <tr>

                            <th><?php echo $hourO ?></th>
                            <td><?php echo $occupation->getReserveType() ?></td>
                            <!-- PONER COLORES EN FUNCION DE RESERVA -->

                        </tr>

                    <?php endif; ?>

                <?php endforeach; ?>

            <?php endforeach; ?>

    </tbody>

</table>
