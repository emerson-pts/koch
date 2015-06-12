<?php
class CalendariosController extends AppController {

	var $name = 'Calendarios';
	var	$cacheAction = false;

	function index($filtro_ano = null, $filtro_mes = null) {

		if(empty($filtro_ano) && !empty($this->params['originalArgs']['params']['pass'][1]))$filtro_ano = $this->params['originalArgs']['params']['pass'][1];
		if(empty($filtro_mes) && !empty($this->params['originalArgs']['params']['pass'][2]))$filtro_mes = $this->params['originalArgs']['params']['pass'][2];

		//Seta filtros padrões
		if(empty($filtro_ano))$filtro_ano = date('Y');
		if(empty($filtro_mes))$filtro_mes = date('m');

		if(!empty($this->params['originalArgs']['params']['pass'][1])) {

			if($this->params['originalArgs']['params']['pass'][1] == 'anteriores') {

				$filtro_ano = date('Y');
				$filtro_mes = date('m');

				//eventos anteriores
				$params = array(
					'order' => array('Calendario.data asc', 'Calendario.hora asc'),
					'conditions' => array(
						array('OR' => array(
							'Calendario.data <' => $filtro_ano.'-'.$filtro_mes.'-%',
							'Calendario.data_fim <' => $filtro_ano.'-'.$filtro_mes.'-%',
							),
						),
					),
				);
			}

			else if($this->params['originalArgs']['params']['pass'][1] == 'proximos') {

				$filtro_ano = date('Y');
				$filtro_mes = date('m');
				//proximos eventos
				$params = array(
					'order' => array('Calendario.data asc', 'Calendario.hora asc'),
					'conditions' => array(
						array('OR' => array(
							'Calendario.data >' => $filtro_ano.'-'.$filtro_mes.'-%',
							'Calendario.data_fim >' => $filtro_ano.'-'.$filtro_mes.'-%',
							),
						),
					),
				);
			}

		} else {

			$params = array(
				'order' => array('Calendario.data asc', 'Calendario.hora asc'),
				'conditions' => array(
					array('OR' => array(
						'Calendario.data >' => $filtro_ano.'-'.$filtro_mes.'-%',
						'Calendario.data_fim >' => $filtro_ano.'-'.$filtro_mes.'-%',
						),
					),
					//'Calendario.tipo LIKE' => !empty($this->params['named']['tipo'])?$this->params['named']['tipo']:'%',
				),
				//'contain' => false,
			);

		}

		if(!empty($this->params['named']['tipo'])) {
			if(isset($this->Calendario->tipos[$this->params['named']['tipo']]))
				$params['conditions'][] = array('OR' => array(
					'Calendario.tipo' => null,
					'Calendario.tipo REGEXP' => '(^|,)'.$this->params['named']['tipo'].'(,|$)',
				));
			else
				unset($this->params['named']['tipo']);
		}

		#print_r($params);
		#die;

		/*
		$calendarios = $this->Calendario->find('all', array(
			'order' => array('Calendario.data ASC', 'Calendario.hora ASC'),
			'conditions' => array(
				'OR' => array(
					'Calendario.data LIKE' => date('Y-m').'-%',
					'Calendario.data_fim LIKE' => date('Y-m').'-%',
				),
			),
			'contain' => array(),
		));*/

		$calendarios = $this->Calendario->find('all', $params);

		$this->set('calendario_ano', $filtro_ano);
		$this->set('calendario_mes', $filtro_mes);

		//Se é ajax, não traz o layout
		if ($this->RequestHandler->isAjax()  ) {
			$this->layout = null;
			$this->helpers[] = 'Calendar';
			$this->set('calendarios', $calendarios);
			$this->set('calendario_ano', $filtro_ano);
			$this->set('calendario_mes', $filtro_mes);

			$this->render('/elements/calendario');
			return;
		}

		$filtro_anos=$this->Calendario->getAnos();

		//Se o ano enviado não tem na lista
		if(is_numeric($filtro_ano) && !in_array($filtro_ano, $filtro_anos)){
			$filtro_anos[] = $filtro_ano;
			rsort($filtro_anos);
		}

		//eventos anteriores
		$params_prev = array(
			'order' => array('Calendario.data asc', 'Calendario.hora asc'),
			'conditions' => array(
				array('OR' => array(
					'Calendario.data <' => $filtro_ano.'-'.$filtro_mes.'-%',
					'Calendario.data_fim <' => $filtro_ano.'-'.$filtro_mes.'-%',
					),
				),
				//'Calendario.tipo LIKE' => !empty($this->params['named']['tipo'])?$this->params['named']['tipo']:'%',
			),
			//'contain' => false,
		);

		#print_r($params_prev_nex);

		$prev = $this->Calendario->find('all',$params_prev);

		//proximos eventos
		$params_prox = array(
			'order' => array('Calendario.data asc', 'Calendario.hora asc'),
			'conditions' => array(
				array('OR' => array(
					'Calendario.data >' => $filtro_ano.'-'.$filtro_mes.'-%',
					'Calendario.data_fim >' => $filtro_ano.'-'.$filtro_mes.'-%',
					),
				),
				//'Calendario.tipo LIKE' => !empty($this->params['named']['tipo'])?$this->params['named']['tipo']:'%',
			),
			//'contain' => false,
		);

		#print_r($params_prev_nex);

		$prox = $this->Calendario->find('all',$params_prox);

		$this->set('title_for_layout', 'Calendario');

		$this->set(compact('calendarios', 'filtro_ano', 'filtro_mes', 'filtro_anos'));

	}

}