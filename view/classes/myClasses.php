<?php
    $view = ViewManager::getInstance();
    $classes = $view->getVariable("classes");
    $monthlyClassesCalendar = $view->getVariable("monthlyClassesCalendar");
    $role = $view->getVariable("role");
?> 

<div class="class-summary-container">
    <div class="class-summary-header">
        <h1><?= i18n("Personal Classes") ?></h1>
        <?php
        if(in_array("Trainer", $role)){?>
            <a href="index.php?controller=classes&amp;action=addParticular"><i class="fas fa-plus-square fa-2x"></i></a>
        <?php
        }?>      
    </div>
    <ul>
        <?php
            foreach ($classes as $class) {
                if (!array_key_exists($class->getClassId(), $monthlyClassesCalendar)) {
                list($date, $beginTime) = split(' ', $class->getDate());
                $endHour = new DateTime($class->getDate());
                $endHour = $endHour->add(new DateInterval("PT1H30M"));
                list($date, $endTime) = split(' ', $endHour->format('Y-m-d H:i:s')); 
                ?>
                    <li>
                        <div class="class-summary">
                            <div>
                                <a class="delete-button" href="<?php echo "index.php?controller=classes&amp;action=unsubscribe&classId=" . $class->getClassId() . "&type=P" ?>">  
                                    <h3 class="class-summary-title"><?php echo i18n("Class ") . $class->getClassId()?></h3>
                                    <h3 class="class-summary-title"><?php echo i18n("On ") . $date ?></h3>
                                    <h3 class="class-summary-title"><?php echo i18n("From ") . $beginTime . i18n(" to ") . $endTime ?></h3>
                                </a>
                                <?php
                                    if(in_array("Trainer", $role)){?> 
                                    <div class="button-container">
                                        <a href="<?php echo "index.php?controller=classes&action=showAsistance&classId=" . $class->getClassId() ."&fecha=" . $class->getDate() ?>">Controlar asistencia</a>
                                    </div>
                                <?php
                                    }?>
                            </div>
                            <?php
                            if(in_array("Trainer", $role)){?>
                                <div class="button-container">
                                <a href="<?php echo "index.php?controller=classes&amp;action=sendNotification&classId=" . $class->getClassId() ?>"><i class="fas fa-comment"></i></a>   
                                    <a class="delete-button" href="<?php echo "index.php?controller=classes&amp;action=delete&classId=" . $class->getClassId() ?>"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </div>    
                        </li>
                    <?php
                    }
                }
            }
        ?>
    </ul>
    <div class="class-summary-header">
        <h1><?= i18n("Monthly Classes") ?></h1>
        <?php
        if($role == 'Administrator'){?>
            <a href="index.php?controller=classes&amp;action=addMonthly"><i class="fas fa-plus-square fa-2x"></i></a>
        <?php
        }?>  
    </div>
    <ul>
        <?php
            foreach ($classes as $class) {
                if (array_key_exists($class->getClassId(), $monthlyClassesCalendar)) {
                    foreach ($monthlyClassesCalendar[$class->getClassId()] as $classDate) {
                        list($date, $beginTime) = split(' ', $classDate[0]);
                        list($date, $endTime) = split(' ', $classDate[1]); 
                        list($year, $month, $day) = split('-', $date); 
                        $dateObj   = DateTime::createFromFormat('!m', $month);
                        $monthName = $dateObj->format('F');
                        $dateObj   = DateTime::createFromFormat('!d', $month);
                        $dayName = $dateObj->format('l');
                        ?>
                            <li>
                                <div class="class-summary">
                                    <div>
                                        <a class="delete-button" href="<?php echo "index.php?controller=classes&amp;action=unsubscribe&classId=" . $class->getClassId() . "&type=M" ?>">  
                                            <h3 class="class-summary-title"><?php echo i18n("Class ") . $class->getClassId()?></h3>
                                            <h3 class="class-summary-title"><?php echo i18n("On ") . i18n("$monthName") . i18n(" every ") . i18n("$dayName") ?></h3>
                                            <h3 class="class-summary-title"><?php echo i18n("From ") . $beginTime . i18n(" to ") . $endTime ?></h3>
                                        </a>

                                        <?php
                                        if(in_array("Trainer", $role)){?> 
                                        <div class="button-container">
                                            <a href="<?php echo "index.php?controller=classes&action=showAsistance&classId=" . $class->getClassId() ."&fecha=" . $class->getDate() ?>">Controlar asistencia</a>
                                        </div>
                                    <?php
                                        }?>
                                    </div>
                                    <?php
                            if(in_array("Trainer", $role)){?>
                                <div class="button-container">
                                <a href="<?php echo "index.php?controller=classes&amp;action=sendNotification&classId=" . $class->getClassId() ?>"><i class="fas fa-comment"></i></a>   
                                    <a class="delete-button" href="<?php echo "index.php?controller=classes&amp;action=delete&classId=" . $class->getClassId() ?>"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </div>    
                        </li>
                    <?php
                }?>                       
                                </div>
                            </li>
                        <?php
                    }
                }
            }
        ?>
    </ul>
</div>