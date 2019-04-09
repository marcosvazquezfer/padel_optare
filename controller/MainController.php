<?php
//file: controller/MainController.php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");


class MainController extends BaseController {

	public function index() {
		// render the view (/view/main/index.php)
		$this->view->render("main", "index");
	}
}
