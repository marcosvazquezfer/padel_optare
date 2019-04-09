<?php
    $view = ViewManager::getInstance();
    $championship = $view->getVariable("championship");
    $categories = $view->getVariable("categories");
    $categoriesGroups = $view->getVariable("categoriesGroups");
?> 

<div class="game-summary-container">
    <h1><?= $championship->getName() ?></h1>
    <ul>
        <?php
            foreach ($categories as $category) {
                ?>
                    
                <?php 
                    foreach($categoriesGroups[$category->getLevel().$category->getGender()] as $group){
                ?>

                    <li>

                        <div class="game-summary">

                            <form action="index.php?controller=matches&amp;action=index" method="POST">

                                <input type="hidden" name="groupId" value="<?php echo $group?>"/>

                                <a href="#" onclick="this.parentNode.submit()">

                                    <h2 class="game-summary-title">
                                        <?php echo i18n("Category")." ".$category->getLevel().$category->getGender()?>
                                    </h2>
                                    <h3 class="game-summary-title">
                                        
                                        <?php echo i18n("Group")." ".$group;?>
                                    </h3>

                                </a>

                            </form>

                        </div>

                    </li>
                
                <?php } ?>

            <?php
            }
        ?>
    </ul>
</div>