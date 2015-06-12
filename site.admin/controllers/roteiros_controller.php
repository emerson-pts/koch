<?php
class RoteirosController extends AppController {

	var $name = 'Roteiros';

	function index(){
		$this->_admin_index();
	}

	function add($destino_id = null){
		//Se definiu o pai
		if(!empty($destino_id) && empty($this->data['Roteiro']['destino_id'])){
			$this->data['Roteiro']['destino_id'] = $destino_id;
		}

		//Se está filtrando o destino
		if(!isset($this->data['Roteiro']['destino_id']) && !empty($this->params['named']['filter[Roteiro.destino_id]'])){
			//Define um destino autal na view
			$this->data['Roteiro']['destino_id'] = preg_replace('/\|.*$/', '', $this->params['named']['filter[Roteiro.destino_id]']);
		}

		if(!empty($this->data['Roteiro']['destino_id'])){
			if($destino_atual = $this->Roteiro->Destino->find('first', array('contain' => false, 'conditions' => array('Destino.id' => $this->data['Roteiro']['destino_id'])))){
				$this->set('destino_atual', $destino_atual);
			}
		}

		$this->_admin_add();
		
	}

	function edit($id = null){
		//Se está filtrando o destino
		if($id && $roteiro = $this->Roteiro->read('destino_id', $id)){
			//Define um destino autal na view
			$destino_id = $roteiro['Roteiro']['destino_id'];
			$destino_atual = $this->Roteiro->Destino->find('first', array('contain' => false, 'conditions' => array('Destino.id' => $destino_id)));
			$this->set('destino_atual', $destino_atual);
		}
 		$this->_admin_edit($id);
	}

	function delete($id = null){
		$this->_admin_delete($id);
	}

	function render_preco(){
		$this->layout = null;
		$this->helpers[] = 'BoomViagens';
	}	
}