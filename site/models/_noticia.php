<?php
define('NOTICIA_IMAGE_DIR', SITE_DIR.'webroot/img/upload/noticias');

class Noticia extends AppModel {

	var $name = 'Noticia';
	var $displayField = 'titulo';

	var	$status = array('rascunho' => 'Rascunho', 'em_aprovação' => 'Em Aprovação', 'aprovada' => 'Aprovada',); 
	var $tipos = array('blog' => 'Blog', /*'noticia' => 'Notícia'*/);
	var $categorias = array( /*'noticia' => 'Notícia'*/);
	//var $options = array();

    var $order = 'data_noticia DESC';
	
	var $actsAs = array(
        'MeioUpload' => array('image' => array(
			'dir' => NOTICIA_IMAGE_DIR,
			'url' => 'upload/noticias',
        ),)
    );

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
        'NoticiaRelacionada' => array(
			'className' => 'Noticia',
			'order'		=> 'NoticiaRelacionada.data_noticia DESC',
			'joinTable' => 'noticias_noticias',
			'foreignKey' => 'noticia_id',
			'associationForeignKey' => 'related_id',
			'fields' => array('id', 'tipo', 'titulo', 'friendly_url', 'data_noticia', 'conteudo_preview'),
		),
		
		'VideoRelacionado' => array(
			'className' => 'Video',
			'order'		=> 'VideoRelacionado.data DESC',
			'joinTable' => 'noticias_videos',
			'foreignKey' => 'noticia_id',
			'associationForeignKey' => 'video_id',
			'fields' => array('id', 'titulo', 'descricao', 'data', 'embed'),
		),
		
		'GaleriaRelacionada' => array(
			'className' => 'Galeria',
			'order'		=> 'GaleriaRelacionada.data DESC',
			'joinTable' => 'noticias_galerias',
			'foreignKey' => 'noticia_id',
			'associationForeignKey' => 'galeria_id',
			'fields' => array('id', 'label', 'data', 'descricao', 'imagem_capa', 'friendly_url'),
		),

		'DestinoRelacionado' => array(
			'className' => 'DestinoFlat',
			'order'		=> 'DestinoRelacionado.nome DESC',
			'joinTable' => 'noticias_destinos',
			'foreignKey' => 'noticia_id',
			'associationForeignKey' => 'destino_id',
			'fields' => array('id', 'status', 'nome', 'friendly_url'),
		),
	);

	
	var $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $validate = array(
		'image' => array(
			'Empty' => array(
				'check' => false,
			),
		),
		
		'titulo' => array(
			'MinLength' => array(
				'rule'=>array('minLength',1),
				'required'=>true,
				'allowEmpty'=>false,
				'message'=>'O título está em branco.',
			),
			'friendly_url' => array(
				'rule' => 'friendly_url_validate',
				'required'=>true,
				'allowEmpty'=>false,
				'message'=> 'Não foi possível gerar uma url amigável.',
			),
		),
	);

	function setupAdmin($action = null, $id = null){

		//Lê dados do usuário e armazena na variável usuario do modelo
		App::import('Core', 'CakeSession'); 
        $session = new CakeSession(); 
		if(!$session->started())$session->start();
		$this->usuario = $session->read('Auth.Usuario');

		$align 	= array('left' => 'Esquerda', 'center' => 'Centro', 'right' => 'Direita',);
				
		$setupAdmin = array(
			'displayField' => $this->displayField,
			
			'searchFields' => array(
				'Noticia.id',
				'Noticia.data_noticia',
				'Noticia.created',
				'Noticia.titulo',
				'Noticia.olho',
				'Noticia.conteudo',
			),
			
			'topLink' => array(
				'Nova notícia' => array('url' => array('controller' => 'noticias', 'action' => 'add'), 'htmlAttributes' => array()),
			),
			
			'listFields' => array(
              //'Noticia.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
//				'Noticia.tipo' => array('table_head_cell_param' => 'class="text-align-left" width="100"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Tipo', ),
				'Noticia.data_noticia' => array('table_head_cell_param' => 'class="text-align-left" width="80"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Data', ),
				'Noticia.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Título/Olho'),
				'Usuario.apelido' => array('table_head_cell_param' => 'class="text-align-left" width="80"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Apelido'),
				'Noticia.status_formatado' => array('table_head_cell_param' => 'class="text-align-left" width="80"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Status'),
			),
			
			'defaultOrder' => array($this->alias.'.data_noticia' => 'DESC',),
			
		    //'showLog' => array('index', 'edit'),
			
			'containIndex' => array('Usuario', 'DestinoRelacionado',),
			'containAddEdit' => array('NoticiaRelacionada', 'VideoRelacionado', 'GaleriaRelacionada', 'DestinoRelacionado',),
			
			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),
			
			/*
			'box_order' => array(
				'Noticia.id' => 'Código',
				'Noticia.titulo' => 'Título',
			),
			*/		

			'box_filter' => array(
				'Noticia.status' => array('title' => 'Filtrar status', 'options' => array('*' => 'Todos',) + $this->status,),
				'Noticia.usuario_id' => array('title' => 'Filtrar autor', 'options' => array('*' => 'Todos',) + $this->Usuario->find('list', array('order' => 'apelido'))),
				//'Noticia.categoria' => array('title' => 'Filtrar categoria', 'options' => array('*' => 'Todos',) + $this->categorias,),
			),
			
			'formParams' => array('enctype' => 'multipart/form-data'),
		);

		$setupAdmin['form'] = array(
			'tipo'			=> array('label' => 'Tipo',  'type' => 'select', 'default' => 'noticia', 'options' => $this->tipos),
			'data_noticia'	=> array('label' => 'Data da Notícia', 'class' => 'dateMaskDiaHora', 'type' => 'text', 'default' => date('d/m/Y H:i'), ),
			'status'		=> array('label' => 'Status', 'type'=> 'select', 'default' => key($this->status), 'options' => $this->status),
			'usuario_id'	=> array('label' => 'Autor', 'type'=> 'select', 'empty' => '--Selecione o autor--', 'default' => $this->usuario['id'], 'options' => $this->Usuario->find('list', array('order'=>'Usuario.status DESC, Usuario.nome'))),
		);
		
		if(!empty($this->categorias)){
			$setupAdmin['form']['categoria'] = array('label' => 'Categoria', 'multiple'=> 'checkbox', 'div' => 'input checkbox short', 'options' => $this->categorias,'before' => '<span class="right">(se a notícia for específica de uma categoria, selecione-a ao lado)</span>', 'after' => '<span class="clearFix">&nbsp;</span>');
		}
		
		$setupAdmin['form'] += array(	
			'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
			'olho'			=> array('label' => 'Olho', 'cols' => 50, 'rows' => 6,),
			'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
			'image_align'	=> array('label' => 'Alinhamento', 'type'=> 'select', 'default' => key($align), 'options' => $align),
			'image_legenda'	=> array('label' => 'Legenda',),
			'conteudo_preview'	=> array('label' => 'Preview do conteúdo', 'cols' => 50, 'rows' => 6,),
			'conteudo'		=> array('label' => 'Notícia', 'div' => 'ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15, ),
		);
		
		return $setupAdmin;
	}

	public function __construct($id=false,$table=null,$ds=null){
		parent::__construct($id,$table,$ds);
		$this->virtualFields = array(
			'titulo_olho' => "CONCAT('<b>', `{$this->alias}`.`titulo`, '</b><br />', `{$this->alias}`.`olho`)",
			'data_noticia_db' => "`{$this->alias}`.`data_noticia`",
		);
	}
		
	function afterFind($results){
		App::import('Helper', 'text');
		$text = new TextHelper;

		// Define outros tipos de url
		$tipos_url = array(
			
		);

		foreach($results AS $key=>$r){
			if(!isset($r[$this->alias])){
				if(isset($r['data_noticia'])){
					$results[$key]['data_noticia'] = $r['data_noticia'] = date('d/m/Y h:i', strtotime($r['data_noticia']));
					$results[$key]['data_noticia_data'] = substr($r['data_noticia'], 0, 10);
					$results[$key]['data_noticia_ano'] = substr($r['data_noticia'], 6, 4);
					$results[$key]['data_noticia_mes'] = substr($r['data_noticia'], 3, 2);
					$results[$key]['data_noticia_dia'] = substr($r['data_noticia'], 0, 2);
					$results[$key]['data_noticia_hora'] = str_replace(':', 'h', substr($r['data_noticia'], 11, 5));
				}

				if(isset($r['friendly_url']) && isset($r['data_noticia']) && isset($r['tipo'])){
					$results[$key]['link'] =/* '/'.$tipos_url[$results[$key]['tipo']].*/'/'.$results[$key]['data_noticia_ano'].'/'.$results[$key]['data_noticia_mes'].'/'.$r['friendly_url'];
				}
				
				if(!empty($r['tipo']))
					$results[$key]['tipo_formatado'] = $this->tipos[$r['tipo']];

				if(!empty($r['status']))
					$results[$key]['status_formatado'] = $this->status[$r['status']];
					
				if(isset($r['categoria'])){
					$results[$key]['categoria'] = explode(',', $r['categoria']);
					$results[$key]['categoria_formatada'] = $text->toList(array_flip(array_intersect(array_flip($this->categorias),explode(',', $r['categoria']))), 'e');
				}

			}
			else{
				
				if(isset($r[$this->alias]['data_noticia'])){
					$results[$key][$this->alias]['data_noticia_data'] = substr($r[$this->alias]['data_noticia'], 0, 10);
					$results[$key][$this->alias]['data_noticia_ano'] = substr($r[$this->alias]['data_noticia'], 6, 4);
					$results[$key][$this->alias]['data_noticia_mes'] = substr($r[$this->alias]['data_noticia'], 3, 2);
					$results[$key][$this->alias]['data_noticia_dia'] = substr($r[$this->alias]['data_noticia'], 0, 2);
					$results[$key][$this->alias]['data_noticia_hora'] = str_replace(':', 'h', substr($r[$this->alias]['data_noticia'], 11, 5));
				}

				if(isset($r[$this->alias]['friendly_url']) && isset($r[$this->alias]['data_noticia']) && isset($r[$this->alias]['tipo'])){
					$results[$key][$this->alias]['link'] =/* '/'.$tipos_url[$r[$this->alias]['tipo']].*/'/'.$results[$key][$this->alias]['data_noticia_ano'].'/'.$results[$key][$this->alias]['data_noticia_mes'].'/'.$r[$this->alias]['friendly_url'];
				}

				if(!empty($r[$this->alias]['tipo']))
					$results[$key][$this->alias]['tipo_formatado'] = $this->tipos[$r[$this->alias]['tipo']];
				
				if(!empty($r[$this->alias]['status']))
					$results[$key][$this->alias]['status_formatado'] = $this->status[$r[$this->alias]['status']];
				
				if(isset($r[$this->alias]['categoria'])){
					$results[$key][$this->alias]['categoria'] = explode(',', $r[$this->alias]['categoria']);
				}
			}
		}
		return $results;
	}

	function beforeSave($created){
		parent::beforeSave($created);
		if(!empty($this->data[$this->alias]['categoria'])){
			$this->data[$this->alias]['categoria'] = implode(',', $this->data[$this->alias]['categoria']);
		}else{
			$this->data[$this->alias]['categoria'] = null;
		}

		return true;
	}
	
	function beforeValidate(){
		parent::beforeValidate();
		if(array_key_exists('friendly_url', $this->data[$this->alias])){
			$this->data[$this->alias]['friendly_url'] = '';
		}
		return true;
	}	
	function beforeFind($queryData){
		if(isset($queryData['conditions']['Noticia.categoria'])){
			$queryData['conditions']['Noticia.categoria REGEXP'] = '(^|,)'.$queryData['conditions']['Noticia.categoria'].'(,|$)';
			unset($queryData['conditions']['Noticia.categoria']);
		}
		return $queryData;
	}
	
	function getAnos(){
		$anos = $this->find('all',array(
			'fields'	=> array(
				'DATE_FORMAT('.$this->alias.'.data_noticia, "%Y") as ano',
			),
			'conditions' => array('Noticia.status' => 'aprovada'), 
			'group'		=> array('ano'),
			'order'		=> 'ano DESC',
		));
		return Set::extract('/./0/ano',$anos);
	}

	function getMeses($ano){
		$meses = $this->find('all',array(
			'fields'	=> array(
				'DATE_FORMAT('.$this->alias.'.data_noticia, "%m") as mes',
			),
			'conditions' => array('Noticia.data_noticia LIKE' => $ano.'-%', 'Noticia.status' => 'aprovada'), 
			'group'		=> array('mes'),
			'order'		=> 'mes ASC',
		));
		return Set::extract('/./0/mes',$meses);
	}
	
}