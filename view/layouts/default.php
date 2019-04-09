<?php
//file: view/layouts/default.php

$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
if($errors != NULL) {
    $errors = $view->getVariable("errors");
} else {
    $errors = [];
}
$messages = $view->getVariable("messages");
if($messages != NULL) {
    $messages = $view->getVariable("messages");
} else {
    $messages = [];
}

?><!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="cache-control" content="no-cache">
    <title>Padel-Optare</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
     <header>	
        <div class="title-row">
            <a href="index.php"><h1>Padel Optare</h1></a>
            <div class="header-user-container">
                <?php if(isset($_SESSION['currentuser'])) { ?>
                    <p><?php echo $_SESSION['currentusername']?></p>
                    <div class="dropdown">
                        <button onclick="myFunction()" class="dropbtn fas fa-user-alt">
                        </button>
                        <div id="userDropdown" class="dropdown-content">
                            <a href="index.php?controller=users&amp;action=logout"><?=i18n("Log Out")?></a>
                            <a href="index.php?controller=users&amp;action=messages"><?=i18n("Messages")?></a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="dropdown">
                        <button onclick="myFunction()" class="dropbtn fas fa-user-alt">
                        </button>
                        <div id="userDropdown" class="dropdown-content">
                            <a href="index.php?controller=users&amp;action=login"><?=i18n("Log In")?></a>
                            <a href="index.php?controller=users&amp;action=register"><?=i18n("Register")?></a>
                        </div>
                    </div>
                <?php } ?>
                
                <div class="dropdown">
                    <button id="world" onclick="myFunction()" class="dropbtn fas fa-globe-americas">
                    </button>
                    <div id="userDropdown" class="dropdown-content">
                        <?php include(__DIR__."/language_select_element.php"); ?>
                    </div>
                </div>

            </div>
        </div>
        <nav class="nav-bar">
            <a class="wh" href="index.php?controller=games&amp;action=index"><?=i18n("Games")?></a>
            <a class="wh" href="index.php?controller=bookings&amp;action=index"><?=i18n("My Bookings")?></a>
            <div class="dropdown">
                <span id="ch"><?=i18n("Championships")?></span>
                <div class="dropdown-content">
                    <a href="index.php?controller=championships&amp;action=index"><?=i18n("Offered Championships")?></a>
                    <a href="index.php?controller=championships&amp;action=myChampionships"><?=i18n("My Championships")?></a>
                </div>
            </div>
            <a href="index.php?controller=courts&amp;action=index"><?=i18n("Courts")?></a>
            <div class="dropdown">
                <span><?=i18n("Classes")?></span>
                <div class="dropdown-content">
                    <a href="index.php?controller=classes&amp;action=index"><?=i18n("Offered Classes")?></a>
                    <a href="index.php?controller=classes&amp;action=myClasses"><?=i18n("My Classes")?></a>
                </div>
            </div>
        </nav>
     </header>
    <!--REGISTER FORM -->
    <main class="text-center">
        <?php 
        foreach($errors as $error) {
            echo '<div class="error-container"><i class="fas fa-exclamation-circle"></i><p class="error">' . $error . '</p></div>';
        }
        foreach($messages as $message) {
            echo '<div class="message-container"><i class="fas fa-check-circle"></i></i><p class="message">' . $message . '</p></div>';
        }
        ?>
        <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
    </main>
    <!-- Footer -->
    <footer id="footer">
        <div class="footer-container">
            <ul class="quick-links">
                <li><a class="wh" href="#"><?=i18n("Home")?></a></li>
                <li><a class="wh" href="#"><?=i18n("About")?></a></li>
                <li><a class="wh" href="#"><?=i18n("More")?></a></li>
            </ul>
            <ul class="social">
                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
        </div>
    </footer>
    <script src="../js/dropdown.js"></script>
</body>
</html>
