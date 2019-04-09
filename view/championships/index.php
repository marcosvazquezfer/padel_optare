<?php
//file: view/championship/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$championships = $view->getVariable("championships");
$role = $view->getVariable("role");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("title", "Championship");

?>
<h1>

    <?=i18n("Championships")?>
    <?php if ($role == 'Administrator'): ?>
	    <a href="index.php?controller=championships&amp;action=add">
            <button onclick="myFunction()" class="dropbtn fas fa-trophy"></button>
        </a>
    <?php endif; ?>  
      
</h1>

<table class="tbase">

	<thead>

        <tr>
        
            <th><?= i18n("Name")?></th>
            <th><?= i18n("Inscription")?></th>
            <th><?= i18n("Max Participants")?></th>
            <th><?= i18n("Normative")?></th>
            <th><?= i18n("Actions")?></th>
        
        </tr>

	</thead>

    <tbody>

        <?php foreach ($championships as $championship): ?>

            <tr>
                <td>
                    <a href="index.php?controller=championships&amp;action=view&amp;championshipId=<?= $championship->getChampionshipId() ?>"><?= htmlentities($championship->getName()) ?></a>
                </td>

                <td>
                    <?= htmlentities($championship->getDeadLine()) ?>
                </td>

                <td>
                    <?= htmlentities($championship->getMaxParticipants()) ?>
                </td>

                <td>
                    <a href="index.php?controller=championships&amp;action=downloadNormative&amp;normative=<?php echo $championship->getNormative() ?>"><?= htmlentities($championship->getNormative()) ?></a>
                </td>

                <td>
                    
                    <?php
                    //show actions ONLY for the author of the post (if logged)
                    if ($role == 'Administrator'): 
                    ?>

                        <?php
                        // 'Edit Button'
                        ?>
                        <a href="index.php?controller=championships&amp;action=edit&amp;championshipId=<?= $championship->getChampionshipId() ?>">
                            <button onclick="myFunction()" class="dropbtn fas fa-pencil-alt"></button>
                        </a>

                        <?php
                        // 'Delete Button': show it as a link, but do POST in order to preserve
                        // the good semantic of HTTP
                        ?>
                        <form method="POST" action="index.php?controller=championships&amp;action=delete" id="delete_post_<?= $championship->getChampionshipId(); ?>" style="display: inline">

                            <input type="hidden" name="championshipId" value="<?= $championship->getChampionshipId() ?>">

                            <a href="#" onclick="if (confirm('<?= i18n("Are you sure?")?>')) {
                                document.getElementById('delete_post_<?= $championship->getChampionshipId() ?>').submit()
                            }">
                                <button onclick="myFunction()" class="dropbtn fas fa-trash-alt"></button>
                            </a>

                        </form>

                        &nbsp;

                        <a href="index.php?controller=championships&amp;action=generateCalendar&amp;championshipId=<?= $championship->getChampionshipId() ?>">
                            <button onclick="myFunction()" class="dropbtn far fa-calendar-plus"></button>
                        </a>

                    <?php
                    elseif(isset($currentuser)):
                    ?>

                        <a href="index.php?controller=championships&amp;action=enroll&amp;championshipId=<?= $championship->getChampionshipId() ?>">
                            <button onclick="myFunction()" class="dropbtn">Enroll</button>
                        </a>
                        
                    <?php endif; ?>

                </td>

            </tr>

            <?php endforeach; ?>

    </tbody>

</table>
