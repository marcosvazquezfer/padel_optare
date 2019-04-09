<?php
//file: view/championship/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$championships = $view->getVariable("championships");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("title", "My Championships");

?>
<h1>

    <?=i18n("My Championships")?>
      
</h1>

<table class="tbase">

	<thead>

        <tr>
        
            <th><?= i18n("Name")?></th>
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
                    
                    <?php
                    //show actions ONLY for the author of the post (if logged)
                    if (isset($currentuser)): 
                    ?>

                        <a href="index.php?controller=championships&amp;action=viewAllMyMatches&amp;championshipId=<?= $championship->getChampionshipId() ?>">
                            <button onclick="myFunction()" class="dropbtn far fa-calendar"></button>
                        </a>
                        
                    <?php endif; ?>

                </td>

            </tr>

            <?php endforeach; ?>

    </tbody>

</table>
