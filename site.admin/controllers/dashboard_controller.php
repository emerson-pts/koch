<?php
class DashboardController extends AppController {
	var $name = 'Dashboard';
	var $uses = array();
	
	function index(){
		if($loginRedirect = Configure::read('Admin.loginRedirect')){
			$this->redirect($loginRedirect);
		}
	}
}
