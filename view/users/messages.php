<?php
    $view = ViewManager::getInstance();
    $notifications = $view->getVariable("notifications");
?> 

<div>
    <div>
        <h1><?= i18n("Messages") ?></h1>
    </div>
    <ul>
        <?php
            foreach ($notifications as $notification) {
                $datetime = new DateTime($notification->getDate());
                $date = $datetime->format('d-m-Y'); 
                $time = $datetime->format('H:i'); 
                ?>
                <div class="notification-container">
                    <h3><?php echo $notification->getMessage()?></h3>
                    <p><?php echo "At " . $time ." on " . $date?></p>
                </div>
                <?php
            }
        ?>
    </ul>
</div>