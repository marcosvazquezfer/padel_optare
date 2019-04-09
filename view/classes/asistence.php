<?php
    $view = ViewManager::getInstance();
    $asistence = $view->getVariable("asistence");
?> 

<div class="class-summary-container">
    <div class="class-summary-header">
        <h1><?= i18n("Assistence") ?></h1>
    </div>
    <ul>
        <table>
            <?php
                foreach ($asistence as $asist) {
                    echo("<tr>");
                    echo("<td>") . $asist->getUserId() . "</td>";
                    echo("<td>");
                    if($asist->getControl() == 1){
                        echo "<img src=" ."http://icons.iconarchive.com/icons/paomedia/small-n-flat/32/sign-check-icon.png"."/>";
                    }else{
                        echo "<img src=" ."http://icons.iconarchive.com/icons/ampeross/qetto-2/32/no-icon.png"."/>";
                    }
                    echo("</td>");
                    ?>
                    <td>
                        <div class="button-container">
                            <a href="<?php echo "index.php?controller=classes&action=setAsistance&classId=" . $asist->getClassId() ."&fecha=" . $asist->getHorario()."&userId=".$asist->getUserId()."&control=".$asist->getControl() ?>">Controlar asistencia</a>
                        </div>
                    </td>
                    <?php
                }
            ?>
        </table>
    </ul>
</div>