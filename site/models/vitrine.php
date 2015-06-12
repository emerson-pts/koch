<?php
define('VITRINE_IMAGE_DIR', SITE_DIR.'webroot/img/upload/vitrines');

class Vitrine extends AppModel {

	var $name = 'Vitrine';
	var $displayField = 'titulo';
    var $order = 'Vitrine.peso DESC';

	var $actsAs = array(
        'MeioUpload' => array(
			'imagem' => array(
				'dir' => VITRINE_IMAGE_DIR,
				'url' => 'upload/vitrines',
				'length' => array(
					//'minWidth' => 853,
					//'maxWidth' => 962,
					//'minHeight' => 352,
					//'maxHeight' => 355,
					//'aspectRatio' => 0,
				),
			),
		),
		
	);
	
	
	var $validate = array(
		
	);

	public function __construct($id=false,$table=null,$ds=null){
		parent::__construct($id,$table,$ds);
		$this->virtualFields = array(
			'ativo' => "IF(
				(ISNULL(`{$this->alias}`.`data_inicio`) AND ISNULL(`{$this->alias}`.`data_fim`))
				OR (ISNULL(`{$this->alias}`.`data_inicio`) AND `{$this->alias}`.`data_fim` >= DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i'))
				OR (DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i') BETWEEN `{$this->alias}`.`data_inicio` AND `{$this->alias}`.`data_fim`)
				OR (ISNULL(`{$this->alias}`.`data_fim`) AND `{$this->alias}`.`data_inicio` <= DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i'))
				, 1, 0)",
		);
	}
	
	//Carrega Vitrine
	function getVitrine($limit = false, $order = array('Vitrine.peso ASC', 'Vitrine.id ASC',)){
		if(is_bool($order) && $order === true){
			$order = 'POW( RAND(), Banner.peso ) ASC'; //ordem aleatória levando em conta a prioridade de exibição
		}
		
		$params = array(
			'conditions' => array(
				array(
					array('OR' => array('Vitrine.data_inicio' => null, 'Vitrine.data_inicio <=' => date('Y-m-d H:i'))),
					array('OR' => array('Vitrine.data_fim' => null, 'Vitrine.data_fim >=' => date('Y-m-d H:i'))),
				),
			),
			'order' => $order,
			'limit'	=> $limit,
		);

		if(!empty($area)){
			$params['conditions']['Banner.area'] = $area;
		}

		return $this->find(($limit == 1 ? 'first' : 'all'), $params);
	}

	function setupAdmin($action = null, $id = null){

		$ckeditor_options = '
			{
				bodyClass: "carousel chromakey",
				enterMode: CKEDITOR.ENTER_BR,
				toolbar: [
					['.(Configure::read('Admin.editor.styles_set') ? '"Styles", ' : '').' "FontSize" ],
					["Bold","Italic","Underline","StrikeThrough","-","Subscript","Superscript"],
					["JustifyLeft","JustifyCenter","JustifyRight","JustifyBlock"],
					["TextColor","BGColor"],
					["Cut","Copy","PasteText"],
					["Undo","Redo","RemoveFormat"],
					["About"], ["Source"]
				]
			}
		';
		
		$setupAdmin = array(
			'displayField' => $this->displayField,
			
			'searchFields' => array(
				$this->alias.'.id',
				$this->alias.'.titulo',
				$this->alias.'.subtitulo',
			),
			
			'topLink' => array(
				'Nova Vitrine' => array('url' => array('action' => 'add'), 'htmlAttributes' => array()),
			),
			
			'defaultOrder' => array($this->alias.'.peso' => 'DESC', $this->alias.'.id' => 'DESC',),
						
			'containIndex' => false,
			'containAddEdit' => false,

			'formParams' => array('enctype' => 'multipart/form-data'),

			'form'=>array(
				'peso'			=> array('label' => 'Prioridade', 'type' => 'text', 'maxlength' => 2, 'size' => 5, 'after' => ' (<small>Utilizado para definir a prioridade de exibição</small>)', 'class' => 'txtbox-auto onlyNumber',),
				'titulo'		=> array('label' => 'Título', 'type' => 'text','maxlength'=>255),
				'chamada_position' => array('label' => 'Posição da chamada', 'default' => 'top-left', 'options' => array('top-left' => 'Superior esquerdo', 'top-right' => 'Superior direito', 'center-center' => 'Centro', 'bottom-left' => 'Inferior esquerdo', 'bottom-right' => 'Inferior direito',), ),
				'chamada'		=> array('label' => 'Chamada', 'div' => 'ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15,
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "VitrineChamada", ' . $ckeditor_options . ' );
							});
						</script>
					',
				),
/*				'chamada_sec'	=> array('label' => 'Chamada (secundária)', 'div' => 'ckeditor', 'class' => 'ckeditor', 'cols' => 50, 'rows' => 15, 
					'after' => '
						<script type="text/javascript">
							jQuery(document).ready(function(){
								CKEDITOR.replace( "VitrineChamadaSec", ' . $ckeditor_options . ' );
							});
						</script>
					',
				),
*/
				'url'			=> array('label' => 'Url',),
				'imagem'		=> array('label' => 'Imagem', 'type' => 'file', 'after' => '<small>(Tamanho sugerido 1600 x 940 pixels)</small>', 'show_remove' => true, 'show_preview' => '853x352', 'show_preview_url' => '/../'.str_replace('.admin', '', APP_DIR).'/thumbs/'), 
				'imagem_align'	=> array('label' => 'Alinhamento', 'default' => 'center', 'options' => array('center' => 'Centralizar', 'top' => 'Superior', 'bottom' => 'Inferior',)),
				'data_inicio' 	=> array('label' => 'Data de início', 'type' => 'text', 'class' => 'dateMaskDiaHora',),
				'data_fim' 		=> array('label' => 'Data de término', 'type' => 'text', 'class' => 'dateMaskDiaHora',),
			),
		);
		
		return $setupAdmin;
	}

}