<?php
    $view = ViewManager::getInstance();
    $games = $view->getVariable("games");
	$gamesInWhichIParticipate = $view->getVariable("gamesInWhichIParticipate");
    $numAthletes = $view->getVariable("numAthletes");
?> 

<div class="game-summary-container">
    <div class="game-summary-header">
        <h1><?= i18n("Available Games") ?></h1>
        <a href="index.php?controller=games&amp;action=viewPromotion"><i class="fas fa-plus-square fa-2x"></i></a> 
    </div>
    <ul>
        <?php
            foreach ($games as $game) {
                $participating = '';
                if($gamesInWhichIParticipate[$game->getIdGame()]) $participating = 'participating'
                ?>
                    <li>
                        <div class="game-summary <?php echo $participating?>">
                            <form action="index.php?controller=games&amp;action=addAthlete" method="POST">
                                <input type="hidden" name="idGame" value="<?php echo $game->getIdGame()?>"/>
                                <a href="#" onclick="this.parentNode.submit()">
                                    <div class='game-image-container'></div>
                                    <h2 class="game-summary-title"><?php echo date_format(date_create($game->getDate()),"d/m/Y")?></h2>
                                    <h3 class="game-summary-title"><?php echo date_format(date_create($game->getDate()),"H:i")?></h3>
                                    <?php
                                        for($i = 0; $i < $numAthletes[$game->getIdGame()]; $i++){
                                            echo "<img src='/css/img/goldBall.png'/>";
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