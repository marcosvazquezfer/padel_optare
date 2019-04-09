<?php
    $view = ViewManager::getInstance();
    $matches = $view->getVariable("matches");
?> 

<div class="game-summary-container">
    <div class="game-summary-header">
        <h1><?= i18n("Available Matches") ?></h1>
    </div>
    <ul>
        <?php
            foreach ($matches as $match) {
                ?>
                    <li>
                        <div class="game-summary">
                            <form action="index.php?controller=championships&amp;action=setDateForMatch" method="POST">
                                <input type="hidden" name="idMatch" value="<?php echo $match->getMatchId()?>"/>
                                <a href="#" onclick="this.parentNode.submit()">
                                <?php
                                    if($match->getFeFinal() == null){
                                ?>
                                    <h2 class="game-summary-title"><?php echo ("Sin Fecha")?></h2>

                                    <?php
                                    }else{
                                ?>
                                    <h2 class="game-summary-title"><?php echo date_format(date_create($match->getFeFinal()),"d/m/Y")?></h2>
                                    <h3 class="game-summary-title"><?php echo date_format(date_create($match->getFeFinal()),"H:i")?></h3>
                                <?php
                                    }
                                ?>
                                </a>
                            </form>
                        </div>
                    </li>
                <?php
            }
        ?>
    </ul>
</div>