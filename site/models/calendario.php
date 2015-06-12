<?php
define('CALENDARIO_IMAGE_DIR', SITE_DIR.'webroot/img/upload/calendarios');

class Calendario extends AppModel {

	var $name = 'Calendario';
	var $displayField = 'titulo';

	var $tipos = array('atleta' => 'Atleta', 'evento' => 'Evento',);

	var $actsAs = array(
        'MeioUpload' => array('image' => array(
			'dir' => CALENDARIO_IMAGE_DIR,
			'url' => 'upload/calendarios',
        ),)
    );

    var $hasMany=array(
    	'Cas' => array(
    		'className' => 'Cas',
			'foreignKey' => 'id',
    	),

    	'Area' => array(
    		'className' => 'Area',
			'foreignKey' => 'id',
    	),
    );

    var $belongsTo = array(
		'Case' => array(
			'className' => 'Cas',
			'foreignKey' => 'related_id',
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
		),

		'link' => array(
			'MinLength' => array(
				'rule'=>array('minLength',1),
				'required'=>true,
				'allowEmpty'=>false,
				'message'=>'O link está em branco.',
			),
		),
		
		'data' => array(
			'rule'=>array('date','dmy'),
			'required'=>true,
			'allowEmpty'=>false,
			'message'=>'Data inválida',
		),

		// 'data_fim' => array(
		// 	'rule'=>array('date','dmy'),
		// 	'required'=>false,
		// 	'allowEmpty'=>false,
		// 	'message'=>'Data inválida',
		// ),

	);

	function setupAdmin($action = null, $id = null){

		//Lê dados do usuário e armazena na variável usuario do modelo
		App::import('Core', 'CakeSession'); 
        $session = new CakeSession(); 
		if(!$session->started())$session->start();
		$this->usuario = $session->read('Auth.Usuario');
		
		
		
		$setupAdmin = array(
			'displayField' => $this->displayField,
			
			'searchFields' => array(
				'Calendario.id',
				'Calendario.data',
				'Calendario.data_fim',
				'Calendario.created',
				'Calendario.titulo',
			),
			
			'topLink' => array(
				'Novo evento' => array('url' => array('controller' => 'calendarios', 'action' => 'add'), 'htmlAttributes' => array()),
			),
			
			'listFields' => array(
				'Calendario.id' => array('table_head_cell_param' => 'class="text-align-center" width="70"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Código'),
				'Calendario.data_inicio_fim' => array('table_head_cell_param' => 'class="text-align-left" width="70"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Data', 'sort'=> 'Calendario.data_inicio',),
				'Calendario.hora' => array('table_head_cell_param' => 'class="text-align-left" width="0"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Hora','no_sort'=>true),
				'Calendario.destaque_formatado' => array('table_head_cell_param' => 'class="text-align-center" width="80"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Destaque','no_sort'=>true ),
				'Calendario.tipo_formatado' => array('table_head_cell_param' => 'class="text-align-center" width="100"', 'table_body_cell_param' => 'class="text-align-center"', 'label' => 'Tipo'),
				'Calendario.titulo' => array('table_head_cell_param' => 'class="text-align-left"', 'table_body_cell_param' => 'class="text-align-left"', 'label' => 'Título','no_sort'=>true),
			),
			
			'defaultOrder' => array($this->alias.'.data' => 'ASC',),

//			'showLog' => array('index', 'edit'),

			'containIndex' => array(),
			'containAddEdit' => array(),

	/*		'box_order' => array(
				'Noticia.id' => 'Código',
				'Noticia.titulo' => 'Título',
			),
	*/		
			'box_filter' => array(
				'Calendario.tipo' => array('title' => 'Filtrar tipo', 'options' => array('*' => 'Todos',) + $this->tipos,),
				'Calendario.destaque' => array('title' => 'Filtrar destaque', 'options' => array('*' => 'Todos', '1' => 'Sim', '0' => 'Não')),
			),

			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'	=> array(
				//'tipo'			=> array('label' => 'Tipo',  'type' => 'select', 'options' => $this->tipos),
				//'parent_id'		=> array('label' => 'Area de atuação', 'type'=> 'select', 'empty' => '--Selecione a area de atuação --', 'after' => ' (se o evento for específico de uma Area de atuação, selecione-a ao lado)<span class="clearFix">&nbsp;</span>', 'options' => $this->Area->find('list', array('fields'=>'Area.titulo'))),
				//'related_id'	=> array('label' => 'Case', 'type'=> 'select', 'empty' => '--Selecione o case --', 'options' => $this->Cas->find('list', array('fields'=>'Cas.titulo'))),
				'data'			=> array('label' => 'Data', 'class' => 'dateMask datepicker', 'type' => 'text', 'default' => date('d/m/Y'), ),
				'data_fim'		=> array('label' => 'Data término', 'class' => 'dateMask datepicker', 'type' => 'text', ),
				#'hora'			=> array('label' => 'Hora','class'=>'hourMask'),
				#'destaque'		=> array('label' => 'Destaque', 'type' => 'checkbox', 'class'=>'switch', 'default' => '0', 'value' => '1'),
				#'feriado'		=> array('label' => 'Feriado', 'type' => 'checkbox', 'class'=>'switch', 'default' => '0', 'value' => '1'),
				//'tipo'			=> array('label' => 'Tipo', 'multiple'=> 'checkbox', 'div' => 'input checkbox', 'options' => $this->tipos,'after' => '(se o evento for específico de uma grade escolar, selecione-a ao lado)<span class="clearFix">&nbsp;</span>'),
				'titulo'		=> array('label' => 'Título', 'type' => 'textarea', 'cols' => 50, 'rows' => 6, 'limit' => 255),
				'link'		=> array('label' => 'Link', 'type' => 'text', ),
				#'image'			=> array('label' => 'Imagem', 'type' => 'file', 'show_remove' => true, 'show_preview' => '640x480', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'),
				//'image_legenda'	=> array('label' => 'Legenda',),
				//'descricao_preview'	=> array('label' => 'Preview da descrição', 'cols' => 50, 'rows' => 6,),
				'descricao'		=> array('label' => 'Descrição', 'div' => 'ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15, ),
			),
		);
		return $setupAdmin;
	}

	public function __construct($id=false,$table=null,$ds=null){
		parent::__construct($id,$table,$ds);
		$this->virtualFields = array(
			'destaque_formatado' => 'IF(`'.$this->alias.'`.`destaque` = "1", "Sim", "Não")',
			'data_inicio_fim' => 'IF(NOT ISNULL(`'.$this->alias.'`.`data_fim`), CONCAT(DATE_FORMAT(`'.$this->alias.'`.`data`, "%d/%m/%Y"), " até ", DATE_FORMAT(`'.$this->alias.'`.`data_fim`, "%d/%m/%Y")), DATE_FORMAT(`'.$this->alias.'`.`data`, "%d/%m/%Y"))',
		);
	}

	function afterFind($results){
		App::import('Helper', 'text');
		$text = new TextHelper;
		foreach($results AS $key=>$r){
			if(!isset($r[$this->alias])){
				if(isset($r['data'])){
					$results[$key]['data'] = $r['data'] = date('d/m/Y', strtotime($r['data']));
					$results[$key]['data_ano'] = substr($r['data'], 6, 4);
					$results[$key]['data_mes'] = substr($r['data'], 3, 2);
					$results[$key]['data_dia'] = substr($r['data'], 0, 2);
					$results[$key]['data_mes_ex'] = $r['data'] = date('M', substr($r['data'], 3, 2));
				}
				if(isset($r['data_fim'])){
					$results[$key]['data'] = $r['data_fim'] = date('d/m/Y', strtotime($r['data_fim']));
					$results[$key]['data_fim_ano'] = substr($r['data_fim'], 6, 4);
					$results[$key]['data_fim_mes'] = substr($r['data_fim'], 3, 2);
					$results[$key]['data_fim_dia'] = substr($r['data_fim'], 0, 2);
					$results[$key]['data_fim_mes_ex'] = $r['data_fim'] = date('M', substr($r['data_fim'], 3, 2));
				}
				if(isset($r['tipo'])){
					$results[$key]['tipo'] = explode(',', $r['tipo']);
					$results[$key]['tipo_formatado'] = $text->toList(array_flip(array_intersect(array_flip($this->tipos),explode(',', $r['tipo']))), 'e');
				}
			}
			else {

				if(isset($r[$this->alias]['data'])) {
					$results[$key][$this->alias]['data_ano'] = substr($r[$this->alias]['data'], 6, 4);
					$results[$key][$this->alias]['data_mes'] = substr($r[$this->alias]['data'], 3, 2);
					$results[$key][$this->alias]['data_dia'] = substr($r[$this->alias]['data'], 0, 2);

					switch (substr($r[$this->alias]['data'], 3, 2)) {
				        case "01":    $mes = 'JANEIRO';   break;
				        case "02":    $mes = 'FEVEREIRO';   break;
				        case "03":    $mes = 'MARÇO';   break;
				        case "04":    $mes = 'ABRIL';   break;
				        case "05":    $mes = 'MAIO';   break;
				        case "06":    $mes = 'JUNHO';   break;
				        case "07":    $mes = 'JULHO';   break;
				        case "08":    $mes = 'AGOSTO';   break;
				        case "09":    $mes = 'SETEMBRO';   break;
				        case "10":    $mes = 'OUTUBRO';   break;
				        case "11":    $mes = 'NOV';   break;
				        case "12":    $mes = 'DEZ';   break; 
					}

					$results[$key][$this->alias]['data_mes_ex'] = $mes;

				}

				if(isset($r[$this->alias]['data_fim'])) {
					$results[$key][$this->alias]['data_fim_ano'] = substr($r[$this->alias]['data_fim'], 6, 4);
					$results[$key][$this->alias]['data_fim_mes'] = substr($r[$this->alias]['data_fim'], 3, 2);
					$results[$key][$this->alias]['data_fim_dia'] = substr($r[$this->alias]['data_fim'], 0, 2);

					switch (substr($r[$this->alias]['data_fim'], 3, 2)) {
				        case "01":    $mes = 'JAN';   break;
				        case "02":    $mes = 'FEV';   break;
				        case "03":    $mes = 'MAR';   break;
				        case "04":    $mes = 'ABR';   break;
				        case "05":    $mes = 'MAI';   break;
				        case "06":    $mes = 'JUN';   break;
				        case "07":    $mes = 'JUL';   break;
				        case "08":    $mes = 'AGO';   break;
				        case "09":    $mes = 'SET';   break;
				        case "10":    $mes = 'OUT';   break;
				        case "11":    $mes = 'NOV';   break;
				        case "12":    $mes = 'DEZ';   break; 
					}

					$results[$key][$this->alias]['data_fim_mes_ex'] = $mes;
				}

				if(isset($r[$this->alias]['tipo'])) {
					$results[$key][$this->alias]['tipo'] = explode(',', $r[$this->alias]['tipo']);
					$results[$key][$this->alias]['tipo_formatado'] = $text->toList(array_flip(array_intersect(array_flip($this->tipos),explode(',', $r[$this->alias]['tipo']))), 'e');
				}

			}
		}
		return $results;
	}

	// function beforeSave(){
	// 	if(!empty($this->data[$this->alias]['tipo'])){
	// 		$this->data[$this->alias]['tipo'] = implode(',', $this->data[$this->alias]['tipo']);
	// 	}else{
	// 		$this->data[$this->alias]['tipo'] = null;
	// 	}
	// 	return true;
	// }
	
	function getAnos(){
		$anos = $this->find('all',array(
			'fields'	=> array(
				'DATE_FORMAT('.$this->alias.'.data, "%Y") as ano',
			),
			'group'		=> array('ano'),
			'order'		=> 'ano DESC',
		));
		
		return Set::extract('/./0/ano',$anos);
	}

	function getMeses($ano){
		$meses = $this->find('all',array(
			'fields'	=> array(
				'DATE_FORMAT('.$this->alias.'.data, "%m") as mes',
			),
			'conditions' => array('Calendario.data LIKE' => $ano.'-%'), 
			'group'		=> array('mes'),
			'order'		=> 'mes ASC',
		));
		return Set::extract('/./0/mes',$meses);
	}

}