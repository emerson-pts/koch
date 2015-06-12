<?php
class AreasController extends AppController {

	var $name = 'Areas';

	function beforeRender(){
		parent::beforeRender();
		
		//Ajusta variáveis dos relacionamentos habtm para exibir os itens 
		//relacionados corretamente após enviar o formulário pela 1 vez e
		//reexibir o form (ex. falha na validação)
		if(preg_match('/^(add|edit)$/', $this->action)){
		
			foreach(array(
				'VideoRelacionado',
				'GaleriaRelacionada',
			) AS $related){
				if(!empty($this->data[$related][$related])){
					foreach($this->data[$related][$related] AS $key=>$value){
						if(!empty($value) && !is_array($value)){
							$params = array('contain' => false, 'fields' => (!empty($this->Noticia->hasAndBelongsToMany[$related]['fields']) ? $this->Noticia->hasAndBelongsToMany[$related]['fields'] : null), 'conditions' => array($related.'.id' => $value));
							if(!empty($this->Noticia->hasAndBelongsToMany[$related]['order'])){
								$params['order'] = $this->Noticia->hasAndBelongsToMany[$related]['order'];
							}
							
							$related_data = $this->Noticia->$related->find('first', $params);
							$this->data[$related][$key] = $related_data[$related];
						}
					}
					unset($this->data[$related][$related]);
				}
			}
		}		
	}
	
	
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

}