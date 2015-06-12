<?php
define('DESTINO_FOTO_FILE_DIR', SITE_DIR.'webroot/img/upload/destinos_fotos');

class DestinoFoto extends AppModel {

	var $name = 'DestinoFoto';
	var $displayField = 'titulo';
 	var $order = 'DestinoFoto.order ASC';
 	
	var $actsAs = array(
		'Sortable' => array('group' => 'destino_id',), 
        'MeioUpload' => array('arquivo' => array(
			'dir' => DESTINO_FOTO_FILE_DIR,
			'url' => 'upload/destinos_fotos',
        ),)
    );

	var $belongsTo = array(
		'Destino',
	);

	var $validate = array(
/*		
		'titulo' => array(
			'notEmpty' => array(
				'rule'=> 'notEmpty',
				'required'=>true,
				'allowEmpty'=>false,
				'message'=>'O título está em branco.',
			),
			'friendly_url' => array(
				'rule' => 'friendly_url_validate',
				'required'=>false,
				'allowEmpty'=>true,
				'message'=> 'Não foi possível gerar uma url amigável.',
			),
		),
*/
	);
	
	function beforeValidate(){
		//Limpa array do arquivo, caso ele não tenha sido enviado
		//Caso contrário a validação validateAtLeastOne, falhará
		if(
			//Se não enviou o arquivo
			$this->data[$this->alias]['arquivo']['error'] == UPLOAD_ERR_NO_FILE
			&& 
			(empty($this->data[$this->alias]['id']) //novo registro
			||
			!array_key_exists('remove', $this->data[$this->alias]['arquivo']) //não existe campo para remover arquivo... então nenhum arquivo foi enviado
			||
			!empty($this->data[$this->alias]['arquivo']['remove'])
			)
		){
			//Se não é novo registro e solicitou a remoção altera a mensagem de erro
			if(
				!empty($this->data[$this->alias]['id']) //novo registro
				&& !empty($this->data[$this->alias]['arquivo']['remove'])
			){
				$this->validate['arquivo']['validateAtLeastOne']['message'] = 'Você solicitou a remoção do arquivo, mas não enviou um novo ou enviou um código de embed.';
			}
			$this->data[$this->alias]['arquivo'] = null;

		}
		
		//gera url amigável
		$this->friendly_url_validate(array('titulo' => (!array_key_exists('titulo', $this->data[$this->alias]) ? '' : $this->data[$this->alias]['titulo'])));

		return true;
	}
	
	function afterSave($created){
		parent::afterSave($created);
		
		//Se é um registro novo, coloca em 1.o
		if($created){
			$this->moveTop($this->id);
		}
		return true;
	}
	
	function setupAdmin($action = null, $id = null){

		$this->options['destino_id'] = $this->Destino->generatetreelist($conditions=null, $keyPath=null, $valuePath=null, $spacer= '_', $recursive=null);
		
		$setupAdmin = array(
			'displayField' => $this->displayField,
			
			'searchFields' => array(
				'Destino.label',
				'DestinoArquivo.id',
				'DestinoFoto.data',
				'DestinoFoto.titulo',
			),
			
			'topLink' => array(
				'Nova foto' => array('url' => array('action' => 'add'), 'include_params_in_url' => true, 'htmlAttributes' => array()),
				'Envio Múltiplo' => array('url' => array('action' => 'add', 'multiple'), 'include_params_in_url' => true, 'htmlAttributes' => array()),
			),
			
			'listFields' => array(
				'DestinoFoto.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Destino.nome'	 => array('table_head_cell_param' => 'class="text-align-left" width="100"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Destino', ),
				'DestinoFoto.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Título'),
				'DestinoFoto.legenda' => array('table_head_cell_param' => 'class="text-align-left" width="100"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Legenda', ),
			),
			
			'defaultOrder' => $this->order,
			
			'showLog' => array('index', 'edit'),
			
			'containIndex' => array('Destino',),
			'containAddEdit' => array('Destino', ),
			
			'add_title' => 'Nova Foto',


			'allowFilter'	=> array(
				$this->alias.'.destino_id' => array(),
			),
			
			'defaultLimit' => 999999,

			'formParams' => array('enctype' => 'multipart/form-data'),
			
			'form'	=> array(
				'destino_id'	=> array('label' => 'Destino', 'options' => $this->options['destino_id'],),
				'titulo'		=> array('label' => 'Título', 'type' => 'text', 'limit' => 255),
				'friendly_url'	=> array('label' => 'Url Amigável', 'type' => 'text', 'limit' => 255, 'after' => '&nbsp;<small>Deixe em branco, caso queira defini-la automaticamente.</small>',),
				'legenda'		=> array('label' => 'Legenda','type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
				'arquivo'		=> array('label' => 'Arquivo', 'type' => 'file', 'multiple' => true, 'div' => 'input required', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_thumb' => array('size=120*90', 'crop=120x90'), 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
			),
		);
		
		return $setupAdmin;
	}
		
}