<?php
//file: controller/CourtsController.php

require_once(__DIR__."/../model/Court.php");
require_once(__DIR__."/../model/CourtMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");


require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
* Class CourtsController
*
* Controller to make a CRUDL of Courts entities
*
*/
class CourtsController extends BaseController {

	/**
	* Reference to the MatchMapper to interact
	* with the database
	*
	* @var CourtMapper
	*/
	private $courtMapper;
	private $userMapper;

	public function __construct() {

		parent::__construct();

		$this->courtMapper = new CourtMapper();
		$this->userMapper = new UserMapper();
	}

	/**
	* Action to list all Courts of the Club
	*
	*/
	public function index() {

		if (!isset($this->currentUser)){
			$this->view->setVariable("error", i18n("Not in session. View courts requires login"));
		}

        // obtain the data from the database
		$courts = $this->courtMapper->findAll();

		// put the array containing Post object to the view
		$this->view->setVariable("courts", $courts);

		// render the view (/view/posts/index.php)
		$this->view->render("courts", "index");
	}

	/**
	* Action to view a given court
	*
	*/
	public function view(){

		if (!isset($this->currentUser)) {
			$this->view->setVariable("error", i18n("Not in session. View courts requires login"));
			// obtain the data from the database
			$courts = $this->courtMapper->findAll();

			// put the array containing Post object to the view
			$this->view->setVariable("courts", $courts);
			$this->view->render("courts", "index");
		} 
		else {

			if (!isset($_GET["courtId"])) {

				throw new Exception("courtId is mandatory");
			}
	
			$courtId = $_GET["courtId"];

			date_default_timezone_set("Europe/Madrid");
			$date = date_format(date_create(),"Y/m/d");
			$time = date_format(date_create(),"H:i:s");
			$dateTime = $date.' '.$time;
			$occupations = $this->courtMapper->findOccupation($dateTime, $courtId);

			$court = $this->courtMapper->findById($courtId);
			$hour = $court->getTimeStart();
			$hours = array();
			
			while($hour < $court->getTimeEnd()){

				array_push($hours, $hour);
				$dateTime2 = $date.' '.$hour;
				$newDateTime = new DateTime($dateTime2);
				$nextDateTime = $newDateTime->add(new DateInterval("PT1H30M"));
				$hour = $nextDateTime->format('H:i:s');
			}
			
			$dateI = date_format(date_create($date),"d-m-Y");
			foreach($occupations as $occupation){

				$timeStart = $occupation->getStartDate();
				$timeO = substr($timeStart,0,10);
				$timeO = date_format(date_create($timeO),"d-m-Y");
				$hourO = substr($timeStart,11);

				if($dateI == $timeO){
					foreach($hours as $hour){
						if($hourO == $hour){				
							$busyHours[$dateI.' '.$hourO] = $occupation->getReserveType();
						}
					}
				}
			}
			
			for($i = 1; $i < 7; $i++){
				$schedule = $dateI. ' ' .$time;
				$startDateTime = new DateTime($schedule);
				$nextDateTime = $startDateTime->add(new DateInterval("P".$i."D"));
				$dateF = $nextDateTime->format('d-m-Y');

				foreach($occupations as $occupation){

					$timeStart = $occupation->getStartDate();
					$timeO = substr($timeStart,0,10);
					$timeO = date_format(date_create($timeO),"d-m-Y");
					$hourO = substr($timeStart,11);

					if($dateF == $timeO){
						foreach($hours as $hour){			
							if($hourO == $hour){
								$busyHours[$dateF.' '.$hourO] = $occupation->getReserveType();
							}
						}
					}
				}
			}

			$this->view->setVariable("courtId", $courtId);
			$this->view->setVariable("date", $date);
			$this->view->setVariable("time", $time);
			$this->view->setVariable("occupations", $occupations);
			$this->view->setVariable("hours", $hours);
			$this->view->setVariable("busyHours", $busyHours);
	
			// render the view (/view/courts/view.php)
			$this->view->render("courts", "view");
		}
	}

	/**
	* Action to add a new court
	*
	*/
	public function add() {

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Adding courts requires login");
		}

		if($this->userMapper->isAdmin()){

			if (isset($_POST["submit"])) { // reaching via HTTP Post...

				$courtType = $_POST["courtType"];
				$timeStart = $_POST["timeStart"];
				$timeEnd = $_POST["timeEnd"];
	
				try {
					// save the Court object into the database
					$this->courtMapper->add($courtType, $timeStart, $timeEnd);
	
					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Court \"%s\" successfully added.")));
	
					// perform the redirection. More or less:
					// header("Location: index.php?controller=posts&action=index")
					// die();
					$this->view->redirect("courts", "index");
	
				}
				catch(ValidationException $ex) {
	
					// Get the errors array inside the exepction...
					$errors = $ex->getErrors();
					// And put it to the view as "errors" variable
					$this->view->setVariable("errors", $errors);
				}
			}
	
			// render the view (/view/courts/add.php)
			$this->view->render("courts", "add");
		}
		else{
			$errors["addingCourt"] = i18n("You are not an Administrator. You can not add a new court");
            $this->view->setVariable("errors", $errors);
            $this->index();
		}	
	}
	
	/**
	* Action to delete a court
	*
	*/
	public function delete() {

		if (!isset($this->currentUser)) {
			throw new Exception("Not in session. Deleting courts requires login");
		}

		if (!isset($_POST["courtId"])) {
			throw new Exception("courtId is mandatory");
		}

		if($this->userMapper->isAdmin()){
		
			$courtId = $_REQUEST["courtId"];

			// Delete the Post object from the database
			$this->courtMapper->delete($courtId);

			// POST-REDIRECT-GET
			// Everything OK, we will redirect the user to the list of posts
			// We want to see a message after redirection, so we establish
			// a "flash" message (which is simply a Session variable) to be
			// get in the view after redirection.
			$this->view->setFlash(sprintf(i18n("Court \"%s\" successfully deleted."),$courtId));

			// perform the redirection. More or less:
			// header("Location: index.php?controller=posts&action=index")
			// die();
			$this->view->redirect("courts", "index");
		}
		else{
			$errors["deletingCourt"] = i18n("You are not an Administrator. You can not delete a court");
            $this->view->setVariable("errors", $errors);
            $this->index();
		}
	}
}
