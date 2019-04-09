<?php
//file: view/championships/enroll.php
require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$championshipId = $view->getVariable("championshipid");
$categories = $view->getVariable("categories");
$categoriesNames = $view->getVariable("categoriesNames");
$errors = $view->getVariable("errors");

$view->setVariable("title", "Enroll in a Category");

?>

<div class="formulario">

    <h1><?= i18n("Enroll into a Category of a Championship")?></h1>

    <form action="index.php?controller=championships&amp;action=enroll" method="POST">

        <p>Category:</p>
        
        <select name="categoryId" >

            <?php foreach ($categories as $category): ?>

                <option value="<?php echo $category->getCategoryId() ?>"><?php echo $categoriesNames[$category->getCategoryId()] ?></option>

            <?php endforeach; ?>
        
        </select>
        <?= isset($errors["categoryId"])?i18n($errors["categoryId"]):"" ?><br>

        <input type="text" name="captain" placeholder="<?= i18n("Captain") ?>">
        <?= isset($errors["captain"])?i18n($errors["captain"]):"" ?><br>

        <input type="text" name="pair" placeholder="<?= i18n("Pair") ?>">
        <?= isset($errors["pair"])?i18n($errors["pair"]):"" ?><br>

        <input type="hidden" name="championshipId" value="<?= $championshipId ?>">

        <div>
            <input class="form-btn" type="submit" name="submit" value="Enroll">
			<a class="submit-btn fas fa-hand-point-left" href="index.php?controller=championships&amp;action=index&amp;championshipId=<?= $championshipId ?>"></a>
		</div>

    </form>

</div>

