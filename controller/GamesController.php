<?php
//file: controller/GamesController.php

require_once(__DIR__."/../model/Game.php");
require_once(__DIR__."/../model/GameMapper.php");
require_once(__DIR__."/../model/Calendar.php");
require_once(__DIR__."/../model/CalendarMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
* Class GamesController
*
* Controller to make a CRUDL of Game entities
*
* @author Roi Pérez López
* @author Diego Pérez Solla
*/
class GamesController extends BaseController {

	/**
	* Reference to the GameMapper to interact
	* with the database
	*
	* @var GameMapper
	*/
	private $gameMapper;
	private $calendarMapper;
	private $userMapper;
	private $errors;
	private $messages;

	public function __construct() {

		parent::__construct();
		$this->gameMapper = new GameMapper();
		$this->calendarMapper = new CalendarMapper();
		$this->userMapper = new UserMapper();
		$this->errors = array();
		$this->messages = array();
	}

	/**
	* Action to list games
	*
	* Loads all the games from the database.
	*/
	public function index() {
		if (!isset($_SESSION["currentuser"]) ) {
			$errors["logging"] = i18n("Not in session. View games requires login");
			$this->view->setVariable("errors", $errors);
			$this->view->render("main", "index");
		} else {
			// obtain the data from the database
			$games = $this->gameMapper->getAllOpen();

			// put the array containing Game object to the view
			$this->view->setVariable("games", $games);

			$gamesInWhichIParticipate = array();
			$numAthletes = array();
			foreach ($games as $game) {
				$idGame = $game->getIdGame();
				$userId = $_SESSION['currentuser'];	
				$gamesInWhichIParticipate[$idGame] = $this->gameMapper->isAthleteInGame($idGame, $userId);
				$numAthletes[$idGame] = $this->gameMapper->countAthletes($idGame);
			}
			$this->view->setVariable("gamesInWhichIParticipate", $gamesInWhichIParticipate);
			$this->view->setVariable("numAthletes", $numAthletes);

			// render the view (/view/games/index.php)
			$this->view->render("games", "index");
		}
	}

	public function addAthlete(){
		if (!isset($_SESSION["currentuser"]) ) {
			$errors["logging"] = i18n("Not in session. Adding an athlete requires login");
			$this->view->setVariable("errors", $errors);
			$this->view->render("main", "index");
		}

		if (!isset($_REQUEST["idGame"]) ) {
			throw new Exception("Game Id is mandatory");
		}

		$idGame = $_REQUEST["idGame"];
		$userId = $_SESSION['currentuser'];	

		if(!$this->gameMapper->isAthleteInGame($idGame, $userId)) {
			if($this->gameMapper->countAthletes($idGame) == 3) {
				$game = $this->gameMapper->findById($idGame);
				$courtId = $this->calendarMapper->findOneFree($game->getDate());
				$game->setIdPista($courtId);
				$this->gameMapper->update($game);
				$startHour = new DateTime($game->getDate());
				$endHour = $startHour->add(new DateInterval("PT1H30M"));
				$calendario = new Calendar(null, $game->getDate(), $endHour->format('Y-m-d H:i:s'), $courtId, $_SESSION["currentuser"], "Partido");										
				$this->calendarMapper->save($calendario);
				$messages["closeGame"] = i18n("With you the game has all of it's participants, enjoy!");
			} 
			$this->gameMapper->addAthlete($idGame, $userId);
			$messages["addAthlete"] = i18n("You were correctly added to the game");
		} else {
			if($this->gameMapper->countAthletes($idGame) == 4) {
				$game = $this->gameMapper->findById($idGame);
				$this->calendarMapper->delete($game->getIdPista(), $game->getDate());
			} 
			$this->gameMapper->removeAthlete($idGame, $userId);
			$messages["removeAthlete"] = i18n("You were correctly removed");
		}

		$game = $this->gameMapper->findById($idGame);
		$numAthletes = $this->gameMapper->countAthletes($idGame);

		$this->view->setVariable("messages", $messages);

		if ($game == NULL) {
			throw new Exception("no such game with id: " . $idGame);
		}

		$this->index();
	}


	public function viewPromotion(){
		if (!isset($_SESSION["currentuser"]) ) {
			$errors["logging"] = i18n("Not in session. Promote games requires login");
			$this->view->setVariable("errors", $errors);
			$this->view->render("main", "index");
		} else {
			if($this->userMapper->isAdmin()){

				// render the view (/view/games/index.php)
				$this->view->render("games", "promote");
			}
			else{
				$errors["promoting"] = i18n("You are not Administrator. You can not promote games");
				$this->view->setVariable("errors", $errors);
				$this->index();
			}
		}
	}

	public function promote(){

		if($this->userMapper->isAdmin()){

			// render the view (/view/games/view.php)
			$fech = $_POST["date"].' '.$_POST["hour"];
			
			$game = new Game (null,$fech);
			$this->gameMapper->promote($game);
			$messages["promote"] = i18n("Game succesfully promoted. Date: ") . $fech;
			$this->view->setVariable("messages", $messages);
		}
		else{
			$errors["promoting"] = i18n("You are not Administrator. You can not promote games");
			$this->view->setVariable("errors", $errors);
		}
		
		
		$this->index();
	}
}
