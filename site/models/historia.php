<?php
define('HISTORIAS_IMAGE_DIR', SITE_DIR.'webroot/img/upload/historias');

class Historia extends AppModel {

	var $name = 'Historia';
	var $displayField = 'titulo';

    var $order = 'data DESC';

	var $actsAs = array(
        'MeioUpload' => array('image' => array(
			'dir' => HISTORIAS_IMAGE_DIR,
			'url' => 'upload/historias',
        ),)
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
				
		$setupAdmin = array(
			'displayField' => $this->displayField,
			
			'searchFields' => array(
				'Historia.id',
				'Historia.data',
				'Historia.titulo',
				'Historia.descricao',
			),

			'topLink' => array(
				'Nova história' => array('url' => array('controller' => 'historias', 'action' => 'add'), 'htmlAttributes' => array()),
			),

			'listFields' => array(
            	'Historia.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Historia.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Título'),
			),

			'save_function' => 'saveAll',
			'save_params' => array('validate' => 'first',),
			'showLog' => array('index', 'edit'),

			'formParams' => array('enctype' => 'multipart/form-data'),
		);
		
		$setupAdmin['form'] = array(
			'data'	=> array('label' => 'Data', 'class' => 'dateMask', 'type' => 'text', 'default' => date('d/m/Y'), ),
			'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
			'descricao'		=> array('label' => 'conteudo', 'div' => 'ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15, ),
			'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/', 'after' => ' (<small>Recomendado: 400x400</small>)', ),
			'link'			=> array('label' => 'Link','after' => ' (<small>caminho completo com http://</small>)'),
			'destaque'		=> array('label' => 'Destaque', 'type' => 'checkbox', 'class'=>'switch', 'default' => '1', 'value' => '1'),
		);
		
		return $setupAdmin;
	}

	// public function __construct($id=false,$table=null,$ds=null){
	// 	parent::__construct($id,$table,$ds);
	// 	$this->virtualFields = array(
	// 		'titulo_olho' => "CONCAT('<b>', `{$this->alias}`.`titulo`, '</b><br />', `{$this->alias}`.`olho`)",
	// 		'data_db' => "`{$this->alias}`.`data`",
	// 	);
	// }
		
	// function afterFind($results){
	// 	App::import('Helper', 'text');
	// 	$text = new TextHelper;

	// 	// Define outros tipos de url
	// 	$tipos_url = array(
			
	// 	);

	// 	foreach($results AS $key=>$r){
	// 		if(!isset($r[$this->alias])){
	// 			if(isset($r['data'])){
	// 				$results[$key]['data_noticia'] = $r['data_noticia'] = date('d/m/Y h:i', strtotime($r['data_noticia']));
	// 				$results[$key]['data_noticia_data'] = substr($r['data_noticia'], 0, 10);
	// 				$results[$key]['data_noticia_ano'] = substr($r['data_noticia'], 6, 4);
	// 				$results[$key]['data_noticia_mes'] = substr($r['data_noticia'], 3, 2);
	// 				$results[$key]['data_noticia_dia'] = substr($r['data_noticia'], 0, 2);
	// 				$results[$key]['data_noticia_hora'] = str_replace(':', 'h', substr($r['data_noticia'], 11, 5));
	// 			}

	// 			if(isset($r['friendly_url']) && isset($r['data_noticia']) && isset($r['tipo'])){
	// 				$results[$key]['link'] =/* '/'.$tipos_url[$results[$key]['tipo']].*/'/'.$results[$key]['data_noticia_ano'].'/'.$results[$key]['data_noticia_mes'].'/'.$r['friendly_url'];
	// 			}
				
	// 			if(!empty($r['tipo']))
	// 				$results[$key]['tipo_formatado'] = $this->tipos[$r['tipo']];

	// 			if(!empty($r['status']))
	// 				$results[$key]['status_formatado'] = $this->status[$r['status']];
					
	// 			if(isset($r['categoria'])){
	// 				$results[$key]['categoria'] = explode(',', $r['categoria']);
	// 				$results[$key]['categoria_formatada'] = $text->toList(array_flip(array_intersect(array_flip($this->categorias),explode(',', $r['categoria']))), 'e');
	// 			}

	// 		}
	// 		else{
				
	// 			if(isset($r[$this->alias]['data_noticia'])){
	// 				$results[$key][$this->alias]['data_noticia_data'] = substr($r[$this->alias]['data_noticia'], 0, 10);
	// 				$results[$key][$this->alias]['data_noticia_ano'] = substr($r[$this->alias]['data_noticia'], 6, 4);
	// 				$results[$key][$this->alias]['data_noticia_mes'] = substr($r[$this->alias]['data_noticia'], 3, 2);
	// 				$results[$key][$this->alias]['data_noticia_dia'] = substr($r[$this->alias]['data_noticia'], 0, 2);
	// 				$results[$key][$this->alias]['data_noticia_hora'] = str_replace(':', 'h', substr($r[$this->alias]['data_noticia'], 11, 5));
	// 			}

	// 			if(isset($r[$this->alias]['friendly_url']) && isset($r[$this->alias]['data_noticia']) && isset($r[$this->alias]['tipo'])){
	// 				$results[$key][$this->alias]['link'] =/* '/'.$tipos_url[$r[$this->alias]['tipo']].*/'/'.$results[$key][$this->alias]['data_noticia_ano'].'/'.$results[$key][$this->alias]['data_noticia_mes'].'/'.$r[$this->alias]['friendly_url'];
	// 			}

	// 			if(!empty($r[$this->alias]['tipo']))
	// 				$results[$key][$this->alias]['tipo_formatado'] = $this->tipos[$r[$this->alias]['tipo']];
				
	// 			if(!empty($r[$this->alias]['status']))
	// 				$results[$key][$this->alias]['status_formatado'] = $this->status[$r[$this->alias]['status']];
				
	// 			if(isset($r[$this->alias]['categoria'])){
	// 				$results[$key][$this->alias]['categoria'] = explode(',', $r[$this->alias]['categoria']);
	// 			}
	// 		}
	// 	}
	// 	return $results;
	// }

	// function beforeSave($created){
	// 	parent::beforeSave($created);
	// 	if(!empty($this->data[$this->alias]['categoria'])){
	// 		$this->data[$this->alias]['categoria'] = implode(',', $this->data[$this->alias]['categoria']);
	// 	}else{
	// 		$this->data[$this->alias]['categoria'] = null;
	// 	}

	// 	return true;
	// }
	
	// function beforeValidate(){
	// 	parent::beforeValidate();
	// 	if(array_key_exists('friendly_url', $this->data[$this->alias])){
	// 		$this->data[$this->alias]['friendly_url'] = '';
	// 	}
	// 	return true;
	// }	
	// function beforeFind($queryData){
	// 	if(isset($queryData['conditions']['Noticia.categoria'])){
	// 		$queryData['conditions']['Noticia.categoria REGEXP'] = '(^|,)'.$queryData['conditions']['Noticia.categoria'].'(,|$)';
	// 		unset($queryData['conditions']['Noticia.categoria']);
	// 	}
	// 	return $queryData;
	// }
	
	// function getAnos(){
	// 	$anos = $this->find('all',array(
	// 		'fields'	=> array(
	// 			'DATE_FORMAT('.$this->alias.'.data_noticia, "%Y") as ano',
	// 		),
	// 		'conditions' => array('Noticia.status' => 'aprovada'), 
	// 		'group'		=> array('ano'),
	// 		'order'		=> 'ano DESC',
	// 	));
	// 	return Set::extract('/./0/ano',$anos);
	// }

	// function getMeses($ano){
	// 	$meses = $this->find('all',array(
	// 		'fields'	=> array(
	// 			'DATE_FORMAT('.$this->alias.'.data_noticia, "%m") as mes',
	// 		),
	// 		'conditions' => array('Noticia.data_noticia LIKE' => $ano.'-%', 'Noticia.status' => 'aprovada'), 
	// 		'group'		=> array('mes'),
	// 		'order'		=> 'mes ASC',
	// 	));
	// 	return Set::extract('/./0/mes',$meses);
	// }
	
}