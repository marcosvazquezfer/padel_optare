<?php
//file: view/main/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
?>
<div id="main-container">
    <div class="main-elem first"></div>
    <h1><?= i18n("Check our free courts and organize a game with your friends, or just come and enjoy") ?></h1>
    <div class="main-elem second"></div>
    <h1><?= i18n("Check our available championships and access to see results and rankings, and if you want... SUBSCRIBE!") ?></h1>
    <div class="main-elem third"></div>
</div>
