<?php
//file: controller/MatchesController.php

require_once(__DIR__."/../model/Couple.php");
require_once(__DIR__."/../model/CoupleMapper.php");
require_once(__DIR__."/../model/Match.php");
require_once(__DIR__."/../model/MatchMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
* Class MatchesController
*
* Controller to make a CRUDL of Matches entities from a Group of a Championship
*
* @author Marcos Vázquez Fernández
*/
class MatchesController extends BaseController {

	/**
	* Reference to the MatchMapper to interact
	* with the database
	*
	* @var MatchMapper
	*/
	private $matchMapper;

	/**
	* Reference to the CoupleMapper to interact
	* with the database
	*
	* @var CoupleMapper
	*/
	private $coupleMapper;

	private $userMapper;

	public function __construct() {

		parent::__construct();

		$this->matchMapper = new MatchMapper();
		$this->coupleMapper = new CoupleMapper();
		$this->userMapper = new UserMapper();
	}

	/**
	* Action to list results
	*
	* Loads all the results of a guven group from the database.
	*
	* The views are:
	* <ul>
	* <li>results/index (via include)</li>
	* </ul>
	*/
	public function index() {

        if (!isset($_REQUEST["groupId"])) {

			throw new Exception("groupId is mandatory");
        }
        
		$groupId = $_REQUEST["groupId"];

		//$this->generateFinalPhase($groupId);

		// obtain the data from the database
		$round = 'G';
		$matches = $this->matchMapper->findByGroupIdRound($groupId, $round);

		$cont = 0;

		foreach($matches as $match){

			if($match->getResult() == null){

				$cont = 1;
				break;
			}
		}

		if($cont == 1){

			$couples = $this->coupleMapper->findAllByGroupId($groupId);

			foreach($couples as $couple){

				$coupleDnis = $this->coupleMapper->findDnisById($couple);

				$captainNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getCaptain()->getDni());
				$pairNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getPair()->getDni());
				

				$winMatches = $this->coupleMapper->findWin($groupId, $couple);

				$win = count($winMatches);

				$lostMatches = $this->coupleMapper->findLost($groupId, $couple);

				$lost = count($lostMatches);

				$couplePoints[$couple] = ($win * 3) + $lost;
			}

			arsort($couplePoints);
			
			if ($this->userMapper->isAdmin()) $this->view->setVariable("role", "Administrator");

			$this->view->setVariable("matches", $matches);
			$this->view->setVariable("couples", $couples);
			$this->view->setVariable("couplePoints", $couplePoints);
			$this->view->setVariable("captainNames", $captainNames);
			$this->view->setVariable("pairNames", $pairNames);
			if ($this->userMapper->isAdmin()) $this->view->setVariable("role", "Administrator");

			$this->view->render("matches", "index");
		}
		else{
			if($cont == 0){

				$round = 'C';
				$matches = $this->matchMapper->findByGroupIdRound($groupId, $round);
				$cont = 0;

				if($matches == null){

					$this->generateFinalPhase($groupId);
				}
				else{
					foreach($matches as $match){

						if($match->getResult() == null){

							$cont = 1;
							break;
						}
					}

					if($cont == 1){

						$round = 'G';

						$couples = $this->coupleMapper->findAllByGroupIdRound($groupId, $round);
						$matches = $this->matchMapper->findByGroupIdRoundDist($groupId, 'G');

						foreach($couples as $couple){

							$coupleDnis = $this->coupleMapper->findDnisById($couple);

							$captainNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getCaptain()->getDni());
							$pairNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getPair()->getDni());
							

							$winMatches = $this->coupleMapper->findWin($groupId, $couple);

							$win = count($winMatches);

							$lostMatches = $this->coupleMapper->findLost($groupId, $couple);

							$lost = count($lostMatches);

							$couplePoints[$couple] = ($win * 3) + $lost;
						}

						arsort($couplePoints);
						
						if ($this->userMapper->isAdmin()) $this->view->setVariable("role", "Administrator");

						$this->view->setVariable("matches", $matches);
						$this->view->setVariable("captainNames", $captainNames);
						$this->view->setVariable("pairNames", $pairNames);

						$this->view->render("matches", "finalPhase");
					}
					else{
						if($cont == 0){

							$round = 'S';
							$matches = $this->matchMapper->findByGroupIdRound($groupId, $round);
							$cont = 0;

							if($matches == null){

								$this->generateNextRound($groupId, $round);
							}
							else{
								foreach($matches as $match){

									if($match->getResult() == null){
			
										$cont = 1;
										break;
									}
								}

								if($cont == 1){

									$round = 'G';

									$couples = $this->coupleMapper->findAllByGroupIdRound($groupId, $round);
									$matches = $this->matchMapper->findByGroupIdRoundDist($groupId, 'G');

									foreach($couples as $couple){

										$coupleDnis = $this->coupleMapper->findDnisById($couple);

										$captainNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getCaptain()->getDni());
										$pairNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getPair()->getDni());
										

										$winMatches = $this->coupleMapper->findWin($groupId, $couple);

										$win = count($winMatches);

										$lostMatches = $this->coupleMapper->findLost($groupId, $couple);

										$lost = count($lostMatches);

										$couplePoints[$couple] = ($win * 3) + $lost;
									}

									arsort($couplePoints);

									if ($this->userMapper->isAdmin()) $this->view->setVariable("role", "Administrator");

									$this->view->setVariable("matches", $matches);
									$this->view->setVariable("captainNames", $captainNames);
									$this->view->setVariable("pairNames", $pairNames);

									$this->view->render("matches", "finalPhase");
								}
								else{
									if($cont == 0){

										$round = 'F';
										$matches = $this->matchMapper->findByGroupIdRound($groupId, $round);
										$cont = 0;

										if($matches == null){

											$this->generateNextRound($groupId, $round);
										}
										else{
											foreach($matches as $match){

												if($match->getResult() == null){
						
													$cont = 1;
													break;
												}
											}

											if($cont == 1){

												$round = 'G';

												$couples = $this->coupleMapper->findAllByGroupIdRound($groupId, $round);
												$matches = $this->matchMapper->findByGroupIdRoundDist($groupId, 'G');

												foreach($couples as $couple){

													$coupleDnis = $this->coupleMapper->findDnisById($couple);

													$captainNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getCaptain()->getDni());
													$pairNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getPair()->getDni());
												}

												if ($this->userMapper->isAdmin()) $this->view->setVariable("role", "Administrator");

												$this->view->setVariable("matches", $matches);
												$this->view->setVariable("captainNames", $captainNames);
												$this->view->setVariable("pairNames", $pairNames);

												$this->view->render("matches", "finalPhase");
											}
											else{
												$round = 'G';
												
												$couples = $this->coupleMapper->findAllByGroupIdRound($groupId, $round);
												$matches = $this->matchMapper->findByGroupIdRoundDist($groupId, 'G');
												
												foreach($couples as $couple){

													$coupleDnis = $this->coupleMapper->findDnisById($couple);

													$captainNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getCaptain()->getDni());
													$pairNames[$couple] = $this->coupleMapper->findNameByDni($coupleDnis->getPair()->getDni());
													

													$winMatches = $this->coupleMapper->findWin($groupId, $couple);

													$win = count($winMatches);

													$lostMatches = $this->coupleMapper->findLost($groupId, $couple);

													$lost = count($lostMatches);

													$couplePoints[$couple] = ($win * 3) + $lost;
												}

												arsort($couplePoints);

												if ($this->userMapper->isAdmin()) $this->view->setVariable("role", "Administrator");

												$this->view->setVariable("matches", $matches);
												$this->view->setVariable("captainNames", $captainNames);
												$this->view->setVariable("pairNames", $pairNames);

												$this->view->render("matches", "finalPhase");
											}
										}
									}
								}
							}
						}
					}
				}
			}
			
		}
		

		//echo var_dump($couplePoints); die;

		// render the view (/view/results/index.php)
		
	}

	/**
	* Action to add a new result of a group
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the result to the
	* database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>groupId: Group of the match (via HTTP GET)</li>
	* <li>coupleId1: Id of the couple 1 (via HTTP POST)</li>
	* <li>coupleId2: Id of the couple 2 (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>results/add: If this action is reached via HTTP GET (via include)</li>
	* <li>results/index: If result was successfully added (via redirect)</li>
	* <li>results/add: If validation fails (via include). Includes these view variables:</li>
	* </ul>
	* @throws Exception if no user is in session
	* @return void
	*/
	public function add() {

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Adding results requires login");
		}

		if (!isset($_REQUEST["groupId"])) {

			throw new Exception("groupId is mandatory");
		}

		if (!isset($_REQUEST["coupleId1"])) {

			throw new Exception("coupleId1 is mandatory");
		}

		if (!isset($_REQUEST["coupleId2"])) {

			throw new Exception("coupleId2 is mandatory");
		}

		$groupId = $_REQUEST["groupId"];
		$coupleId1 = $_REQUEST["coupleId1"];
		$coupleId2 = $_REQUEST["coupleId2"];

		$dnisCouple1 = $this->coupleMapper->findDnisById($coupleId1);
		$nameCaptain1 = $this->coupleMapper->findNameByDni($dnisCouple1->getCaptain()->getDni());
		$namePair1 = $this->coupleMapper->findNameByDni($dnisCouple1->getPair()->getDni());

		$dnisCouple2 = $this->coupleMapper->findDnisById($coupleId2);
		$nameCaptain2 = $this->coupleMapper->findNameByDni($dnisCouple2->getCaptain()->getDni());
		$namePair2 = $this->coupleMapper->findNameByDni($dnisCouple2->getPair()->getDni());

		$couples[$coupleId1] = $nameCaptain1."-".$namePair1;
		$couples[$coupleId2] = $nameCaptain2."-".$namePair2;

		if (isset($_POST["submit"])) { // reaching via HTTP Post...

			$groupId = $_POST["groupId"];
			$coupleId1 = $_POST["coupleId1"];
			$coupleId2 = $_POST["coupleId2"];
			$result = $_POST["result"];
			$winner = $_POST["winner"];

			try {

				// save the Match object into the database
				$this->matchMapper->updateResult($groupId, $coupleId1, $coupleId2, $result, $winner);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Result \"%s\" successfully added.")));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("matches", "index", "groupId=".$groupId);

			}
			catch(ValidationException $ex) {

				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		$this->view->setVariable("groupId", $groupId);
		$this->view->setVariable("coupleId1", $coupleId1);
		$this->view->setVariable("coupleId2", $coupleId2);
		$this->view->setVariable("couples", $couples);

		// render the view (/view/posts/add.php)
		$this->view->render("matches", "add");

	}

	/**
	* Action to edit a result
	*
	* When called via GET, it shows an edit form
	* including the current data of the Match.
	* When called via POST, it modifies the result in the
	* database.
	*
	* @return void
	*/
	public function edit() {

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Editing championships requires login");
		}

		if (!isset($_REQUEST["groupId"])) {

			throw new Exception("A groupIdis mandatory");
		}

		if (!isset($_REQUEST["coupleId1"])) {

			throw new Exception("A coupleId1 is mandatory");
		}

		if (!isset($_REQUEST["coupleId2"])) {

			throw new Exception("A couleId2 is mandatory");
		}

		$groupId = $_REQUEST["groupId"];
		$coupleId1 = $_REQUEST["coupleId1"];
		$coupleId2 = $_REQUEST["coupleId2"];
		$result = $_REQUEST["result"];
		$winner = $_REQUEST["winner"];

		$dnisCouple1 = $this->coupleMapper->findDnisById($coupleId1);
		$nameCaptain1 = $this->coupleMapper->findNameByDni($dnisCouple1->getCaptain()->getDni());
		$namePair1 = $this->coupleMapper->findNameByDni($dnisCouple1->getPair()->getDni());

		$dnisCouple2 = $this->coupleMapper->findDnisById($coupleId2);
		$nameCaptain2 = $this->coupleMapper->findNameByDni($dnisCouple2->getCaptain()->getDni());
		$namePair2 = $this->coupleMapper->findNameByDni($dnisCouple2->getPair()->getDni());

		$couples[$coupleId1] = $nameCaptain1."-".$namePair1;
		$couples[$coupleId2] = $nameCaptain2."-".$namePair2;

		if (isset($_POST["submit"])) { // reaching via HTTP Post...

			$result = $_POST["result"];
			$winner = $_POST["winner"];

			try {

				$this->matchMapper->updateResult($groupId, $coupleId1, $coupleId2, $result, $winner);

				// POST-REDIRECT-GET
				// Everything OK, we will redirect the user to the list of posts
				// We want to see a message after redirection, so we establish
				// a "flash" message (which is simply a Session variable) to be
				// get in the view after redirection.
				$this->view->setFlash(sprintf(i18n("Result \"%s\" successfully updated."),$result));

				// perform the redirection. More or less:
				// header("Location: index.php?controller=posts&action=index")
				// die();
				$this->view->redirect("matches", "index", "groupId=".$groupId);

			}
			catch(ValidationException $ex) {

				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}
		$this->view->setVariable("groupId", $groupId);
		$this->view->setVariable("coupleId1", $coupleId1);
		$this->view->setVariable("coupleId2", $coupleId2);
		$this->view->setVariable("result", $result);
		$this->view->setVariable("winner", $winner);
		$this->view->setVariable("couples", $couples);

		// render the view (/view/posts/add.php)
		$this->view->render("matches", "edit");
	}

	private function generateFinalPhase($group){

		$couples = $this->coupleMapper->findAllByGroupId($group);

		foreach($couples as $couple){

			$winMatches = $this->coupleMapper->findWin($group, $couple);

			$win = count($winMatches);

			$lostMatches = $this->coupleMapper->findLost($group, $couple);

			$lost = count($lostMatches);

			$couplePoints[$couple] = ($win * 3) + $lost;
		}

		arsort($couplePoints);

		$winners = array();
		$winnersPoints = array();

		foreach($couplePoints as $couple => $points){

			array_push($winners, $couple);
			array_push($winnersPoints, $points);
		}

		array_splice($winners, 8, 8);

		$winners2 = array_splice($winners, 4, 4);
		$reversed = array_reverse($winners2);

		for($i = 0; $i < 4; $i++){

			$match = new Match($matchId=NULL, $result=NULL, $coupleId1=$winners[$i], $coupleId2=$reversed[$i], $groupId=$group, $court=NULL, $dateTime=NULL, $winner=NULL, $round='C');

			$this->matchMapper->save($match);
		}

		$this->index();
	}

	private function generateNextRound($group, $round){

		if($round == 'S'){

			$previousRound = 'C';

			$matches = $this->matchMapper->findByGroupIdRound($group, $previousRound);

			$winners = array();

			foreach($matches as $match){

				array_push($winners, $match->getWinner());
			}

			$winners2 = array_splice($winners, 2, 2);

			for($i = 0; $i < 2; $i++){

				$match = new Match($matchId=NULL, $result=NULL, $coupleId1=$winners[$i], $coupleId2=$winners2[$i], $groupId=$group, $court=NULL, $dateTime=NULL, $winner=NULL, $round=$round);

				$this->matchMapper->save($match);
			}
		}
		else{
			if($round == 'F'){

				$previousRound = 'S';

				$matches = $this->matchMapper->findByGroupIdRound($group, $previousRound);

				$winners = array();

				foreach($matches as $match){

					array_push($winners, $match->getWinner());
				}

				$winners2 = array_splice($winners, 1, 1);

				for($i = 0; $i < 1; $i++){

					$match = new Match($matchId=NULL, $result=NULL, $coupleId1=$winners[$i], $coupleId2=$winners2[$i], $groupId=$group, $court=NULL, $dateTime=NULL, $winner=NULL, $round=$round);

					$this->matchMapper->save($match);
				}
			}
		}

		$this->index();
	}
}
