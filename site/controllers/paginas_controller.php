<?php
class PaginasController extends AppController {

	var $name = 'Paginas';
	var $uses = array('Pagina');

	function index($friendly_url = null) {

		//Se não informou a página...
		if (!$friendly_url) {
			echo 'nao encontrado';

			$this->Session->setFlash(__('Ops! Página não encontrada', true),'default',array('class'=>'message_error'));
			$this->redirect('index');
		}

		//Tenta localizar a página
		$pagina = $this->Pagina->find('first',array('conditions'=>array(
			'Pagina.friendly_url' => $friendly_url
		)));

		//Não encontrou...
		if (!$pagina) {
			//Página não encontrada
			$this->cakeError('error404');
			return;
		}

		//Recupera SEO dos destinos
		if(!empty($pagina['Seo'])) {
			$this->params['seo'][] = array('Seo' => $pagina['Seo']);
		}

		if(empty($pagina['Seo']['title'])) {
			//Seta título da página com o título
//			$this->set('title_for_layout', $pagina['Pagina']['titulo']);
		}

		$this->set(compact('pagina'));

	}

}