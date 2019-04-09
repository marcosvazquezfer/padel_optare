<?php
//file: controller/ClassController.php

require_once __DIR__ . "/../model/TrainingClass.php";
require_once __DIR__ . "/../model/Calendar.php";
require_once __DIR__ . "/../model/Message.php";
require_once __DIR__ . "/../model/Asistence.php";
require_once __DIR__ . "/../model/TrainingClassMapper.php";
require_once __DIR__ . "/../model/CalendarMapper.php";
require_once __DIR__ . "/../model/UserMapper.php";
require_once __DIR__ . "/../model/AsistenceMapper.php";

require_once __DIR__ . "/../core/ViewManager.php";
require_once __DIR__ . "/../core/sendMail.php";
require_once __DIR__ . "/../controller/BaseController.php";

/**
 * Class ClassController
 *
 * Controller to make a CRUDL of Class entities
 *
 * @author Roi Pérez López
 */
class ClassesController extends BaseController
{

    /**
     * Reference to the TrainingClassMapper to interact
     * with the database
     *
     * @var classMapper
     */
    private $classMapper;
    private $calendarMapper;
    private $userMapper;
    private $asistenceMapper;

    public function __construct()
    {

        parent::__construct();

        $this->classMapper = new TrainingClassMapper();
        $this->calendarMapper = new CalendarMapper();
        $this->userMapper = new UserMapper();
        $this->asistenceMapper = new AsistenceMapper();
    }

    public function index()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. View classes requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else {
            $classes = $this->classMapper->getAll();

            $monthlyClassesCalendar = array();
            if ($classes == null) {
                $classes = [];
            } else {
                $monthlyClassesCalendar = $this->buildCalendarMonthly($classes);
            }

            $this->view->setVariable("classes", $classes);
            $this->view->setVariable("monthlyClassesCalendar", $monthlyClassesCalendar);

            $role = array();
            if ($this->userMapper->isTrainer()) {
                array_push($role, "Trainer");
            }
            if ($this->userMapper->isAdmin()) {
                array_push($role, "Administrator");
            }

            $this->view->setVariable("role", $role);

            // render the view (/view/bookings/index.php)
            $this->view->render("classes", "index");
        }
    }

    private function buildCalendarMonthly($classes)
    {
        $calendar = array();
        foreach ($classes as $class) {
            $classCalendar = $this->classMapper->getClassCalendarMonthly($class->getClassId());
            if ($classCalendar != null) {
                $calendar[$class->getClassId()] = array();
                array_push($calendar[$class->getClassId()], [$classCalendar->getStartDate(), $classCalendar->getEndDate()]);
            }
        }
        return $calendar;
    }

    public function myClasses()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. View classes requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else {
            $coaches = $this->userMapper->findAllCoaches();

            $role = array();
            if ($this->userMapper->isTrainer()) {
                array_push($role, "Trainer");
            }
            if ($this->userMapper->isAdmin()) {
                array_push($role, "Administrator");
            }

            $this->view->setVariable("role", $role);

            if (in_array($_SESSION["currentuser"], $coaches)) {

                $classes = $this->classMapper->getAllById($_SESSION["currentuser"]);
                $classesCalendar = array();
                if ($classes == null) {
                    $classes = [];
                    $monthlyClassesCalendar = [];
                } else {
                    $monthlyClassesCalendar = $this->buildCalendarMonthly($classes);
                }

                $this->view->setVariable("classes", $classes);
                $this->view->setVariable("monthlyClassesCalendar", $monthlyClassesCalendar);

                // render the view (/view/bookings/index.php)
                $this->view->render("classes", "myClasses");
            } else {

                $classes = $this->classMapper->findByUserId($_SESSION["currentuser"]);
                $classesCalendar = array();
                if ($classes == null) {
                    $classes = [];
                    $monthlyClassesCalendar = [];
                } else {
                    $monthlyClassesCalendar = $this->buildCalendarMonthly($classes);
                }

                $this->view->setVariable("classes", $classes);
                $this->view->setVariable("monthlyClassesCalendar", $monthlyClassesCalendar);

                // render the view (/view/classes/index.php)
                $this->view->render("classes", "myClasses");
            }
        }
    }

    public function addParticular()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. Adding classes requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else if ($this->userMapper->isTrainer()) {
            if (isset($_POST["trainer"])) {
                $trainer = $_POST["trainer"];
                $level = $_POST["level"];
                $beginDatetime = $_POST["begin"];

                $class = new TrainingClass(null, $level, $_SESSION["currentuser"], $trainer, $beginDatetime);
                $this->classMapper->save($class);
                $this->view->redirect("classes", "index");
            }
            $this->view->render("classes", "addParticular");
        } else {
            $errors["logging"] = i18n("Must be Trainer to add a particular class");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        }
    }

    public function addMonthly()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. Adding classes requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else if ($this->userMapper->isAdmin()) {
            if (isset($_POST["trainer"])) {
                $trainer = $_POST["trainer"];
                $level = $_POST["level"];
                $month = $_POST["month"];
                $weekday = $_POST["weekday"];
                $begin = $_POST["begin"];

                $courtId = $this->calendarMapper->findOneFree($begin);

                $date = date_create_from_format('Y-m-d H:i:s', '2019-' . $month . '-01 ' . $begin);

                for ($d = 0; $d < 7; $d++) {
                    $dayName = $date->format('l');

                    if ($weekday == $dayName) {
                        break;
                    }
                    $date = $date->add(new DateInterval("P1D"));
                }

                $endHour = new DateTime($date->format('Y-m-d H:i:s'));
                $endHour = $endHour->add(new DateInterval("PT1H30M"));

                $class = new TrainingClass(null, $level, $_SESSION["currentuser"], $trainer, $date->format('Y-m-d H:i:s'));

                $classId = $this->classMapper->save($class);

                while (true) {
                    if ($date->format("m") == $month) {
                        $calendario = new Calendar(null, $date->format('Y-m-d H:i:s'), $endHour->format('Y-m-d H:i:s'), $courtId, $_SESSION["currentuser"], "Clase Mensual");
                        $calendarId = $this->calendarMapper->save($calendario);
                        $this->classMapper->saveCalendar($classId, $calendarId);
                        $date = $date->add(new DateInterval("P7D"));
                        $endHour = new DateTime($date->format('Y-m-d H:i:s'));
                        $endHour = $endHour->add(new DateInterval("PT1H30M"));
                    } else {
                        break;
                    }
                }
                $this->view->redirect("classes", "index");
            }
            $this->view->render("classes", "addMonthly");
        } else {
            $errors["logging"] = i18n("Must be Administrator to add a monthly class");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        }
    }

    public function delete()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. Deleting a class requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else {
            if (isset($_GET["classId"])) {
                $this->classMapper->removeClass($_GET["classId"]);
                $messages["delete"] = i18n("Class was succesfully deleted");
                $this->view->setVariable("messages", $messages);
            }
            $this->view->redirect("classes", "index");
        }
    }

    public function enroll()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. Enroll in classes requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else {
            if (!isset($_GET["classId"])) {

                throw new Exception("classId is mandatory");
            }

            if (!isset($_GET["type"])) {

                throw new Exception("type is mandatory");
            }

            $currentUser = $_SESSION["currentuser"];
            $classId = $_GET["classId"];
            $type = $_GET["type"];

            $athletesClass = $this->classMapper->findAthletesByClassId($classId);
            $class = $this->classMapper->get($classId);

            if ($type == 'P') {

                if (count($athletesClass) == 3) {

                    $errors["enrolling"] = i18n("Selected class is already complete");
                    $this->view->setVariable("errors", $errors);
                    $this->index();
                } else {
                    if (count($athletesClass) == 2) {

                        $this->classMapper->enroll($classId, $currentUser);

                        $courtId = $this->calendarMapper->findOneFree($class->getDate());

                        if ($courtId != null) {

                            $startHour = new DateTime($class->getDate());
                            $endHour = $startHour->add(new DateInterval("PT1H30M"));
                            $calendar = new Calendar(null, $class->getDate(), $endHour->format('Y-m-d H:i:s'), $courtId, $class->getTrainer(), "Clase Particular");
                            $calendarId = $this->calendarMapper->save($calendar);
                            $this->classMapper->saveCalendar($classId, $calendarId);

                            date_default_timezone_set("Europe/Madrid");
                            $date = date_format(date_create(), "Y/m/d");
                            $time = date_format(date_create(), "H:i:s");
                            $dateTime = $date . ' ' . $time;

                            $newMessage = new Message($messageId = null, $class->getTrainer(), $message = "Class with id=" . $class->getClassId() . " completed and closed", $date = $dateTime);

                            $this->classMapper->sendMessage($newMessage);
                        } else {
                            date_default_timezone_set("Europe/Madrid");
                            $date = date_format(date_create(), "Y/m/d");
                            $time = date_format(date_create(), "H:i:s");
                            $dateTime = $date . ' ' . $time;

                            $newMessage = new Message($messageId = null, $class->getTrainer(), $message = "No available courts in that datetime", $date = $dateTime);

                            $this->classMapper->sendMessage($newMessage);
                        }
                    } else {
                        $this->classMapper->enroll($classId, $currentUser);
                    }
                }
            } else {
                if (count($athletesClass) == 4) {

                    $errors["enrolling"] = i18n("Selected class is already complete");
                    $this->view->setVariable("errors", $errors);
                    $this->index();
                } else {
                    $this->classMapper->enroll($classId, $currentUser);
                }
            }

            $messages["enroll"] = i18n("You were succesfully added to the class");
            $this->view->setVariable("messages", $messages);

            // render the view (/view/classes/enroll.php)
            $this->myClasses();
        }
    }

    public function unsubscribe()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. Unsubscribe from classes requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else {
            if (!isset($_GET["classId"])) {

                throw new Exception("classId is mandatory");
            }

            $currentUser = $_SESSION["currentuser"];
            $classId = $_GET["classId"];

            $this->classMapper->unsubscribe($classId, $currentUser);

            $messages["unsubscribe"] = i18n("You were succesfully uninscribed from the class");
            $this->view->setVariable("messages", $messages);

            // render the view (/view/classes/enroll.php)
            $this->myClasses();
        }
    }

    public function sendNotification()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. Send notifications requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else if ($this->userMapper->isTrainer()) {
            if (isset($_POST["message"])) {
                $message = $_POST["message"];
                $classId = $_POST["classId"];
                $users = $this->classMapper->findAthletesByClassId($classId);
                $fecha = new DateTime();
                foreach ($users as $user) {
                    $msg = new Message(null, $user, $message, $fecha->format('Y-m-d H:i:s'));
                    $mailSender = new MailSender();
                    $mailSender->sendMail($message);
                    $this->classMapper->sendMessage($msg);
                }
                $this->view->redirect("classes", "index");
            } else {
                $classId = $_GET["classId"];
                $this->view->setVariable("classId", $classId);
                $this->view->render("classes", "sendMessage");
            }
        } else {
            $errors["logging"] = i18n("Must be Trainer to send messages");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        }
    }

    public function showAsistance()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. Send notifications requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else if ($this->userMapper->isTrainer()) {
            if (isset($_GET["classId"]) && isset($_GET["fecha"])) {
                $classId = $_GET["classId"];
                $fecha = $_GET["fecha"];
                $asistence = $this->asistenceMapper->get($classId, $fecha);
                $this->view->setVariable("asistence", $asistence);
                $this->view->render("classes", "asistence");
            }
        } else {
            $errors["logging"] = i18n("Must be Trainer to show Asistance");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        }
    }

    public function setAsistance()
    {
        if (!isset($_SESSION["currentuser"])) {
            $errors["logging"] = i18n("Not in session. Send notifications requires login");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        } else if ($this->userMapper->isTrainer()) {
            if (isset($_GET["classId"]) && isset($_GET["fecha"]) && isset($_GET["control"]) && isset($_GET["userId"])) {
                $classId = $_GET["classId"];
                $fecha = $_GET["fecha"];
                $control = $_GET["control"];
                if ($control == 1) {
                    $control = 0;
                } else {
                    $control = 1;
                }

                $userId = $_GET["userId"];
                $asistence = $this->asistenceMapper->update($userId, $fecha, $control, $classId);
                $asistence = $this->asistenceMapper->get($classId, $fecha);
                $this->view->setVariable("asistence", $asistence);
                $this->view->render("classes", "asistence");
            }
        } else {
            $errors["logging"] = i18n("Must be Trainer to show Asistance");
            $this->view->setVariable("errors", $errors);
            $this->view->render("main", "index");
        }
    }

}
