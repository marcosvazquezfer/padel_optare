<?php
//file: controller/ChampionshipsController.php

//require_once(__DIR__."/../model/Categorias.php");
require_once(__DIR__."/../model/Administrator.php");
require_once(__DIR__."/../model/Category.php");
require_once(__DIR__."/../model/CategoryMapper.php");
require_once(__DIR__."/../model/Athlete.php");
require_once(__DIR__."/../model/AthleteMapper.php");
require_once(__DIR__."/../model/Couple.php");
require_once(__DIR__."/../model/CoupleMapper.php");
require_once(__DIR__."/../model/Championship.php");
require_once(__DIR__."/../model/ChampionshipMapper.php");
require_once(__DIR__."/../model/Match.php");
require_once(__DIR__."/../model/MatchMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
* Class ChampionshipsController
*
* Controller to make a CRUDL of Championships entities
*
* @author Marcos Vázquez Fernández
*/
class ChampionshipsController extends BaseController {

	/**
	* Reference to the ChampionshipMapper to interact
	* with the database
	*
	* @var ChampionshipMapper
	*/
	private $championshipMapper;

	/**
	* Reference to the AthleteMapper to interact
	* with the database
	*
	* @var AthleteMapper
	*/
	private $athleteMapper;

	/**
	* Reference to the CategoryMapper to interact
	* with the database
	*
	* @var CategoryMapper
	*/
	private $categoryMapper;

	/**
	* Reference to the CoupleMapper to interact
	* with the database
	*
	* @var CoupleMapper
	*/
	private $coupleMapper;

	/**
	* Reference to the CoupleMapper to interact
	* with the database
	*
	* @var MatchMapper
	*/
	private $matchMapper;

	private $userMapper;

	public function __construct() {

		parent::__construct();

		$this->championshipMapper = new ChampionshipMapper();
		$this->athleteMapper = new AthleteMapper();
		$this->categoryMapper = new CategoryMapper();
		$this->coupleMapper = new CoupleMapper();
		$this->matchMapper = new MatchMapper();
		$this->userMapper = new UserMapper();
	}

	/**
	* Action to list championships
	*
	* Loads all the championships from the database.
	* No HTTP parameters are needed.
	*
	* The views are:
	* <ul>
	* <li>championships/index (via include)</li>
	* </ul>
	*/
	public function index() {

		if (!isset($this->currentUser)) {
			$errors["logging"] = "Not in session. View championships requires login";
			$this->view->setVariable("errors", $errors);
			$this->view->render("main", "index");
		}

		// obtain the data from the database
		$championships = $this->championshipMapper->findAll();

		if ($this->userMapper->isAdmin()) $this->view->setVariable("role", "Administrator");
        else if ($this->userMapper->isTrainer()) $this->view->setVariable("role", "Trainer");

		// put the array containing Post object to the view
		$this->view->setVariable("championships", $championships);

		// render the view (/view/posts/index.php)
		$this->view->render("championships", "index");
	}

	public function myChampionships() {

		if (!isset($this->currentUser)) {
			$errors["logging"] = "Not in session. View championships requires login";
			$this->view->setVariable("errors", $errors);
			$this->view->render("main", "index");
		}

		$userId = $this->currentUser->getDni();
		$couples = $this->coupleMapper->findByUserId($userId);

		$championships = array();
		
		foreach($couples as $couple){

			$championshipsId = $this->categoryMapper->findChampionshipIdByCoupleId($couple);

			foreach($championshipsId as $championshipId){

				array_push($championships, $championshipId);
			}
		}

		$myChampionships = array();

		foreach($championships as $championship){

			array_push($myChampionships, $this->championshipMapper->findById($championship));
		}

		if ($this->userMapper->isAdmin()) $this->view->setVariable("role", "Administrator");
        else if ($this->userMapper->isTrainer()) $this->view->setVariable("role", "Trainer");

		// put the array containing Post object to the view
		$this->view->setVariable("championships", $myChampionships);

		// render the view (/view/posts/index.php)
		$this->view->render("championships", "myChampionships");
	}

	/**
	* Action to view a given post
	*
	* This action should only be called via GET
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>id: Id of the post (via HTTP GET)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>posts/view: If post is successfully loaded (via include).	Includes these view variables:</li>
	* <ul>
	*	<li>post: The current Post retrieved</li>
	*	<li>comment: The current Comment instance, empty or
	*	being added (but not validated)</li>
	* </ul>
	* </ul>
	*
	* @throws Exception If no such post of the given id is found
	* @return void
	*
	*/
	public function view(){

		if (!isset($this->currentUser)) {
			$this->view->setVariable("error", "Not in session. View championships requires login");
			// obtain the data from the database
			$championships = $this->championshipMapper->findAll();

			// put the array containing Post object to the view
			$this->view->setVariable("championships", $championships);
			$this->view->render("championships", "index");
		} 
		else {
			if (!isset($_GET["championshipId"])) {
				throw new Exception("championshipId is mandatory");
			}
	
			$championshipid = $_GET["championshipId"];
	
			// find the Championship object in the database
			$championship = $this->championshipMapper->findById($championshipid);
			
			// find Categories of a championship
			$categories = $this->categoryMapper->findCategoriesByChampionshipId($championship->getChampionshipId());
	
			foreach($categories as $category){
				
				$categoriesGroups[$category->getLevel().$category->getGender()] = $this->championshipMapper->findGroups($category->getCategoryId(), $championshipid);
				
			}
	
			$this->view->setVariable("championship", $championship);
			$this->view->setVariable("categories", $categories);
			$this->view->setVariable("categoriesGroups", $categoriesGroups);
	
			// render the view (/view/championships/view.php)
			$this->view->render("championships", "view");
		}
        
		if (!isset($_GET["championshipId"])) {
			throw new Exception("championshipId is mandatory");
		}
	}
	

	/**
	* Action to add a new championship
	*
	* When called via GET, it shows the add form
	* When called via POST, it adds the championship to the
	* database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the championship (via HTTP POST)</li>
    * <li>maxParticipants: Number of max participants of the championship (via HTTP POST)</li>
    * <li>normative: Normative of the championship (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>championships/add: If this action is reached via HTTP GET (via include)</li>
	* <li>championships/index: If championship was successfully added (via redirect)</li>
	* <li>championships/add: If validation fails (via include). Includes these view variables:</li>
	* <ul>
	*	<li>championship: The current Championship instance, empty or
	*	being added (but not validated)</li>
	*	<li>errors: Array including per-field validation errors</li>
	* </ul>
	* </ul>
	* @throws Exception if no user is in session
	* @return void
	*/
	public function add() {

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Adding championships requires login");
		}

		$championship = new Championship();

		// Get the categories of the championship
		$categories = $this->categoryMapper->findAll();

		// Get the administrator entities from the database
        $administrators = $this->championshipMapper->findAdministrators();

        // Check if the currentUser (in Session) is an administrator
        $cont = 0;
        foreach($administrators as $administrator){
            
            if($administrator->getDni() == $this->currentUser->getDni()) {
                
                $cont = 1;
            }
		}
		
		if($cont == 1){

			if (isset($_POST["submit"])) { // reaching via HTTP Post...
				
				$temp = $_FILES['normative']['tmp_name'];
				$location = "__DIR__/../normatives";
				$normativeName = $_FILES['normative']['name'];  
                $url = $location . "/" . $normativeName;

				// populate the Championship object with data form the form
				$championship->setName($_POST["name"]);
				$championship->setMaxParticipants($_POST["maxParticipants"]);
				$championship->setNormative($url);
				$championship->setDeadLine($_POST["deadLine"]);

				$categoryId = $_POST["checkbox"];

				try {
					// validate Championship object
					$championship->checkIsValidForCreate(); // if it fails, ValidationException

					// save the Championship object into the database
					if (move_uploaded_file($temp,$url)){
						$this->championshipMapper->save($championship);
					}

					$championshipid = $this->championshipMapper->findIdByName($_POST["name"]);

					if($_POST['checkbox'] != ""){

						if(is_array($_POST['checkbox'])){
		
							while(list($key,$value) = each($_POST['checkbox'])){
		
								$this->championshipMapper->saveCategoryIntoChampionship($championshipid, $value);
							}
						}
					}

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of championships
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Championship \"%s\" successfully added."),$championship ->getName()));

					// perform the redirection. More or less:
					// header("Location: index.php?controller=championships&action=index")
					// die();
					$this->view->redirect("championships", "index");

				}
				catch(ValidationException $ex) {

					// Get the errors array inside the exepction...
					$errors = $ex->getErrors();
					// And put it to the view as "errors" variable
					$this->view->setVariable("errors", $errors);
				}
			}

			// Put the Championship object visible to the view
			$this->view->setVariable("championship", $championship);
			$this->view->setVariable("categories", $categories);

			// render the view (/view/championship/add.php)
			$this->view->render("championships", "add");
		}
		else{
			throw new Exception("The logged user is not an Administrator");
		}
	}

	/**
	* Action to edit a championship
	*
	* When called via GET, it shows an edit form
	* including the current data of the Championship.
	* When called via POST, it modifies the championship in the
	* database.
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>name: Name of the championship (via HTTP POST)</li>
    * <li>maxParticipants: Number of max participants of the championship (via HTTP POST)</li>
    * <li>normative: Normative of the championship (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>championships/edit: If this action is reached via HTTP GET (via include)</li>
	* <li>championships/index: If championship was successfully edited (via redirect)</li>
	* <li>championships/edit: If validation fails (via include). Includes these view variables:</li>
	* <ul>
	*	<li>championship: The current Championship instance, empty or being added (but not validated)</li>
	*	<li>errors: Array including per-field validation errors</li>
	* </ul>
	* </ul>
	* @throws Exception if no id was provided
	* @throws Exception if no user is in session
    * @throws Exception if there is not any championship with the provided id
    * @throws Exception if the current logged user is not an administrator
	* @return void
	*/
	public function edit() {

		if (!isset($_REQUEST["championshipId"])) {

			throw new Exception("A championship id is mandatory");
		}

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Editing championships requires login");
		}


		// Get the Post object from the database
		$championshipid = $_REQUEST["championshipId"];
		$championship = $this->championshipMapper->findById($championshipid);

		// Does the championship exist?
		if ($championship == NULL) {

			throw new Exception("no such championship with id: ".$championshipid);
        }
        
        // Get the administrator entities from the database
        $administrators = $this->championshipMapper->findAdministrators();

        // Check if the currentUser (in Session) is an administrator
        $cont = 0;
        foreach($administrators as $administrator){
            
            if($administrator->getDni() == $this->currentUser->getDni()) {
                
                $cont = 1;
            }
        }

        if($cont == 1){

			if (isset($_POST["submit"])) { // reaching via HTTP Post...

				$normative = basename($championship->getNormative());
				$url = __DIR__.'/../normatives/'.$normative;

				unlink($url);
				
				$temp = $_FILES['normative']['tmp_name'];
				$location = "__DIR__/../normatives";
				$normativeName = $_FILES['normative']['name'];  
				$url = $location . "/" . $normativeName;

                // populate the Championship object with data form the form
                $championship->setName($_POST["name"]);
                $championship->setMaxParticipants($_POST["maxParticipants"]);
				$championship->setNormative($url);
				$championship->setDeadLine($_POST["deadLine"]);

                try {
                    // validate Post object
                    $championship->checkIsValidForUpdate(); // if it fails, ValidationException

					// update the Post object in the database
					if (move_uploaded_file($temp,$url)){
						$this->championshipMapper->update($championship);
					}

                    // POST-REDIRECT-GET
                    // Everything OK, we will redirect the user to the list of posts
                    // We want to see a message after redirection, so we establish
                    // a "flash" message (which is simply a Session variable) to be
                    // get in the view after redirection.
                    $this->view->setFlash(sprintf(i18n("Championship \"%s\" successfully updated."),$championship ->getName()));

                    // perform the redirection. More or less:
                    // header("Location: index.php?controller=posts&action=index")
                    // die();
                    $this->view->redirect("championships", "index");

                }
                catch(ValidationException $ex) {

                    // Get the errors array inside the exepction...
                    $errors = $ex->getErrors();
                    // And put it to the view as "errors" variable
                    $this->view->setVariable("errors", $errors);
                }
            }

            // Put the Post object visible to the view
            $this->view->setVariable("championship", $championship);

            // render the view (/view/posts/add.php)
            $this->view->render("championships", "edit");
        }
        else{
            throw new Exception("The logged user is not an Administrator");
        }
	}

	/**
	* Action to delete a championship
	*
	* This action should only be called via HTTP POST
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>championshipId: Id of the championship (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>championships/index: If championship was successfully deleted (via redirect)</li>
	* </ul>
	* @throws Exception if no id was provided
	* @throws Exception if no user is in session
	* @throws Exception if there is not any championship with the provided id
	* @throws Exception if the creator of the championship to be deleted is not an administrator
	* @return void
	*/
	public function delete() {

		if (!isset($_POST["championshipId"])) {

			throw new Exception("championshipId is mandatory");
        }
        
		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Editing championships requires login");
		}
		
		// Get the Championship object from the database
		$championshipid = $_REQUEST["championshipId"];
		$championship = $this->championshipMapper->findById($championshipid);

		// Does the championship exist?
		if ($championship == NULL) {

			throw new Exception("no such championship with id: ".$championshipid);
        }
        
        // Get the administrator entities from the database
        $administrators = $this->championshipMapper->findAdministrators();

        // Check if the currentUser (in Session) is an administrator
        $cont = 0;
        foreach($administrators as $administrator){
            
            if($administrator->getDni() == $this->currentUser->getDni()) {
                
                $cont = 1;
            }
        }

        if($cont == 1){

            // Delete the Post object from the database
            $this->championshipMapper->delete($championship);

            // POST-REDIRECT-GET
            // Everything OK, we will redirect the user to the list of championships
            // We want to see a message after redirection, so we establish
            // a "flash" message (which is simply a Session variable) to be
            // get in the view after redirection.
            $this->view->setFlash(sprintf(i18n("Championship \"%s\" successfully deleted."),$championship ->getName()));

            // perform the redirection. More or less:
            // header("Location: index.php?controller=championships&action=index")
            // die();
            $this->view->redirect("championships", "index");
        }
        else{
            throw new Exception("The logged user is not an Administrator");
        }
	}

	/**
	* Action to register in a championship
	*
	* When called via GET, it shows the enroll form
	* When called via POST, it adds the inscription to the
	* database
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>championshipId: Id of the championship (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>championships/enroll: If this action is reached via HTTP GET (via include)</li>
	* <li>championships/index: If inscription was successfully added (via redirect)</li>
	* </ul>
	* @throws Exception if no user is in session
	* @return void
	*/
	public function enroll() {

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Enroll in a championship requires login");
		}

		if (!isset($_REQUEST["championshipId"])) {

			throw new Exception("championshipId is mandatory");
		}

		$championshipid = $_REQUEST["championshipId"];

		// Get the categories of the championship
		$categories = $this->championshipMapper->findByIdWithCategories($championshipid);
		
		foreach($categories as $category){

			$categoryComplete = $this->categoryMapper->findById($category);
			$categoriesNames[$category->getCategoryId()] = $categoryComplete->getLevel().$categoryComplete->getGender();
		}

		if (isset($_POST["submit"])) { // reaching via HTTP Post...

			$championshipid = $_POST["championshipId"];
			$categoryid = $_POST["categoryId"];
			$captain = $_POST["captain"];
			$pair = $_POST["pair"];

			$category = $this->categoryMapper->findById2($categoryid);
			$captainInfo = $this->athleteMapper->findById($captain);
			$pairInfo = $this->athleteMapper->findById($pair);

			if($category->getGender() == 'MX'){
				
				try {
	
					// save the Captain of a Couple into the database
					$this->coupleMapper->saveCouple($captain, $pair);
	
					$coupleid = $this->coupleMapper->findCoupleIdByCaptainPair($captain, $pair);
					
					// save the Couple in a Category into the database
					$this->coupleMapper->saveCoupleToCategory($coupleid, $categoryid, $championshipid);
	
					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to select its pair
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash(sprintf(i18n("Couple \"%s\" successfully added."),$coupleid));
	
					// perform the redirection. More or less:
					// header("Location: index.php?controller=championships&action=choosePair")
					// die();
					$this->view->redirect("championships", "index");
	
				}
				catch(ValidationException $ex) {
	
					// Get the errors array inside the exepction...
					$errors = $ex->getErrors();
					// And put it to the view as "errors" variable
					$this->view->setVariable("errors", $errors);
				}
			}
			else{
				if($category->getGender() != $captainInfo->getGender()){

					$errors["genre"] = i18n("Different genre. Your genre is different than genre of category");
		
					$championships = $this->championshipMapper->findAll();
	
					$this->view->setVariable("championships", $championships);
					$this->view->setVariable("errors", $errors);
					$this->view->render("championships", "index");
				}
				else{
					if($category->getGender() != $pairInfo->getGender()){
						
						$errors["genre"] = i18n("Different genre. The genre of your pair is different than genre of category");
						
						$championships = $this->championshipMapper->findAll();
	
						$this->view->setVariable("championships", $championships);
						$this->view->setVariable("errors", $errors);
						$this->view->render("championships", "index");
					}
					else{
						try {
	
							// save the Captain of a Couple into the database
							$this->coupleMapper->saveCouple($captain, $pair);
			
							$coupleid = $this->coupleMapper->findCoupleIdByCaptainPair($captain, $pair);
							
							// save the Couple in a Category into the database
							$this->coupleMapper->saveCoupleToCategory($coupleid, $categoryid, $championshipid);
			
							// POST-REDIRECT-GET
							// Everything OK, we will redirect the user to select its pair
							// We want to see a message after redirection, so we establish
							// a "flash" message (which is simply a Session variable) to be
							// get in the view after redirection.
							$this->view->setFlash(sprintf(i18n("Couple \"%s\" successfully added."),$coupleid));
			
							// perform the redirection. More or less:
							// header("Location: index.php?controller=championships&action=choosePair")
							// die();
							$this->view->redirect("championships", "index");
			
						}
						catch(ValidationException $ex) {
			
							// Get the errors array inside the exepction...
							$errors = $ex->getErrors();
							// And put it to the view as "errors" variable
							$this->view->setVariable("errors", $errors);
						}
					}
				}
			}
		}

		$this->view->setVariable("championshipid", $championshipid);
		$this->view->setVariable("categories", $categories);
		$this->view->setVariable("categoriesNames", $categoriesNames);

		// render the view (/view/championship/add.php)
		$this->view->render("championships", "enroll");
	}

	/**
	* Action to generate the calendar of a championship
	*
	* When called via GET, it generate the groups and then generate the matches
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>championshipId: Id of the championship (via HTTP GET)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>championships/view: If calendar was succesfully generated (via redirect)</li>
	* </ul>
	* @throws Exception if no user is in session
	* @return void
	*/
	public function generateCalendar() {

		if (!isset($this->currentUser)) {

			throw new Exception("Not in session. Generate Calendar requires login");
		}

		if (!isset($_REQUEST["championshipId"])) {

			throw new Exception("championshipId is mandatory");
		}

		$championshipid = $_REQUEST["championshipId"];

		// Get the administrator entities from the database
        $administrators = $this->championshipMapper->findAdministrators();

		// Check if the currentUser (in Session) is an administrator
        $cont = 0;
        foreach($administrators as $administrator){
            
            if($administrator->getDni() == $this->currentUser->getDni()) {
                
                $cont = 1;
            }
		}

		if($cont == 1){

			$categories = $this->championshipMapper->findCategoriesByChampionshipId($championshipid);

			//Create groups for each Category of a Championship
			foreach($categories as $category){

				$couples = $this->championshipMapper->findCouples($category, $championshipid);

				$numCouples = count($couples);
				$numCouplesGroup = $numCouples % 12;
				$lastGroupCouples = 0;

				for($i=12;$i>=8;$i--){
					$couplesPerGroupRemainder = $numCouples % $i;

					if($couplesPerGroupRemainder == 0){
						$numCouplesGroup = $i;
						break;
					} else if($couplesPerGroupRemainder >= 8) {
						$numCouplesGroup = $i;
						$lastGroupCouples = $couplesPerGroupRemainder;
						break;
					}
				}

				$numGroups = intval($numCouples / $numCouplesGroup);
				$couple = 0;

				for($i = 0; $i < $numGroups; $i++){

					$groupId = $this->championshipMapper->saveGroup($championshipid, $category);
			
					for($j = 0; $j < $numCouplesGroup; $j++){

						$this->coupleMapper->saveCoupleIntoGroup($groupId, $couples[$couple]);
						$this->coupleMapper->updateGroupOfACouple($couples[$couple], $groupId);
						$couple++;
					}
				}

				if($lastGroupCouples > 0 ){
					$groupId = $this->championshipMapper->saveGroup($championshipid, $category);

					for($j = 0; $j < $lastGroupCouples; $j++){
	
						$this->coupleMapper->saveCoupleIntoGroup($groupId, $couples[$couple]);
						$this->coupleMapper->updateGroupOfACouple($couples[$couple], $groupId);
						$couple++;
					}
				}
			}

			//Generate the matches for each group
			foreach($categories as $category){

				$groups = $this->championshipMapper->findGroups($category, $championshipid);

				foreach($groups as $group){

					$couplesGroup = $this->championshipMapper->findCouplesByGroupId($group);

					$numCoup = count($couplesGroup);
					$round = 'G';

					for($i = 0; $i < $numCoup; $i++){

						for($j = $i + 1; $j < $numCoup; $j++){

							$this->championshipMapper->saveMatch($couplesGroup[$i], $couplesGroup[$j], $group, $round);
						}
					}
				}
			}

			$this->view->redirect("championships", "view", "championshipId=".$championshipid);
		}
		else{
			throw new Exception("The logged user is not an Administrator");
		}
	}

	public function viewAllMyMatches(){

		$matches=$this->matchMapper->getMatchesByAthlete($_REQUEST["championshipId"],$_SESSION['currentuser']);
		
		$this->view->setVariable("matches",$matches);
		$this->view->render("championships","matches");
	}

	public function setDateForMatch(){

		$match= $this->matchMapper->findById($_POST["idMatch"]);
		$dates= $this->matchMapper->getPreselectedDates($_POST["idMatch"]);

		if (isset($_POST["submit"])) { // reaching via HTTP Post...

			$matchId = $_POST["idMatch"];

			$date1 = $_POST["date1"];
			$hour1 = $_POST["hour1"];

			$date2 = $_POST["date2"];
			$hour2 = $_POST["hour2"];

			$date3 = $_POST["date3"];
			$hour3 = $_POST["hour3"];

			$this->matchMapper->savePreselectedFetch($matchId, $date1.' '.$hour1, $date2.' '.$hour2, $date3.' '.$hour3);

			//$this->matchMapper->saveDateTime($date.' '.$hour, $matchId);

			$this->view->redirect("main", "index");
		}

		$this->view->setVariable("match",$match);
		$this->view->setVariable("dates",$dates);
		$this->view->render("championships","setDateForMatch");
	}

	public function downloadNormative(){

		if(!isset($_GET['normative'])){

			throw new Exception("normative is mandatory");
		}

		$normative = basename($_GET['normative']);
		$url = __DIR__.'/../normatives/'.$normative;

		if (is_file($url)){

			header('Content-Type: application/force-download');
			header('Content-Disposition: attachment; filename='.$normative);
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($url));

			readfile($url);
		}
		else{
			throw new Exception("Does not exists normative");
		}
	}
}
