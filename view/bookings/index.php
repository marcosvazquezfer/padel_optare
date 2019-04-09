<?php
    $view = ViewManager::getInstance();
    $bookings = $view->getVariable("bookings");
?> 

<div class="booking-summary-container">
    <div class="booking-summary-header">
        <h1><?= i18n("My Bookings") ?></h1>
        <a href="index.php?controller=bookings&amp;action=book"><i class="fas fa-plus-square fa-2x"></i></a> 
    </div>
    <ul>
        <?php
            foreach ($bookings as $booking) {
                ?>
                    <li>
                        <div class="booking-summary">
                            <form action="index.php?controller=bookings&amp;action=delete" method="POST">
                                <input type="hidden" name="idCourt" value="<?php echo $booking->getIdCourt()?>"/>
                                <input type="hidden" name="startDate" value="<?php echo $booking->getStartDate()?>"/>
                                <a href="#" onclick="this.parentNode.submit()">
                                    <h2 class="booking-summary-title"><?php echo date_format(date_create($booking->getEndDate()),"d/m/Y")?></h2>
                                    <h3 class="booking-summary-title"><?php echo date_format(date_create($booking->getStartDate()),"H:i")
                                                                        . " to " . date_format(date_create($booking->getEndDate()),"H:i")?></h3>
                                    <h3 class="booking-summary-title"><?php echo 'Court ' . $booking->getIdCourt()?></h3>
                                </a>
                            </form>
                            <div class='hidden-icon'>
                                <i class="fas fa-trash-alt" ></i>
                            </div>
                        </div>
                    </li>
                <?php
            }
        ?>
    </ul>
</div>