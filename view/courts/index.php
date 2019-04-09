<?php
//file: view/courts/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$courts = $view->getVariable("courts");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("title", "Courts");

?>

    <div class="class-summary-header">
        <h1><?=i18n("Courts")?></h1>&nbsp;
        <a href="index.php?controller=courts&amp;action=add"><i class="fas fa-plus-square fa-2x"></i></a> 
    </div>

<table class="tbase">

	<thead>

        <tr>
        
            <th><?= i18n("Number")?></th>
            <th><?= i18n("Court Type")?></th>
            <th><?= i18n("Actions")?></th>
        
        </tr>

	</thead>

    <tbody>

        <?php foreach ($courts as $court): ?>

            <tr>
                <td>
                    <a href="index.php?controller=courts&amp;action=view&amp;courtId=<?= $court->getIdCourt() ?>"><?= htmlentities($court->getIdCourt()) ?></a>
                </td>

                <td>
                    <?= htmlentities($court->getTypeCourt()) ?>
                </td>

                <td>
                    
                    <?php
                    //show actions ONLY for the administrators!!!!!!!!!!!!!!!!!!!!!!!!!
                    if (isset($currentuser)): 
                    ?>

                        <?php
                        // 'Delete Button': show it as a link, but do POST in order to preserve
                        // the good semantic of HTTP
                        ?>
                        <form method="POST" action="index.php?controller=courts&amp;action=delete" id="delete_post_<?= $court->getIdCourt(); ?>" style="display: inline">

                            <input type="hidden" name="courtId" value="<?= $court->getIdCourt() ?>">

                            <a href="#" onclick="if (confirm('<?= i18n("Are you sure?")?>')) {
                                document.getElementById('delete_post_<?= $court->getIdCourt() ?>').submit()
                            }">
                                <button onclick="myFunction()" class="dropbtn fas fa-trash-alt"></button>
                            </a>

                        </form>

                        &nbsp;

                    <?php endif; ?>

                </td>

            </tr>

            <?php endforeach; ?>

    </tbody>

</table>
