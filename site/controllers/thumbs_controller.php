<?php 
class ThumbsController extends Controller{
	var $name = 'Thumbs';
	var $uses = null;
	var $layout = null;
	var $autoRender = false;

	function index(){
		App::import('Vendor','ResizeImg'); 
		$resize = ResizeImg::resize($_GET);
		
		//Se ocorreu algum erro
		if(!empty($resize['error'])){
			echo $resize['error'];
			exit;
		}
		
		//Caso contrário
		else{
//			header($resize['header']);
//			echo file_get_contents($resize['file']);
//			exit;
			
			header('Location: '.$this->base.$resize['url']);
			exit;
		}
	}
}