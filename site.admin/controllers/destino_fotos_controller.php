<?php
class DestinoFotosController extends AppController {

	var $name = 'DestinoFotos';
	var $components = array('SortableAdmin');
	
	function beforeRender(){
		parent::beforeRender();
		
		//Se está filtrando o destino
		if(!empty($this->params['named']['filter[DestinoFoto.destino_id]'])){
			
			//Define um destino autal na view
			$this->data['DestinoFoto']['destino_id'] = $this->params['named']['filter[DestinoFoto.destino_id]'];
			$destino_atual = $this->DestinoFoto->Destino->find('first', array('contain' => false, 'conditions' => array('Destino.id' => $this->data['DestinoFoto']['destino_id'])));
			$this->set('destino_atual', $destino_atual);
		}
	}

	function index(){
		if(empty($this->params['named']['filter[DestinoFoto.destino_id]'])){
			$this->Session->setFlash(__('O destino não foi informado!', true),'default',array('class'=>'message_error'));
			$this->redirect(array('controller' => 'destinos',));
		}

		$this->_admin_index();
	}

	function add($multiple = false){
		if ($multiple && $this->RequestHandler->isPost()){
			App::import('Vendor', 'Fileuploader');

			// list of valid extensions
			$allowedExtensions = array('jpeg', 'jpg', 'png', 'gif',);
			// max file size in bytes
			$postSize = qqFileUploader::toBytes(ini_get('post_max_size'));
			$uploadSize = qqFileUploader::toBytes(ini_get('upload_max_filesize'));        
 			$sizeLimit = ($postSize < $uploadSize ? $postSize : $uploadSize);

			$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
			$result = $uploader->handleUpload(CACHE .'uploads/');
			
			//Se não gravou ou imagem inválida
			if(empty($result['success']) || !($getimagesize = getimagesize($uploader->filename))){
				unlink($uploader->filename);//remove arquivo
				if ($this->RequestHandler->isAjax()) { 
					$this->set('data', __('Falha no envio do arquivo!', true));
					$this->render('/elements/json');
					return;
				}
				$this->Session->setFlash(__('Falha no upload!', true),'default',array('class'=>'message_error'));
				$this->redirect(array('action' => 'index') + $this->params['named']);
			}
			
			$this->data = array(
				'DestinoFoto' => array(
					'destino_id'=> $_GET['destino_id'],
					'arquivo'	=> array(
						'name'	=> basename($uploader->filename),
						'type'	=> $getimagesize['mime'],
						'tmp_name'	=> $uploader->filename,
						'error' => 0,
						'size'	=> $uploader->size,
					),
				),
			);
			
			//Desativa verificação de arquivo enviado através de upload
			$this->DestinoFoto->validate['arquivo']['UploadedFile']['check'] = false;
			
			$this->DestinoFoto->create();
			
			$return = $this->DestinoFoto->save($this->data);
			
			if ($this->RequestHandler->isAjax()) { 
				if(!$return){
					$this->set('data', array('error' => 'Falha no envio do arquivo '.$_GET['qqfile'].'! '.implode(' - ', $this->DestinoFoto->validationErrors)));
				}else{
					$this->set('data', array('success' => true));
				}
				$this->render('/elements/json');
				return;
			}else{
				if(!$return){
					$this->Session->setFlash(sprintf(__('Falha no envio do arquivo %s! %s', true), $_GET['qqfile'], implode(' - ', $this->DestinoFoto->validationErrors)),'default',array('class'=>'message_error'));
				}else{
					$this->Session->setFlash(__('Arquivo enviado com sucesso!', true),'default',array('class'=>'message_success'));
				}
				$this->redirect(array('action' => 'index') + $this->params['named']);
			}
		}		
	
		if($multiple && empty($this->params['named']['filter[DestinoFoto.destino_id]'])){
			$this->Session->setFlash(__('O destino não foi informado!', true),'default',array('class'=>'message_error'));
			$this->redirect(array('controller' => 'destinos',));
		}
		
		$this->_admin_add();
	}

	function edit($id = null){
		$this->_admin_edit($id);
	}

	function delete($id = null){
		$this->_admin_delete($id);
	}
	
	function setposition($id = null, $position = 1){
		$this->SortableAdmin->setposition($id, $position);
	}
	
	function movedown($id = null, $delta = 1) {
		$this->SortableAdmin->movedown($id, $delta);
	}
	
	function moveup($id = null, $delta = 1) {
		$this->SortableAdmin->moveup($id, $delta);
	}
	
	function fixposition(){
		$this->SortableAdmin->fixposition();
	}
}