<?php
class SistemasController extends AppController {

	var $name = 'Sistemas';
	
	function index(){
		$this->_admin_index();
	}

	function add(){
		$this->helpers[] = 'jmycake';
		$this->_admin_add();
	}

	function edit($id = null){
		$this->helpers[] = 'jmycake';
		$this->_admin_edit($id);
	}

	function delete($id = null){
		$this->_admin_delete($id);
	}

	function download($id){
		$arquivo = $this->Sistema->find('first', array('conditions'=>array(
			'Sistema.id' => $id,
		)));

		// echo SITE_DIR.'webroot/uploads/arquivos'.$arquivo['Sistema']['arquivo'];
		// die;

		if (is_file(SITE_DIR.'webroot/uploads/arquivos'.$arquivo['Sistema']['arquivo'])) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.$arquivo['Sistema']['arquivo'].'"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize(SITE_DIR.'webroot/uploads/arquivos'.$arquivo['Sistema']['arquivo'])); 
			ob_clean();
			flush();
			readfile(SITE_DIR.'webroot/uploads/arquivos'.$arquivo['Sistema']['arquivo']);
		    exit();
		}

		echo $id;
		die;
	}

}