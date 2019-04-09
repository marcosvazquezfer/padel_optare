<?php
//file: controller/BookingsController.php

require_once(__DIR__."/../model/Calendar.php");
require_once(__DIR__."/../model/CalendarMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

/**
* Class BookingController
*
* Controller to make a CRUDL of Booking entities
*
* @author Roi Pérez López
*/
class BookingsController extends BaseController {

	/**
	* Reference to the CalendarMapper to interact
	* with the database
	*
	* @var calendarMapper
	*/
	private $calendarMapper;
	private $errors;
	private $messages;


	public function __construct() {

		parent::__construct();
		$this->calendarMapper = new CalendarMapper();
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
			$errors["logging"] = i18n("Not in session. View bookings requires login");
			$this->view->setVariable("errors", $errors);
			$this->view->render("main", "index");
		} else {

			$bookings = $this->calendarMapper->getAllBookings($_SESSION["currentuser"]);
			if($bookings == NULL) {
				$bookings = [];
			}

			$this->view->setVariable("bookings", $bookings);

			// render the view (/view/bookings/index.php)
			$this->view->render("bookings", "index");
		}
	}

	public function book(){
		if (!isset($_SESSION["currentuser"]) ) {
			$this->errors["logging"] = i18n("Not in session. Booking requires login");
			$this->view->setVariable("errors", $errors);
			$this->view->render("main", "index");
		} else {
			if (isset($_POST["date"]) && isset($_POST["hour"])) {
				$date = $_POST["date"];
				$hour = $_POST["hour"];

				if($this->calendarMapper->getBookingsCount($_SESSION['currentuser']) < 5) {
					$horario = $date . ' ' . $hour;
					$courtId = $this->calendarMapper->findOneFree($horario);

					if($courtId != NULL) {
						$startHour = new DateTime($horario);
						$endHour = $startHour->add(new DateInterval("PT1H30M"));
						$calendario = new Calendar(null, $horario, $endHour->format('Y-m-d H:i:s'), $courtId, $_SESSION["currentuser"], "Reserva");						
						$this->calendarMapper->save($calendario);
	
						$this->messages["booked"] = i18n("Booked court: ") . $courtId . i18n(", on ") . date_format(date_create($horario),"d/m/Y") . i18n(" from ") . date_format(date_create($horario),"H:i") . i18n(" to ") . $endHour->format('H:i');
					} else {
						$this->errors["no_available_courts"] = i18n("No available courts in that datetime");
					}
				} else {
					$this->errors["book_limit"] = i18n("Book limit of 5 reached, you must delete a booking");
				}
			}
			$this->view->setVariable("messages", $this->messages);
			$this->view->setVariable("errors", $this->errors);
			// render the view (/view/users/register.php)
			$this->view->render("bookings", "book");
		}
	}

	public function delete(){
		if (!isset($_SESSION["currentuser"]) ) {
			$errors["logging"] = i18n("Not in session. Deleting a booking requires login");
			$this->view->setVariable("errors", $errors);
			$this->view->render("main", "index");
		} else {
			if (isset($_POST["idCourt"]) && isset($_POST["startDate"])) {
				$idCourt = $_POST["idCourt"];
				$startDate = $_POST["startDate"];

				$now = new DateTime();
				$startDateDateTime = new DateTime($startDate);
				$limit = $now->add(new DateInterval("PT12H"));

				if($limit->format("Y-m-d") > $startDateDateTime->format("Y-m-d")) {
					$errors["booking"] = i18n("You can not cancel a booking 12h before it begins");
					$this->view->setVariable("errors", $errors);
				} else {
					$this->calendarMapper->delete($idCourt, $startDate);
					$messages["delete"] = i18n("Booking was succesfully deleted");
					$this->view->setVariable("messages", $messages);
				}
			}
			
			$this->index();
		}
	}
}
