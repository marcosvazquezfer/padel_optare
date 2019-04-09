<?php
//file: view/championship/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$matches = $view->getVariable("matches");
$couples = $view->getVariable("couples");
$couplePoints = $view->getVariable("couplePoints");
$captainNames = $view->getVariable("captainNames");
$pairNames = $view->getVariable("pairNames");
$currentuser = $view->getVariable("currentusername");
$role = $view->getVariable("role");

$view->setVariable("title", "match");

?>
<h1><?=i18n("Ranking")?></h1>

<table class="tbase">

	<thead>

		<tr>

			<th><?= i18n("Position")?></th>
			<th><?= i18n("Couple")?></th>
			<th><?= i18n("Points")?></th>
			
		</tr>

	</thead>

	<tbody>

		<?php $cont = 1; foreach ($couplePoints as $coupleId=>$points): ?>

			<tr>
				<td>
					<?php echo $cont."º"; $cont++ ?>
				</td>

				<td>
					<?= htmlentities($captainNames[$coupleId]."-".$pairNames[$coupleId]) ?>
				</td>

				<td>
					<?= htmlentities($points) ?>
				</td>

			</tr>

		<?php endforeach; ?>

	</tbody>

</table>


<h1><?=i18n("Matches")?></h1>

<table class="tbase">

	<thead>

		<tr>

			<th><?= i18n("Couple1 vs Couple2")?></th>
			<th><?= i18n("Court")?></th>
			<th><?= i18n("Result")?></th>

			<?php if ($role == 'Administrator'): ?>

				<th><?= i18n("Actions")?></th>

			<?php endif; ?>
			
		</tr>

	</thead>

	<tbody>

		<?php foreach ($matches as $match): ?>

			<tr>
				<td>
					<?= htmlentities($captainNames[$match->getCoupleId1()]."-".$pairNames[$match->getCoupleId1()]) ?> vs <?= htmlentities($captainNames[$match->getCoupleId2()]."-".$pairNames[$match->getCoupleId2()]) ?>
				</td>

				<td>
					<?= htmlentities($match->getCourtId()) ?>
				</td>

				<td>
					<?= htmlentities($match->getResult()) ?>
				</td>

				<?php if ($role == 'Administrator'): ?>

					<td>

						<a href="index.php?controller=matches&amp;action=add&amp;groupId=<?php echo $match->getGroupId() ?>&amp;coupleId1=<?php echo $match->getCoupleId1() ?>&amp;coupleId2=<?php echo $match->getCoupleId2() ?>">
							<button onclick="myFunction()" class="dropbtn fas fa-plus"></button>
						</a>
						<a href="index.php?controller=matches&amp;action=edit&amp;groupId=<?php echo $match->getGroupId() ?>&amp;coupleId1=<?php echo $match->getCoupleId1() ?>&amp;coupleId2=<?php echo $match->getCoupleId2() ?>&amp;result=<?php echo $match->getResult() ?>&amp;winner=<?php echo $match->getWinner() ?>">
							<button onclick="myFunction()" class="dropbtn fas fa-edit"></button>
						</a>


						&nbsp;

					</td>
					
				<?php endif; ?>

			</tr>

			<?php endforeach; ?>

	</tbody>

</table>
