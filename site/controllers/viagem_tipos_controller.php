<?php
class ViagemTiposController extends AppController {

	var $name = 'ViagemTipos';
	var $uses = array('ViagemTipo',);

	function index(){
		
		$viagem_tipos = $this->ViagemTipo->find('all', array(
			'contain' => array('Seo', 'Roteiro.id', 'Roteiro.nome', 'Roteiro.friendly_url', 'Roteiro.destino_id',),
		));

		//Agrupa destinos no tipo da viagem
		$destinos_path = array();
		foreach($viagem_tipos AS $key => $viagem_tipo){
			$destino_ids = Set::extract('/Roteiro/destino_id', $viagem_tipo);
			if(!empty($destino_ids)){
				$viagem_tipos[$key]['Destino'] = $this->ViagemTipo->Roteiro->Destino->find('all', array(
					'recursive' => -1,
					'fields' => array('id', 'nome'),
					'conditions' => array('Destino.id' => array_unique($destino_ids))
				));
				
				foreach($viagem_tipos[$key]['Destino'] AS $destino_key => $destino_value){
					//Ajusta chave do modelo
					$viagem_tipos[$key]['Destino'][$destino_key] = $destino_value['Destino'];
					
					if(!isset($destinos_path[$destino_value['Destino']['id']])){
						$viagem_tipos[$key]['Destino'][$destino_key]['fullpath'] = 
						$destinos_path[$destino_value['Destino']['id']] = 
							$this->ViagemTipo->Roteiro->Destino->getfullpath($destino_value['Destino']['id'], $separator = '/', $label = 'friendly_url')
						;
					}
					else{
						$viagem_tipos[$key]['Destino'][$destino_key]['fullpath'] = $destinos_path[$destino_value['Destino']['id']];
					}
				}
				
				//Aplica o caminho do roteiro
				foreach($destino_ids AS $roteiro_key => $destino_id){
					$viagem_tipos[$key]['Roteiro'][$roteiro_key]['fullpath'] = $destinos_path[$destino_id] . '/roteiros/' . $viagem_tipos[$key]['Roteiro'][$roteiro_key]['friendly_url'];
				}
			}
		}	
		
		$this->set('viagem_tipos', $viagem_tipos);
	}
}